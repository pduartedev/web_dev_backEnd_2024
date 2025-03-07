<?php
session_start();

// Conexão com o banco de dados
require_once '../../../config/database.php';

// Verifica se foi recebido um ID válido
if (isset($_POST['id_usuario']) && !empty($_POST['id_usuario'])) {
    $id_usuario = (int)$_POST['id_usuario'];
    
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        // Antes de excluir, verifica se o usuário existe
        $sql_verificar = "SELECT COUNT(*) FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt_verificar = $db->prepare($sql_verificar);
        $stmt_verificar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt_verificar->execute();
        
        if ($stmt_verificar->fetchColumn() == 0) {
            $_SESSION['message'] = "Usuário não encontrado!";
            $_SESSION['message_type'] = "danger";
            header('Location: ../../views/usuario/visualizar_usuario.php');
            exit();
        }
        
        // Prepara e executa a exclusão
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Usuário excluído com sucesso!";
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Falha ao excluir o usuário.");
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao excluir: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
} else {
    $_SESSION['message'] = "ID de usuário inválido ou não informado!";
    $_SESSION['message_type'] = "danger";
}

// Redireciona para a página de listagem
header('Location: ../../views/usuario/visualizar_usuario.php');
exit();
?>
