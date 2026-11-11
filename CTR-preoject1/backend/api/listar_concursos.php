<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../config/database.php";

try {
    $sql = "SELECT
                id,
                titulo,
                orgao,
                cargo,
                banca,
                escolaridade,
                area,
                estado,
                cidade,
                quantidade_vagas,
                salario,
                inscricao_inicio,
                inscricao_fim,
                data_prova,
                edital_url,
                fonte_url,
                descricao,
                status,
                data_cadastro
            FROM concursos
            ORDER BY data_cadastro DESC";

    $consulta = $pdo->query($sql);
    $concursos = $consulta->fetchAll();

    echo json_encode([
        "status" => "sucesso",
        "total" => count($concursos),
        "concursos" => $concursos
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Não foi possível consultar os concursos."
    ], JSON_UNESCAPED_UNICODE);
}
