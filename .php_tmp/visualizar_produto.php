<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

// Carregar a lista de produtos
require_once '../../controllers/produto/listar_produto.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <title>Visualizar Produtos</title>
</head>

<body>
    <div class="container-fluid">
        <div style="margin-top: 20px;">
            <h3>Lista de Produtos</h3>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>" role="alert">
                <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>
        
        <div class="text-right" style="margin-bottom: 15px;">
            <a href="adicionar_produto.php" class="btn btn-success">Novo Produto</a>
        </div>
        
        <div class="table-responsive">
            <table id="tabela-produtos" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Produto</th>
                        <th>Saldo</th>
                        <th>Status</th>
                        <th>Tipo</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Fornecedor</th>
                        <th>Data Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($produtos as $produto): ?>
                        <tr>
                            <td><?php echo $produto['id_estoque']; ?></td>
                            <td><?php echo $produto['codigo']; ?></td>
                            <td><?php echo $produto['produto']; ?></td>
                            <td><?php echo $produto['saldo']; ?></td>
                            <td><?php echo $produto['status']; ?></td>
                            <td><?php echo $produto['tipo']; ?></td>
                            <td>R$ <?php echo number_format($produto['preco_compra'], 2, ',', '.'); ?></td>
                            <td><?php echo $produto['nome_categoria']; ?></td>
                            <td><?php echo $produto['nome_fornecedor']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($produto['dt_cadastro'])); ?></td>
                            <td>
                                <a href="editar_produto.php?id=<?php echo $produto['id_estoque']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalExcluir<?php echo $produto['id_estoque']; ?>">Excluir</button>
                                
                                <!-- Modal de exclusão para cada produto -->
                                <div class="modal fade" id="modalExcluir<?php echo $produto['id_estoque']; ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Confirmar Exclusão</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Confirma exclusão do produto: <strong><?php echo $produto['produto']; ?></strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="../../controllers/produto/excluir_produto.php" method="post">
                                                    <input type="hidden" name="id_estoque" value="<?php echo $produto['id_estoque']; ?>">
                                                    <button type="submit" class="btn btn-danger">Sim</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabela-produtos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
                },
                "order": [[0, "desc"]]
            });
        });
    </script>
</body>
</html>
