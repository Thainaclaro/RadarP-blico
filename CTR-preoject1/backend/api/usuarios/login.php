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

require_once __DIR__ . "/../../config/database.php";

// Aceitar somente POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Método não permitido."
    ]);

    exit;
}

// Receber os dados JSON
$dados = json_decode(file_get_contents("php://input"), true);

$email = trim($dados["email"] ?? "");
$senha = $dados["senha"] ?? "";

// Validar campos
if ($email === "" || $senha === "") {
    http_response_code(400);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Informe seu e-mail e senha."
    ]);

    exit;
}

try {

    // Buscar usuário pelo e-mail
    $sql = "SELECT id, nome, email, senha
            FROM usuarios
            WHERE email = :email";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":email" => $email
    ]);

    $usuario = $stmt->fetch();

    // Verificar senha
    if (!$usuario || !password_verify($senha, $usuario["senha"])) {

        http_response_code(401);

        echo json_encode([
            "status" => "erro",
            "mensagem" => "E-mail ou senha incorretos."
        ]);

        exit;
    }

    // Login realizado

session_regenerate_id(true);

$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["usuario_nome"] = $usuario["nome"];
$_SESSION["usuario_email"] = $usuario["email"];

http_response_code(200);

echo json_encode([
    "status" => "sucesso",
    "mensagem" => "Login realizado com sucesso!",
    "usuario" => [
        "id" => $usuario["id"],
        "nome" => $usuario["nome"],
        "email" => $usuario["email"]
    ]
]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro ao realizar login."
    ]);
}
