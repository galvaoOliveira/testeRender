<?php
// Configuração do banco de dados
$host = "localhost";
$dbname = "meubanco";
$user = "seu_usuario";
$password = "sua_senha";

// Conectar ao PostgreSQL
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $cidade = $_POST["cidade"];

    if (!empty($nome) && !empty($idade) && !empty($cidade)) {
        try {
            $sql = "INSERT INTO usuarios (nome, idade, cidade) VALUES (:nome, :idade, :cidade)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":idade", $idade, PDO::PARAM_INT);
            $stmt->bindParam(":cidade", $cidade);
            $stmt->execute();
            $mensagem = "Usuário cadastrado com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    } else {
        $mensagem = "Todos os campos são obrigatórios!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    <?php if (isset($mensagem)) echo "<p>$mensagem</p>"; ?>
    <form method="post">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>

        <label>Idade:</label>
        <input type="number" name="idade" required><br>

        <label>Cidade:</label>
        <input type="text" name="cidade" required><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
