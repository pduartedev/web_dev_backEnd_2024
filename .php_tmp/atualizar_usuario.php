<?php
session_start();

// Conexão com o banco de dados
require_once '../../../config/database.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e valida os dados do formulário
    $id_usuario = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;
    $nome_usuario = isset($_POST['nome_usuario']) ? trim($_POST['nome_usuario']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';
    $confirmar_senha = isset($_POST['confirmar_senha']) ? trim($_POST['confirmar_senha']) : '';
    $permissao = isset($_POST['permissao']) ? (int)$_POST['permissao'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : 'Ativo';
    
    // Validações básicas
    if (empty($id_usuario) || empty($nome_usuario) || empty($email) || empty($permissao)) {
        $_SESSION['message'] = "Os campos obrigatórios devem ser preenchidos!";
        $_SESSION['message_type'] = "danger";
        header('Location: ../../views/usuario/editar_usuario.php?id=' . $id_usuario);
        exit();
    }
    
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        // Verifica se o e-mail já existe (exceto para o próprio usuário)
        $sql_verificar = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND id_usuario != :id_usuario";
        $stmt_verificar = $db->prepare($sql_verificar);
        $stmt_verificar->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_verificar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt_verificar->execute();
        
        if ($stmt_verificar->fetchColumn() > 0) {
            $_SESSION['message'] = "Este e-mail já está sendo usado por outro usuário!";
            $_SESSION['message_type'] = "danger";
            header('Location: ../../views/usuario/editar_usuario.php?id=' . $id_usuario);
            exit();
        }
        
        // Verifica se a senha deve ser alterada
        if (!empty($senha)) {
            // Verifica se as senhas conferem
            if ($senha !== $confirmar_senha) {
                $_SESSION['message'] = "As senhas não conferem!";
                $_SESSION['message_type'] = "danger";
                header('Location: ../../views/usuario/editar_usuario.php?id=' . $id_usuario);
                exit();
            }
            
            // Criptografa a nova senha
            $senha_hash = md5($senha);
            
            // SQL incluindo atualização de senha
            $sql = "UPDATE usuarios SET nome_usuario = :nome_usuario, email = :email, senha = :senha, permissao = :permissao, status = :status WHERE id_usuario = :id_usuario";
        } else {
            // SQL sem atualização de senha
            $sql = "UPDATE usuarios SET nome_usuario = :nome_usuario, email = :email, permissao = :permissao, status = :status WHERE id_usuario = :id_usuario";
        }
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome_usuario', $nome_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':permissao', $permissao, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        // Adiciona o parâmetro de senha apenas se estiver atualizando a senha
        if (!empty($senha)) {
            $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
        }
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Usuário atualizado com sucesso!";
            $_SESSION['message_type'] = "success";
            header('Location: ../../views/usuario/visualizar_usuario.php');
            exit();
        } else {
            throw new Exception("Erro ao atualizar o usuário!");
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Erro: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header('Location: ../../views/usuario/editar_usuario.php?id=' . $id_usuario);
        exit();
    }
} else {
    // Se não for POST, redireciona para a listagem
    header('Location: ../../views/usuario/visualizar_usuario.php');
    exit();
}
?>
