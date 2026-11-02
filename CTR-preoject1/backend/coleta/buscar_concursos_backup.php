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

$resultados = [];

foreach ($palavrasChave as $palavra) {

    $url = "https://www.in.gov.br/consulta/-/buscar/dou?q="
        . urlencode($palavra);

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => "RadarPublico/1.0"
    ]);

    $resposta = curl_exec($ch);
    $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($palavra === $palavrasChave[0] && $resposta !== false) {
    file_put_contents(__DIR__ . "/resposta_dou.html", $resposta);
}
    $resultados[] = [
        "termo" => $palavra,
        "status_http" => $codigo,
        "conexao" => $resposta !== false ? "conectado" : "erro",
        "tamanho_resposta" => $resposta !== false
            ? strlen($resposta)
            : 0
    ];
}

echo json_encode(
    $resultados,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
);

