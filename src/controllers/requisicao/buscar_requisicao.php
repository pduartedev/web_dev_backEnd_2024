<?php
require_once '../../../config/database.php';

$idrm = isset($_GET['id']) ? intval($_GET['id']) : 0;

$database = new Database();
$db = $database->getConnection();

// Query para buscar a requisição com informações do produto
$query = "SELECT r.*, p.produto as nome_produto, p.preco_compra as preco_produto, 
          u1.nome_usuario as nome_requisitante, u2.nome_usuario as nome_aprovador
          FROM requisicao r 
          LEFT JOIN produto p ON r.cod_produto = p.codigo 
          LEFT JOIN usuarios u1 ON r.user_requisicao = u1.id_usuario
          LEFT JOIN usuarios u2 ON r.user_aprovador = u2.id_usuario
          WHERE r.idrm = :id";

$stmt = $db->prepare($query);
$stmt->bindParam(':id', $idrm);
$stmt->execute();

// Verifica se encontrou a requisição
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Define as variáveis que serão usadas no formulário
    $requisicao_encontrada = true;
    $idrm = $row['idrm'];
    $cod_produto = $row['cod_produto'];
    $nome_produto = $row['nome_produto'];
    $qtde = $row['qtde'];
    $valor = $row['valor'];
    $dt_rm = $row['dt_rm'];
    $tipo = $row['tipo'];
    $situacao = $row['situacao'];
    $user_requisicao = $row['user_requisicao'];
    $nome_requisitante = $row['nome_requisitante'];
    $user_aprovador = $row['user_aprovador'];
    $nome_aprovador = $row['nome_aprovador'];
    $preco_produto = $row['preco_produto'];
} else {
    // Requisição não encontrada
    $requisicao_encontrada = false;
    
    // Registra o erro
    error_log("Requisição não encontrada: ID = $idrm");
}
?>
