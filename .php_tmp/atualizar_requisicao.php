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

        // Captura e sanitização dos dados
        $idrm = intval($_POST['idrm']);
        $cod_produto = intval($_POST['cod_produto']);
        $qtde = intval($_POST['qtde']);
        $valor = floatval(str_replace(',', '.', $_POST['valor']));
        $dt_rm = $_POST['dt_rm'];
        $tipo = htmlspecialchars(strip_tags($_POST['tipo']));
        $situacao = htmlspecialchars(strip_tags($_POST['situacao']));
        $user_requisicao = htmlspecialchars(strip_tags($_POST['user_requisicao']));
        $user_aprovador = !empty($_POST['user_aprovador']) ? htmlspecialchars(strip_tags($_POST['user_aprovador'])) : null;

        // Validação básica
        if (empty($cod_produto) || empty($qtde)) {
            throw new Exception("Os campos Produto e Quantidade são obrigatórios.");
        }

        // Conexão com o banco de dados
        $database = new Database();
        $db = $database->getConnection();
        
        // Verificar se o produto existe
        $query_check = "SELECT * FROM produto WHERE codigo = :codigo";
        $stmt_check = $db->prepare($query_check);
        $stmt_check->bindParam(':codigo', $cod_produto);
        $stmt_check->execute();
        
        if ($stmt_check->rowCount() == 0) {
            throw new Exception("Produto não encontrado com o código fornecido.");
        }

        // Query para atualizar a requisição
        $query = "UPDATE requisicao SET 
                    cod_produto = :cod_produto, 
                    qtde = :qtde, 
                    valor = :valor, 
                    dt_rm = :dt_rm, 
                    tipo = :tipo, 
                    situacao = :situacao, 
                    user_requisicao = :user_requisicao, 
                    user_aprovador = :user_aprovador 
                  WHERE idrm = :id";
                  
        $stmt = $db->prepare($query);
        
        // Vinculação dos parâmetros
        $stmt->bindParam(':cod_produto', $cod_produto);
        $stmt->bindParam(':qtde', $qtde);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':dt_rm', $dt_rm);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':situacao', $situacao);
        $stmt->bindParam(':user_requisicao', $user_requisicao);
        $stmt->bindParam(':user_aprovador', $user_aprovador);
        $stmt->bindParam(':id', $idrm);

        if ($stmt->execute()) {
            $message = "Requisição atualizada com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao atualizar requisição: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro
        error_log("Erro na atualização de requisição: " . $e->getMessage());
        
        $message = "Erro ao atualizar requisição: " . $e->getMessage();
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
