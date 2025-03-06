<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

// Verificar se foi fornecido um ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: visualizar_fornecedor.php');
    exit();
}

// Buscar os dados do fornecedor
require_once '../../controllers/fornecedor/buscar_fornecedor.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Excluir Fornecedor</title>
    <style>
        .container {
            margin: 0 auto;
            max-width: 800px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="margin-top: 20px;">
            <h3>Excluir fornecedor</h3>
        </div>
        
        <?php if (isset($fornecedor)): ?>
            <div class="alert alert-warning">
                <p>Tem certeza que deseja excluir o fornecedor: <strong><?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?></strong>?</p>
            </div>
            
            <form name="formulario" action="../../controllers/fornecedor/excluir_fornecedor.php" method="post">
                <input type="hidden" name="id_fornecedor" value="<?php echo $id_fornecedor; ?>">
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="submit" class="btn btn-danger">Confirmar exclusão</button>
                    <a href="visualizar_fornecedor.php" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">
                Fornecedor não encontrado!
            </div>
            <a href="visualizar_fornecedor.php" class="btn btn-primary">Voltar</a>
        <?php endif; ?>
    </div>
</body>
</html>
