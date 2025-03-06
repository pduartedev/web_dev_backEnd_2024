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
    <title>Editar Fornecedor</title>
</head>

<body>
    <div class="container">
        <div style="margin-top: 20px;">
            <h3>Editar fornecedor</h3>
        </div>
        
        <?php if (isset($fornecedor)): ?>
            <form name="formulario" action="../../controllers/fornecedor/atualizar_fornecedor.php" method="post">
                <input type="hidden" name="id_fornecedor" value="<?php echo $id_fornecedor; ?>">
                
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" required>
                
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" required>
                
                <label for="cnpj">CNPJ</label>
                <input type="text" name="cnpj" class="form-control" value="<?php echo htmlspecialchars($cnpj, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" required>
                
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" class="form-control" value="<?php echo htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" required>
                
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="ativo" <?php echo ($status == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                    <option value="inativo" <?php echo ($status == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                </select>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">Atualizar</button>
                    <a href="visualizar_fornecedor.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
            
            <!-- Modal de confirmação -->
            <div class="modal fade" id="confSalvar" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirmar</h4>
                        </div>
                        <div class="modal-body">
                            <p>Confirma atualização?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="javascript: document.formulario.submit();" class="btn btn-success" data-dismiss="modal">OK</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Fornecedor não encontrado!
            </div>
            <a href="visualizar_fornecedor.php" class="btn btn-primary">Voltar</a>
        <?php endif; ?>
    </div>
</body>
</html>
