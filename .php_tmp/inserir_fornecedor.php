<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validação dos campos obrigatórios
        if (empty($_POST['nome']) || empty($_POST['cnpj']) || empty($_POST['telefone'])) {
            throw new Exception("Os campos Nome, CNPJ e Telefone são obrigatórios.");
        }
        
        // Capturando e sanitizando dados do formulário
        $nome = htmlspecialchars(strip_tags($_POST['nome']));
        $cnpj = htmlspecialchars(strip_tags($_POST['cnpj']));
        $telefone = htmlspecialchars(strip_tags($_POST['telefone']));
        $email = !empty($_POST['email']) ? htmlspecialchars(strip_tags($_POST['email'])) : null;
        $status = isset($_POST['status']) ? htmlspecialchars(strip_tags($_POST['status'])) : 'ativo';

        // Conexão com o banco de dados
        $database = new Database();
        $db = $database->getConnection();

        // Query SQL corrigida com os nomes corretos das colunas
        $query = "INSERT INTO fornecedor (nome_fornecedor, cnpj, telefone, email_fornecedor, status) 
                 VALUES (:nome, :cnpj, :telefone, :email, :status)";
        $stmt = $db->prepare($query);
        
        // Vinculação de parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':status', $status);

        // Execução da query
        if ($stmt->execute()) {
            $message = "Fornecedor cadastrado com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao cadastrar fornecedor: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro para debugging
        error_log("Erro na inserção de fornecedor: " . $e->getMessage());
        
        $message = "Erro ao cadastrar fornecedor: " . $e->getMessage();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionar para a página de visualização após a inserção
    header('Location: ../../views/fornecedor/visualizar_fornecedor.php');
    exit();
} else {
    // Se não for método POST, redirecionar para a página de adicionar
    header('Location: ../../views/fornecedor/adicionar_fornecedor.php');
    exit();
}
?>
