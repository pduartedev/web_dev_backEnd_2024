<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoria = htmlspecialchars(strip_tags($_POST['categoria']));

    $database = new Database();
    $db = $database->getConnection();

    $query = "INSERT INTO categoria (categoria) VALUES (:categoria)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':categoria', $categoria);

    if ($stmt->execute()) {
        $message = "Registro salvo com sucesso!";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "success";
    } else {
        $message = "Erro ao salvar o registro.";
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionar para a página de visualização após a inserção
    header('Location: ../../views/categoria/visualizar_categoria.php');
    exit();
} else {
    header('Location: ../../views/categoria/adicionar_categoria.php');
    exit();
}
?>