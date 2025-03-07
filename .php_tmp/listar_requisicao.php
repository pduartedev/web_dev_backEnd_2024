<?php

require_once '../../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Query com JOIN para obter informações do produto associado à requisição
$query = "SELECT r.*, p.produto as nome_produto, u1.nome_usuario as nome_requisitante,
          u2.nome_usuario as nome_aprovador
          FROM requisicao r 
          LEFT JOIN produto p ON r.cod_produto = p.codigo 
          LEFT JOIN usuarios u1 ON r.user_requisicao = u1.id_usuario
          LEFT JOIN usuarios u2 ON r.user_aprovador = u2.id_usuario
          ORDER BY r.dt_rm DESC";

$stmt = $db->prepare($query);
$stmt->execute();

$requisicoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
