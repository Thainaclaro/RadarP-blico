
<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["mensagem" => "Método não permitido."]);
    exit;
}

require_once __DIR__ . "/../config/database.php";

$dados = json_decode(file_get_contents("php://input"), true);

if (
    empty($dados["titulo"]) ||
    empty($dados["orgao"])
) {
    http_response_code(400);
    echo json_encode([
        "mensagem" => "Título e órgão são obrigatórios."
    ]);
    exit;
}

try {
    $sql = "INSERT INTO concursos (
        titulo, orgao, cargo, banca, escolaridade,
        area, estado, cidade, quantidade_vagas,
        salario, inscricao_inicio, inscricao_fim,
        data_prova, edital_url, fonte_url, descricao, status
    ) VALUES (
        :titulo, :orgao, :cargo, :banca, :escolaridade,
        :area, :estado, :cidade, :quantidade_vagas,
        :salario, :inscricao_inicio, :inscricao_fim,
        :data_prova, :edital_url, :fonte_url, :descricao, :status
    )";

    $consulta = $pdo->prepare($sql);

    $campos = [
        "titulo", "orgao", "cargo", "banca", "escolaridade",
        "area", "estado", "cidade", "quantidade_vagas",
        "salario", "inscricao_inicio", "inscricao_fim",
        "data_prova", "edital_url", "fonte_url", "descricao", "status"
    ];

    $valores = [];

    foreach ($campos as $campo) {
        $valores[$campo] = $dados[$campo] ?? null;

        if ($valores[$campo] === "") {
            $valores[$campo] = null;
        }
    }

    $consulta->execute(array_combine(
        array_map(fn($campo) => ":" . $campo, $campos),
        array_values($valores)
    ));

    http_response_code(201);

    echo json_encode([
        "status" => "sucesso",
        "mensagem" => "Concurso cadastrado com sucesso!",
        "id" => $pdo->lastInsertId()
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Não foi possível cadastrar o concurso."
    ], JSON_UNESCAPED_UNICODE);
}
