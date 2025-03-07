<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validação dos campos obrigatórios
        if (empty($_POST['cod_produto']) || empty($_POST['qtde'])) {
            throw new Exception("Os campos Produto e Quantidade são obrigatórios.");
        }
        
        // Captura e sanitização dos dados
        $cod_produto = intval($_POST['cod_produto']);
        $qtde = intval($_POST['qtde']);
        $valor = isset($_POST['valor']) ? floatval(str_replace(',', '.', $_POST['valor'])) : 0;
        $dt_rm = isset($_POST['dt_rm']) ? $_POST['dt_rm'] : date('Y-m-d H:i:s');
        $tipo = isset($_POST['tipo']) ? htmlspecialchars(strip_tags($_POST['tipo'])) : 'RM';
        $situacao = isset($_POST['situacao']) ? htmlspecialchars(strip_tags($_POST['situacao'])) : 'Em Aprovação';
        $user_requisicao = $_SESSION['usuario'];
        $user_aprovador = isset($_POST['user_aprovador']) ? htmlspecialchars(strip_tags($_POST['user_aprovador'])) : null;
        
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
        
        // Query para inserir a requisição
        $query = "INSERT INTO requisicao (cod_produto, qtde, valor, dt_rm, tipo, situacao, user_requisicao, user_aprovador) 
                 VALUES (:cod_produto, :qtde, :valor, :dt_rm, :tipo, :situacao, :user_requisicao, :user_aprovador)";
        
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
        
        // Execução da query
        if ($stmt->execute()) {
            $message = "Requisição cadastrada com sucesso!";
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Erro ao cadastrar requisição: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        // Log do erro
        error_log("Erro na inserção de requisição: " . $e->getMessage());
        
        $message = "Erro ao cadastrar requisição: " . $e->getMessage();
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "danger";
    }
    
    // Redirecionamento
    header('Location: ../../views/requisicao/visualizar_requisicao.php');
    exit();
} else {
    // Se não for POST, redireciona
    header('Location: ../../views/requisicao/adicionar_requisicao.php');
    exit();
}
?>
