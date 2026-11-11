<?php

require_once __DIR__ . '/../config/database.php';

try {
    $resultado = $pdo->query('SELECT DATABASE()')->fetchColumn();

    echo json_encode([
        'status' => 'ok',
        'database' => $resultado,
        'message' => 'Conexão com o banco funcionando!'
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Não foi possível testar o banco.'
    ], JSON_UNESCAPED_UNICODE);
}
