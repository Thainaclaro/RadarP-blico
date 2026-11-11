<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["usuario_id"])) {

    http_response_code(401);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Usuário não autenticado."
    ]);

    exit;
}

echo json_encode([
    "status" => "sucesso",
    "mensagem" => "Usuário autenticado.",
    "usuario" => [
        "id" => $_SESSION["usuario_id"],
        "nome" => $_SESSION["usuario_nome"],
        "email" => $_SESSION["usuario_email"]
    ]
]);
