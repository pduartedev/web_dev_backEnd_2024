<?php
// Conexão com o banco de dados
require_once '../../../config/database.php';

// Recebe o ID do usuário da URL
$id_usuario = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id_usuario']) ? $_POST['id_usuario'] : 0);

// Valida se o ID foi fornecido
if ($id_usuario > 0) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        // Consulta para buscar o usuário pelo ID
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        
        // Verifica se encontrou o usuário
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Atribui os valores para uso na view
            $id_usuario = $usuario['id_usuario'];
            $nome_usuario = $usuario['nome_usuario'];
            $email = $usuario['email'];
            $permissao = $usuario['permissao'];
            $status = $usuario['status'];
            $dt_cadastro = $usuario['dt_cadastro'];
            
            // Indica que o usuário foi encontrado
            $usuario_encontrado = true;
        } else {
            // Indica que o usuário não foi encontrado
            $usuario_encontrado = false;
            
            // Define mensagem de erro
            $_SESSION['message'] = "Usuário não encontrado!";
            $_SESSION['message_type'] = "danger";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao buscar usuário: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header('Location: ../../views/usuario/visualizar_usuario.php');
        exit();
    }
} else {
    // ID não fornecido, redireciona para a listagem
    header('Location: ../../views/usuario/visualizar_usuario.php');
    exit();
}
?>
