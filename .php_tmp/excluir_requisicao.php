<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Verificar se o ID foi fornecido
        if (!isset($_POST['idrm']) || empty($_POST['idrm'])) {
            throw new Exception("ID da requisição não informado.");
        }
        
        $idrm = intval($_POST['idrm']);

        // Verificar permissões - exemplo: apenas usuários que criaram a requisição ou administradores podem excluí-la
        $database = new Database();
        $db = $database->getConnection();
        
        $query_check = "SELECT * FROM requisicao WHERE idrm = :id";
        $stmt_check = $db->prepare($query_check);
        $stmt_check->bindParam(':id', $idrm);
        $stmt_check->execute();
        
        if ($stmt_check->rowCount() == 0) {
            throw new Exception("Requisição não encontrada.");
        }
        
        $requisicao = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        // Exemplo de verificação: apenas quem criou a requisição ou administradores podem excluir
        // Descomentar se for implementar esta lógica
        /*
        if ($requisicao['user_requisicao'] != $_SESSION['usuario'] && $_SESSION['permissao'] != 'admin') {
            throw new Exception("Você não tem permissão para excluir esta requisição.");
        }
        */
        
        // Se a requisição já foi aprovada, talvez não deva ser excluída
        if ($requisicao['situacao'] == 'Aprovada') {
            throw new Exception("Não é possível excluir requisições já aprovadas.");
        }

        // Query para excluir requisição
        $query = "DELETE FROM requisicao WHERE idrm = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $idrm);

        if ($stmt->execute()) {
            $message = "Requisição excluída com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao excluir requisição: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro
        error_log("Erro na exclusão de requisição: " . $e->getMessage());
        
        $message = "Erro ao excluir requisição: " . $e->getMessage();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionamento
    header('Location: ../../views/requisicao/visualizar_requisicao.php');
    exit();
} else {
    // Se não for POST, redireciona
    header('Location: ../../views/requisicao/visualizar_requisicao.php');
    exit();
}
?>
