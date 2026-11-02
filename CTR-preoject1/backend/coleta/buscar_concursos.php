<?php

header("Content-Type: application/json; charset=UTF-8");

$palavrasChave = [
    '"concurso público"',
    '"concurso público federal"',
    '"processo seletivo simplificado"',
    '"abertura de concurso"',
    '"edital de abertura"',
    '"provimento de cargos"',
    '"vagas para cargos públicos"'
];

$limitePaginas = 3;
$urlBase = "https://www.in.gov.br/consulta/-/buscar/dou";

$resultados = [];

foreach ($palavrasChave as $indice => $palavra) {

    $paginaAtual = 1;

    $dados = [
        "q" => $palavra,
        "s" => "todos",
        "exactDate" => "all",
        "sortType" => "0",
        "delta" => "20",
        "currentPage" => "1",
        "newPage" => "1",
        "score" => "-1",
        "id" => " ",
        "displayDate" => " "
    ];

    for ($pagina = 1; $pagina <= $limitePaginas; $pagina++) {

        $dados["currentPage"] = (string) $paginaAtual;
        $dados["newPage"] = (string) $pagina;

        $url = $urlBase . "?" . http_build_query($dados);

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_USERAGENT => "RadarPublico/1.0"
        ]);

        $resposta = curl_exec($ch);
        $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $erro = curl_error($ch);

        if ($resposta === false || $codigo !== 200) {

            $resultados[] = [
                "termo" => $palavra,
                "pagina" => $pagina,
                "status_http" => $codigo,
                "erro" => $erro ?: "Falha na requisição"
            ];

            break;
        }

        // Salva a primeira página do primeiro termo
        if ($indice === 0 && $pagina === 1) {
            file_put_contents(
                __DIR__ . "/resposta_dou.html",
                $resposta
            );
        }

        $padrao = '/<script id="_br_com_seatecnologia_in_buscadou_BuscaDouPortlet_params" type="application\/json">\s*(.*?)\s*<\/script>/s';

        if (!preg_match($padrao, $resposta, $matches)) {
            break;
        }

        $json = json_decode($matches[1], true);
        $publicacoes = $json["jsonArray"] ?? [];

        if (empty($publicacoes)) {
            break;
        }

        $ultima = end($publicacoes);

        $dados["score"] = $ultima["score"] ?? 0;
        $dados["id"] = $ultima["classPK"] ?? "";
        $dados["displayDate"] = $ultima["displayDateSortable"] ?? "";

        $resultados[] = [
            "termo" => $palavra,
            "pagina" => $pagina,
            "status_http" => $codigo,
            "publicacoes" => count($publicacoes),
            "primeiro_titulo" => $publicacoes[0]["title"] ?? ""
        ];

        $paginaAtual = $pagina;
    }
}

echo json_encode(
    $resultados,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
);
