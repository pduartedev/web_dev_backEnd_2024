<?php
require_once '../../../config/database.php';

$id_estoque = isset($_GET['id']) ? intval($_GET['id']) : 0;

$database = new Database();
$db = $database->getConnection();

// Query para buscar o produto com informações de categoria e fornecedor
$query = "SELECT p.*, c.categoria as nome_categoria, f.nome_fornecedor 
          FROM produto p 
          LEFT JOIN categoria c ON p.categoria_id_categoria = c.id_categoria 
          LEFT JOIN fornecedor f ON p.fornecedor_id_fornecedor = f.id_fornecedor 
          WHERE p.id_estoque = :id";

$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id_estoque);
$stmt->execute();

// Verifica se o produto foi encontrado
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Define as variáveis que serão usadas no formulário
    $produto_encontrado = true;
    $id_estoque = $row['id_estoque'];
    $codigo = $row['codigo'];
    $nome_produto = $row['produto'];
    $saldo = $row['saldo'];
    $status = $row['status'];
    $tipo = $row['tipo'];
    $preco_compra = $row['preco_compra'];
    $dt_cadastro = $row['dt_cadastro'];
    $categoria_id = $row['categoria_id_categoria'];
    $nome_categoria = $row['nome_categoria'];
    $fornecedor_id = $row['fornecedor_id_fornecedor'];
    $nome_fornecedor = $row['nome_fornecedor'];
} else {
    // Produto não encontrado
    $produto_encontrado = false;
    
    // Registra o erro para debugging
    error_log("Produto não encontrado: ID = $id_estoque");
}
?>
