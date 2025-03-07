<?php

require_once '../../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Query com JOIN para obter informações de categoria e fornecedor
$query = "SELECT p.*, c.categoria as nome_categoria, f.nome_fornecedor 
          FROM produto p 
          LEFT JOIN categoria c ON p.categoria_id_categoria = c.id_categoria 
          LEFT JOIN fornecedor f ON p.fornecedor_id_fornecedor = f.id_fornecedor 
          ORDER BY p.id_estoque DESC";

$stmt = $db->prepare($query);
$stmt->execute();

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
