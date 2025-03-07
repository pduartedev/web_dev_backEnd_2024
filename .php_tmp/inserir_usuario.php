<?php
session_start();

// Conexão com o banco de dados
require_once '../../../config/database.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e valida os dados do formulário
    $nome_usuario = isset($_POST['nome_usuario']) ? trim($_POST['nome_usuario']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';
    $confirmar_senha = isset($_POST['confirmar_senha']) ? trim($_POST['confirmar_senha']) : '';
    $permissao = isset($_POST['permissao']) ? (int)$_POST['permissao'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : 'Ativo';
    
    // Validações básicas
    if (empty($nome_usuario) || empty($email) || empty($senha) || empty($confirmar_senha) || empty($permissao)) {
        $_SESSION['message'] = "Todos os campos obrigatórios devem ser preenchidos!";
        $_SESSION['message_type'] = "danger";
        header('Location: ../../views/usuario/adicionar_usuario.php');
        exit();
    }
    
    // Verifica se as senhas conferem
    if ($senha !== $confirmar_senha) {
        $_SESSION['message'] = "As senhas não conferem!";
        $_SESSION['message_type'] = "danger";
        header('Location: ../../views/usuario/adicionar_usuario.php');
        exit();
    }
    
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        // Verifica se o e-mail já existe
        $sql_verificar = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt_verificar = $db->prepare($sql_verificar);
        $stmt_verificar->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_verificar->execute();
        
        if ($stmt_verificar->fetchColumn() > 0) {
            $_SESSION['message'] = "Este e-mail já está cadastrado!";
            $_SESSION['message_type'] = "danger";
            header('Location: ../../views/usuario/adicionar_usuario.php');
            exit();
        }
        
        // Criptografa a senha
        $senha_hash = md5($senha);
        
        // Data atual para o cadastro
        $data_atual = date('Y-m-d H:i:s');
        
        // Prepara e executa a inserção
        $sql = "INSERT INTO usuarios (nome_usuario, email, senha, permissao, status, dt_cadastro) VALUES (:nome_usuario, :email, :senha, :permissao, :status, :dt_cadastro)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome_usuario', $nome_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt->bindParam(':permissao', $permissao, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':dt_cadastro', $data_atual, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Usuário cadastrado com sucesso!";
            $_SESSION['message_type'] = "success";
            header('Location: ../../views/usuario/visualizar_usuario.php');
            exit();
        } else {
            throw new Exception("Erro ao cadastrar o usuário!");
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Erro: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header('Location: ../../views/usuario/adicionar_usuario.php');
        exit();
    }
} else {
    // Se não for POST, redireciona para o formulário
    header('Location: ../../views/usuario/adicionar_usuario.php');
    exit();
}
?>
