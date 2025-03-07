<?php
require_once '../../../config/database.php';

$id_fornecedor = isset($_GET['id']) ? intval($_GET['id']) : 0;

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM fornecedor WHERE id_fornecedor = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id_fornecedor);
$stmt->execute();

// Verifica se encontrou o fornecedor
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Define as variáveis que serão usadas no formulário
    $fornecedor = true; // Indica que o fornecedor foi encontrado
    $id_fornecedor = $row['id_fornecedor'];
    $nome = $row['nome_fornecedor'];
    $email = $row['email_fornecedor'];
    $cnpj = $row['cnpj'];
    $telefone = $row['telefone'];
    $status = $row['status'];
} else {
    // Define variável para indicar que o fornecedor não foi encontrado
    $fornecedor = false;
    
    // Registra o erro para debugging
    error_log("Fornecedor não encontrado: ID = $id_fornecedor");
}
?>
