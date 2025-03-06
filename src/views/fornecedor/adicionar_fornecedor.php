<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Cadastro de Fornecedores</title>
</head>

<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>

<body>
    <div class="container">
        <div style="margin-top: 20px;">
            <h3>Cadastro de fornecedores</h3>
        </div>
        <form name="formulario" action="../../controllers/fornecedor/inserir_fornecedor.php" method="post">
            <label for="nome">Nome</label>
            <input type="text" name="nome" class="form-control" autocomplete="off" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" autocomplete="off" required>
            
            <label for="cnpj">CNPJ</label>
            <input type="text" name="cnpj" class="form-control" autocomplete="off" required>
            
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" class="form-control" autocomplete="off" required>
            
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
            
            <div style="text-align: center; margin-top: 20px;">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">Cadastrar</button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confSalvar" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmar</h4>
                </div>
                <div class="modal-body">
                    <p>Confirma cadastro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="javascript: document.formulario.submit();" class="btn btn-success" data-dismiss="modal">OK</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
</body>
</html>
