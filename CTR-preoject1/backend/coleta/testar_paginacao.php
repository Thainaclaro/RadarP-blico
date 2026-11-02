<?php

$url = "https://www.in.gov.br/consulta/-/buscar/dou";

$dados = [
    "q" => '"concurso público"',
    "s" => "todos",
    "exactDate" => "all",
    "sortType" => "0",
    "delta" => "20",
    "currentPage" => "1",
    "newPage" => "2",
    "score" => "0",
    "id" => "740941371",
    "displayDate" => "1793242800000"
];

$ch = curl_init($url . "?" . http_build_query($dados));

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => "RadarPublico/1.0"
]);

$resposta = curl_exec($ch);

$codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erro = curl_error($ch);

if ($resposta !== false) {
    file_put_contents(__DIR__ . "/resposta_dou_pagina2.html", $resposta);
}

curl_close($ch);

echo "HTTP: " . $codigo . PHP_EOL;
echo "Tamanho: " . ($resposta !== false ? strlen($resposta) : 0) . PHP_EOL;
echo "Erro: " . ($erro ?: "nenhum") . PHP_EOL;
