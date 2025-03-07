<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_fornecedor = intval($_POST['id_fornecedor']);

    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id_fornecedor);

    if ($stmt->execute()) {
        $message = "Fornecedor excluído com sucesso!";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "success";
    } else {
        $message = "Erro ao excluir fornecedor.";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionar para a página de visualização após a exclusão
    header('Location: ../../views/fornecedor/visualizar_fornecedor.php');
    exit();
} else {
    header('Location: ../../views/fornecedor/visualizar_fornecedor.php');
    exit();
}
?>
