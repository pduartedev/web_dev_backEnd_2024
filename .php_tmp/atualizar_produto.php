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
        if (!isset($_POST['id_estoque']) || empty($_POST['id_estoque'])) {
            throw new Exception("ID do produto não informado.");
        }

        // Captura e sanitização dos dados
        $id_estoque = intval($_POST['id_estoque']);
        $codigo = isset($_POST['codigo']) ? intval($_POST['codigo']) : null;
        $produto = htmlspecialchars(strip_tags($_POST['produto']));
        $saldo = isset($_POST['saldo']) ? intval($_POST['saldo']) : 0;
        $status = isset($_POST['status']) ? htmlspecialchars(strip_tags($_POST['status'])) : 'ativo';
        $tipo = isset($_POST['tipo']) ? htmlspecialchars(strip_tags($_POST['tipo'])) : 'nacional';
        $preco_compra = isset($_POST['preco_compra']) ? floatval(str_replace(',', '.', $_POST['preco_compra'])) : null;
        $categoria_id = intval($_POST['categoria_id_categoria']);
        $fornecedor_id = intval($_POST['fornecedor_id_fornecedor']);

        // Validação básica
        if (empty($produto) || empty($codigo)) {
            throw new Exception("Os campos Nome do Produto e Código são obrigatórios.");
        }

        $database = new Database();
        $db = $database->getConnection();

        // Query SQL para atualização
        $query = "UPDATE produto SET 
                    codigo = :codigo, 
                    produto = :produto, 
                    saldo = :saldo, 
                    status = :status, 
                    tipo = :tipo, 
                    preco_compra = :preco_compra, 
                    categoria_id_categoria = :categoria_id, 
                    fornecedor_id_fornecedor = :fornecedor_id 
                  WHERE id_estoque = :id";
                  
        $stmt = $db->prepare($query);
        
        // Vinculando parâmetros
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':saldo', $saldo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':preco_compra', $preco_compra);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':fornecedor_id', $fornecedor_id);
        $stmt->bindParam(':id', $id_estoque);

        if ($stmt->execute()) {
            $message = "Produto atualizado com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao atualizar produto: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro para debugging
        error_log("Erro na atualização de produto: " . $e->getMessage());
        
        $message = "Erro ao atualizar produto: " . $e->getMessage();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionamento após a operação
    header('Location: ../../views/produto/visualizar_produto.php');
    exit();
} else {
    // Se não for POST, redireciona
    header('Location: ../../views/produto/visualizar_produto.php');
    exit();
}
?>
