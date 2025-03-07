<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id_estoque = intval($_POST['id_estoque']);

        // Verificação se existe alguma referência ao produto em outras tabelas
        // (por exemplo, em requisições) - isso seria implementado aqui

        $database = new Database();
        $db = $database->getConnection();

        $query = "DELETE FROM produto WHERE id_estoque = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id_estoque);

        if ($stmt->execute()) {
            $message = "Produto excluído com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao excluir produto: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro para debugging
        error_log("Erro na exclusão de produto: " . $e->getMessage());
        
        $message = "Erro ao excluir produto: " . $e->getMessage();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionamento após a operação
    header('Location: ../../views/produto/visualizar_produto.php');
    exit();
} else {
    header('Location: ../../views/produto/visualizar_produto.php');
    exit();
}
?>
