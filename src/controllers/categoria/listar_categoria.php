<?php

require_once '../../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM categoria";
$stmt = $db->prepare($query);
$stmt->execute();

$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>