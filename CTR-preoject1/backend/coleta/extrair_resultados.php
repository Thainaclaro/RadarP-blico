
<?php

if (PHP_SAPI !== "cli") {
    header("Content-Type: application/json; charset=UTF-8");
}

$arquivo = __DIR__ . "/resposta_dou.html";

if (!file_exists($arquivo)) {
    echo json_encode(["erro" => "Arquivo não encontrado"]);
    exit;
}

$html = file_get_contents($arquivo);

$padrao = '/<script id="_br_com_seatecnologia_in_buscadou_BuscaDouPortlet_params" type="application\/json">\s*(.*?)\s*<\/script>/s';

if (!preg_match($padrao, $html, $matches)) {
    echo json_encode(["erro" => "Resultados não encontrados"]);
    exit;
}

$dados = json_decode($matches[1], true);

if (!is_array($dados) || !isset($dados["jsonArray"])) {
    echo json_encode(["erro" => "Erro ao interpretar os resultados"]);
    exit;
}

$resultados = $dados["jsonArray"];
$candidatos = [];

foreach ($resultados as $item) {

    $titulo = strip_tags($item["title"] ?? "");
    $conteudo = strip_tags($item["content"] ?? "");
    $tipo = $item["artType"] ?? "";

    $texto = $titulo . " " . $conteudo;

    $categoria = "outra_publicacao";

    // Retificações
    if (
        stripos($tipo, "Retificação") !== false ||
        preg_match('/retificação|retifica/i', $texto)
    ) {
        $categoria = "retificacao";

    // Convocações
    } elseif (
        stripos($tipo, "Convocação") !== false ||
        preg_match('/convocação de candidatos|convoca os candidatos/i', $texto)
    ) {
        $categoria = "convocacao";

    // Resultados
    } elseif (
        stripos($tipo, "Resultado") !== false ||
        preg_match('/resultado final|homologação do resultado/i', $texto)
    ) {
        $categoria = "resultado";

    // Nomeações
    } elseif (
        preg_match('/nomeia|nomeação|nomear/i', $texto)
    ) {
        $categoria = "nomeacao";

    // Exonerações
    } elseif (
        preg_match('/exonera|exoneração/i', $texto)
    ) {
        $categoria = "exoneracao";

    // Possíveis editais de abertura
    } elseif (
        stripos($tipo, "Edital de Concurso Público") !== false ||
        preg_match('/edital de abertura|abertura de inscrições|abre inscrições|inscrições abertas/i', $texto)
    ) {
        $categoria = "possivel_abertura";

    // Menções genéricas
    } elseif (
        preg_match('/concurso público|processo seletivo|provimento de vagas/i', $texto)
    ) {
        $categoria = "mencao_concurso";
    }

    if ($categoria === "outra_publicacao") {
        continue;
    }

    $candidatos[] = [
        "titulo" => $titulo,
        "orgao" => $item["hierarchyStr"] ?? "",
        "data" => $item["pubDate"] ?? "",
        "tipo" => $tipo,
        "categoria" => $categoria,
        "conteudo" => $conteudo,
        "link" => "https://www.in.gov.br/web/dou/-/"
            . ($item["urlTitle"] ?? "")
    ];
}

echo json_encode([
    "total_publicacoes_analisadas" => count($resultados),
    "possiveis_concursos" => count($candidatos),
    "resultados" => $candidatos
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

