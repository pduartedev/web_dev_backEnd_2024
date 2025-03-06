<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

// Verificar se foi fornecido um ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: visualizar_produto.php');
    exit();
}

// Buscar os dados do produto
require_once '../../controllers/produto/buscar_produto.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Excluir Produto</title>
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
            <h3>Excluir produto</h3>
        </div>
        
        <?php if (isset($produto)): ?>
            <div class="alert alert-warning">
                <p>Tem certeza que deseja excluir o produto: <strong><?php echo htmlspecialchars($produto, ENT_QUOTES, 'UTF-8'); ?></strong>?</p>
            </div>
            
            <form name="formulario" action="../../controllers/produto/excluir_produto.php" method="post">
                <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="submit" class="btn btn-danger">Confirmar exclusão</button>
                    <a href="visualizar_produto.php" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">
                Produto não encontrado!
            </div>
            <a href="visualizar_produto.php" class="btn btn-primary">Voltar</a>
        <?php endif; ?>
    </div>
</body>
</html>
