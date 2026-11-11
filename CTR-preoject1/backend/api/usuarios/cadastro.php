<?php

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../../config/database.php";

// Aceitar somente requisições POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Método não permitido."
    ]);

    exit;
}

// Receber os dados enviados em JSON
$dados = json_decode(file_get_contents("php://input"), true);

// Verificar os campos
$nome = trim($dados["nome"] ?? "");
$email = trim($dados["email"] ?? "");
$senha = $dados["senha"] ?? "";

// Validar os campos
if ($nome === "" || $email === "" || $senha === "") {
    http_response_code(400);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Preencha todos os campos."
    ]);

    exit;
}

// Validar e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "E-mail inválido."
    ]);

    exit;
}

// Criptografar senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {

    // Verificar se o e-mail já existe
    $consulta = $pdo->prepare(
        "SELECT id FROM usuarios WHERE email = :email"
    );

    $consulta->execute([
        ":email" => $email
    ]);

    if ($consulta->fetch()) {
        http_response_code(409);

        echo json_encode([
            "status" => "erro",
            "mensagem" => "Este e-mail já está cadastrado."
        ]);

        exit;
    }

    // Cadastrar usuário
    $sql = "INSERT INTO usuarios (nome, email, senha)
            VALUES (:nome, :email, :senha)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nome" => $nome,
        ":email" => $email,
        ":senha" => $senhaHash
    ]);

    http_response_code(201);

    echo json_encode([
        "status" => "sucesso",
        "mensagem" => "Usuário cadastrado com sucesso!"
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "status" => "erro",
        "mensagem" => "Não foi possível realizar o cadastro."
    ]);
}

