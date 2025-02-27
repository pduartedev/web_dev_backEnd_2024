<?php
require_once '../../../config/database.php';

$id_categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM categoria WHERE id_categoria = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id_categoria);
$stmt->execute();

// Verifica se encontrou a categoria
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $categoria = $row['categoria'];
    $status = $row['status'];
}
?>