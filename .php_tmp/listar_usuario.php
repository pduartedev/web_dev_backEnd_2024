<?php
// Ativa exibição de erros durante o desenvolvimento
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco de dados - caminho absoluto para evitar problemas
require_once '../../../config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // Consulta para buscar todos os usuários
    $sql = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Armazena o resultado em um array
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Tratamento de erro
    $_SESSION['message'] = "Erro ao buscar usuários: " . $e->getMessage();
    $_SESSION['message_type'] = "danger";
    $usuarios = []; // Inicializa como array vazio para evitar erros na view
}
?>
