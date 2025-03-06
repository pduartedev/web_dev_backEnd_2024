<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_categoria = intval($_POST['id_categoria']);

    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM categoria WHERE id_categoria = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id_categoria);

    if ($stmt->execute()) {
        $message = "Categoria excluída com sucesso!";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "success";
    } else {
        $message = "Erro ao excluir categoria.";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionar para a página de visualização após a exclusão
    header('Location: ../../views/categoria/visualizar_categoria.php');
    exit();
} else {
    header('Location: ../../views/categoria/visualizar_categoria.php');
    exit();
}
?>