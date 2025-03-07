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
        if (!isset($_POST['id_fornecedor']) || empty($_POST['id_fornecedor'])) {
            throw new Exception("ID do fornecedor não informado.");
        }

        $id_fornecedor = intval($_POST['id_fornecedor']);
        $nome = htmlspecialchars(strip_tags($_POST['nome']));
        $cnpj = htmlspecialchars(strip_tags($_POST['cnpj']));
        $telefone = htmlspecialchars(strip_tags($_POST['telefone']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $status = htmlspecialchars(strip_tags($_POST['status']));

        // Validação básica
        if (empty($nome) || empty($cnpj) || empty($telefone)) {
            throw new Exception("Os campos Nome, CNPJ e Telefone são obrigatórios.");
        }

        $database = new Database();
        $db = $database->getConnection();

        // Query SQL corrigida com os nomes corretos das colunas
        $query = "UPDATE fornecedor SET 
                    nome_fornecedor = :nome, 
                    cnpj = :cnpj, 
                    telefone = :telefone, 
                    email_fornecedor = :email, 
                    status = :status 
                  WHERE id_fornecedor = :id";
                  
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id_fornecedor);

        if ($stmt->execute()) {
            $message = "Fornecedor atualizado com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao atualizar fornecedor: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro para debugging
        error_log("Erro na atualização de fornecedor: " . $e->getMessage());
        
        $message = "Erro ao atualizar fornecedor: " . $e->getMessage();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionamento com garantia de que o script não continue após o redirecionamento
    header('Location: ../../views/fornecedor/visualizar_fornecedor.php');
    exit();
} else {
    // Se não for método POST, redirecionar
    header('Location: ../../views/fornecedor/visualizar_fornecedor.php');
    exit();
}
?>