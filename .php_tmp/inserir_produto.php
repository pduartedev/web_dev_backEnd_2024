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
        if (empty($_POST['produto']) || empty($_POST['codigo']) || !isset($_POST['categoria_id_categoria']) || !isset($_POST['fornecedor_id_fornecedor'])) {
            throw new Exception("Os campos Nome do Produto, Código, Categoria e Fornecedor são obrigatórios.");
        }
        
        // Captura e sanitiza os dados do formulário
        $codigo = isset($_POST['codigo']) ? intval($_POST['codigo']) : null;
        $produto = htmlspecialchars(strip_tags($_POST['produto']));
        $saldo = isset($_POST['saldo']) ? intval($_POST['saldo']) : 0;
        $status = isset($_POST['status']) ? htmlspecialchars(strip_tags($_POST['status'])) : 'ativo';
        $tipo = isset($_POST['tipo']) ? htmlspecialchars(strip_tags($_POST['tipo'])) : 'nacional';
        $preco_compra = isset($_POST['preco_compra']) ? floatval(str_replace(',', '.', $_POST['preco_compra'])) : null;
        $dt_cadastro = date('Y-m-d H:i:s'); // Data atual
        $categoria_id = intval($_POST['categoria_id_categoria']);
        $fornecedor_id = intval($_POST['fornecedor_id_fornecedor']);

        // Conexão com o banco de dados
        $database = new Database();
        $db = $database->getConnection();

        // Query SQL para inserção
        $query = "INSERT INTO produto (codigo, produto, saldo, status, tipo, preco_compra, dt_cadastro, categoria_id_categoria, fornecedor_id_fornecedor) 
                 VALUES (:codigo, :produto, :saldo, :status, :tipo, :preco_compra, :dt_cadastro, :categoria_id, :fornecedor_id)";
        
        $stmt = $db->prepare($query);
        
        // Vinculação dos parâmetros
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':saldo', $saldo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':preco_compra', $preco_compra);
        $stmt->bindParam(':dt_cadastro', $dt_cadastro);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':fornecedor_id', $fornecedor_id);

        // Execução da query
        if ($stmt->execute()) {
            $message = "Produto cadastrado com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao cadastrar produto: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro para debugging
        error_log("Erro na inserção de produto: " . $e->getMessage());
        
        $message = "Erro ao cadastrar produto: " . $e->getMessage();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionamento após a operação
    header('Location: ../../views/produto/visualizar_produto.php');
    exit();
} else {
    // Se não for POST, redireciona para o formulário de adição
    header('Location: ../../views/produto/adicionar_produto.php');
    exit();
}
?>
