<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_categoria = intval($_POST['id_categoria']);
    $categoria = htmlspecialchars(strip_tags($_POST['categoria']));
    $status = htmlspecialchars(strip_tags($_POST['status']));

    $database = new Database();
    $db = $database->getConnection();

    $query = "UPDATE categoria SET categoria = :categoria, status = :status WHERE id_categoria = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id_categoria);

    if ($stmt->execute()) {
        $message = "Categoria atualizada com sucesso!";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "success";
    } else {
        $message = "Erro ao atualizar categoria.";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionar para a página de visualização após a atualização
    header('Location: ../../views/categoria/visualizar_categoria.php');
    exit();
} else {
    header('Location: ../../views/categoria/visualizar_categoria.php');
    exit();
}
?>