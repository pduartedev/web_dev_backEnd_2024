<?php

require_once '../../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM fornecedor";
$stmt = $db->prepare($query);
$stmt->execute();

$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
