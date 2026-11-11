<?php

if (PHP_SAPI !== "cli") {
    header("Content-Type: application/json; charset=UTF-8");
}

$arquivos = [
    __DIR__ . "/resposta_dou_pagina1.html",
    __DIR__ . "/resposta_dou_pagina2.html",
    __DIR__ . "/resposta_dou_pagina3.html"
];

$publicacoesUnicas = [];
$candidatos = [];

$padrao = '/<script id="_br_com_seatecnologia_in_buscadou_BuscaDouPortlet_params" type="application\/json">\s*(.*?)\s*<\/script>/s';

foreach ($arquivos as $arquivo) {

    if (!file_exists($arquivo)) {
        continue;
    }

    $html = file_get_contents($arquivo);

    if (!preg_match($padrao, $html, $matches)) {
        continue;
    }

    $dados = json_decode($matches[1], true);

    if (!is_array($dados) || !isset($dados["jsonArray"])) {
        continue;
    }

    foreach ($dados["jsonArray"] as $item) {

        $id = $item["classPK"] ?? null;

        if ($id === null) {
            continue;
        }

        // Evita publicações duplicadas
        $publicacoesUnicas[$id] = $item;
    }
}

foreach ($publicacoesUnicas as $item) {

    $titulo = strip_tags($item["title"] ?? "");
    $conteudo = strip_tags($item["content"] ?? "");
    $tipo = $item["artType"] ?? "";

    $texto = $titulo . " " . $conteudo;

    
$categoria = "outra_publicacao";

// Primeiro, identifica movimentações de concursos existentes.
if (
    preg_match('/retifica|retificação/i', $texto)
) {
    $categoria = "retificacao";

} elseif (
    preg_match('/convocação|convoca os candidatos/i', $texto)
) {
    $categoria = "convocacao";

} elseif (
    preg_match('/resultado final|homologação do resultado/i', $texto)
) {
    $categoria = "resultado";

} elseif (
    preg_match('/nomeia|nomeação|nomear/i', $texto)
) {
    $categoria = "nomeacao";

} elseif (
    preg_match('/exonera|exoneração/i', $texto)
) {
    $categoria = "exoneracao";

// Depois, identifica possíveis novos concursos.
} elseif (
    preg_match('/edital de concurso público|edital de abertura|abertura de inscrições|abre inscrições|inscrições abertas/i', $titulo)
    || stripos($tipo, "Edital de Concurso Público") !== false
) {
    $categoria = "novo_concurso";

} elseif (
    preg_match('/concurso público|processo seletivo|provimento de vagas/i', $texto)
) {
    $categoria = "mencao_concurso";
}


    if ($categoria === "outra_publicacao") {
        continue;
    }

    $candidatos[] = [
        "id_publicacao" => $item["classPK"] ?? "",
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
    "total_publicacoes_analisadas" => count($publicacoesUnicas),
    "possiveis_concursos" => count($candidatos),
    "resultados" => $candidatos
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
