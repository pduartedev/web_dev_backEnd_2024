<?php
session_start();
require_once '../../config/database.php';
require_once '../models/User.php';

// Verificar se os dados do formulário foram enviados
if (isset($_POST['inputUser']) && isset($_POST['inputPassword'])) {
    // Debugging
    echo 'Dados do formulário recebidos:<br>';
    var_dump($_POST);

    // Obter conexão com o banco de dados
    $database = new Database();
    $db = $database->getConnection();

    // Verificar se a conexão foi estabelecida
    if ($db) {
        echo 'Conexão com o banco de dados estabelecida com sucesso.<br>'; // Mensagem de depuração

        // Criar instância do usuário
        $user = new User($db);
        $user->nome_usuario = $_POST['inputUser'];
        $password = $_POST['inputPassword'];

        // Encontrar usuário pelo nome_usuario
        $stmt = $user->findByUsername();

        // Verificar se o usuário foi encontrado
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['senha'])) {
                $_SESSION['usuario'] = $user->nome_usuario;
                $_SESSION['permissao'] = $row['permissao'];
                // Debugging
                echo 'Login bem-sucedido. Redirecionando para a página inicial...';
                header('Location: ../views/home.php');
                exit();
            } else {
                echo ("<script>alert('Erro nos dados do Usuário/Senha!');</script>");
                echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../views/login.php'>";
                exit();
            }
        } else {
            echo ("<script>alert('Erro nos dados do Usuário/Senha!');</script>");
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../views/login.php'>";
            exit();
        }
    } else {
        echo 'Erro ao conectar ao banco de dados.';
    }
} else {
    // Debugging
    echo 'Dados do formulário não foram enviados corretamente.';
    var_dump($_POST);
}
?>