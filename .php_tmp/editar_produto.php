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

// Carregar categorias para o select
require_once '../../controllers/categoria/listar_categoria.php';

// Carregar fornecedores para o select
require_once '../../controllers/fornecedor/listar_fornecedor.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Editar Produto</title>
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
            <h3>Editar Produto</h3>
        </div>
        
        <?php if (isset($produto_encontrado) && $produto_encontrado): ?>
            <form name="formulario" action="../../controllers/produto/atualizar_produto.php" method="post" onsubmit="return validarFormulario()">
                <input type="hidden" name="id_estoque" value="<?php echo $id_estoque; ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <label for="codigo">Código*</label>
                        <input type="number" name="codigo" id="codigo" class="form-control" value="<?php echo $codigo; ?>" required autocomplete="off">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="produto">Nome do Produto*</label>
                        <input type="text" name="produto" id="produto" class="form-control" value="<?php echo htmlspecialchars($nome_produto, ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="off">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <label for="saldo">Saldo</label>
                        <input type="number" name="saldo" id="saldo" class="form-control" value="<?php echo $saldo; ?>" autocomplete="off">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="ativo" <?php echo ($status == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                            <option value="inativo" <?php echo ($status == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo" class="form-control">
                            <option value="nacional" <?php echo ($tipo == 'nacional') ? 'selected' : ''; ?>>Nacional</option>
                            <option value="importado" <?php echo ($tipo == 'importado') ? 'selected' : ''; ?>>Importado</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <label for="preco_compra">Preço de Compra</label>
                        <input type="text" name="preco_compra" id="preco_compra" class="form-control" value="<?php echo number_format($preco_compra, 2, ',', '.'); ?>" autocomplete="off">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="categoria_id_categoria">Categoria*</label>
                        <select name="categoria_id_categoria" id="categoria_id_categoria" class="form-control" required>
                            <option value="">Selecione uma categoria</option>
                            <?php foreach($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id_categoria']; ?>" <?php echo ($categoria_id == $categoria['id_categoria']) ? 'selected' : ''; ?>>
                                    <?php echo $categoria['categoria']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="fornecedor_id_fornecedor">Fornecedor*</label>
                        <select name="fornecedor_id_fornecedor" id="fornecedor_id_fornecedor" class="form-control" required>
                            <option value="">Selecione um fornecedor</option>
                            <?php foreach($fornecedores as $fornecedor): ?>
                                <option value="<?php echo $fornecedor['id_fornecedor']; ?>" <?php echo ($fornecedor_id == $fornecedor['id_fornecedor']) ? 'selected' : ''; ?>>
                                    <?php echo $fornecedor['nome_fornecedor']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">Atualizar</button>
                    <a href="visualizar_produto.php" class="btn btn-danger">Cancelar</a>
                </div>
                
                <!-- Modal de confirmação -->
                <div class="modal fade" id="confSalvar" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirmar</h4>
                            </div>
                            <div class="modal-body">
                                <p>Confirma atualização do produto?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">OK</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">
                Produto não encontrado!
            </div>
            <a href="visualizar_produto.php" class="btn btn-primary">Voltar</a>
        <?php endif; ?>
    </div>

    <script>
        function validarFormulario() {
            var codigo = document.getElementById('codigo').value;
            var produto = document.getElementById('produto').value;
            var categoria = document.getElementById('categoria_id_categoria').value;
            var fornecedor = document.getElementById('fornecedor_id_fornecedor').value;
            
            if (!codigo || !produto || !categoria || !fornecedor) {
                alert("Os campos Código, Nome do Produto, Categoria e Fornecedor são obrigatórios.");
                return false;
            }
            return true;
        }
        
        $(document).ready(function() {
            // Formatar preço como moeda
            $("#preco_compra").blur(function() {
                var valor = $(this).val().replace(/[^\d,]/g, "").replace(",", ".");
                if (valor) {
                    valor = parseFloat(valor).toFixed(2).replace(".", ",");
                    $(this).val(valor);
                }
            });
        });
    </script>
</body>
</html>
