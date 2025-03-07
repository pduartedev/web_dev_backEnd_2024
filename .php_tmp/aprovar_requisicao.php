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
        $user_aprovador = $_SESSION['usuario']; // O usuário atual é quem está aprovando
        $situacao = "Aprovada";
        
        // Conexão com o banco de dados
        $database = new Database();
        $db = $database->getConnection();
        
        // Verificar se a requisição existe e se já não está aprovada
        $query_check = "SELECT * FROM requisicao WHERE idrm = :id";
        $stmt_check = $db->prepare($query_check);
        $stmt_check->bindParam(':id', $idrm);
        $stmt_check->execute();
        
        if ($stmt_check->rowCount() == 0) {
            throw new Exception("Requisição não encontrada.");
        }
        
        $requisicao = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if ($requisicao['situacao'] == 'Aprovada') {
            throw new Exception("Esta requisição já foi aprovada anteriormente.");
        }

        // Atualizar a situação da requisição e registrar o aprovador
        $query = "UPDATE requisicao SET 
                    situacao = :situacao, 
                    user_aprovador = :user_aprovador 
                  WHERE idrm = :id";
                  
        $stmt = $db->prepare($query);
        $stmt->bindParam(':situacao', $situacao);
        $stmt->bindParam(':user_aprovador', $user_aprovador);
        $stmt->bindParam(':id', $idrm);

        if ($stmt->execute()) {
            $message = "Requisição aprovada com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao aprovar requisição: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro
        error_log("Erro na aprovação de requisição: " . $e->getMessage());
        
        $message = "Erro ao aprovar requisição: " . $e->getMessage();
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
