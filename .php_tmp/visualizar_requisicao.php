<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

// Carregar a lista de requisições
require_once '../../controllers/requisicao/listar_requisicao.php';
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
    <title>Visualizar Requisições</title>
</head>

<body>
    <div class="container-fluid">
        <div style="margin-top: 20px;">
            <h3>Lista de Requisições</h3>
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
            <a href="adicionar_requisicao.php" class="btn btn-success">Nova Requisição</a>
        </div>
        
        <div class="table-responsive">
            <table id="tabela-requisicoes" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Situação</th>
                        <th>Solicitante</th>
                        <th>Aprovador</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($requisicoes) && count($requisicoes) > 0): ?>
                        <?php foreach($requisicoes as $requisicao): ?>
                            <tr>
                                <td><?php echo $requisicao['idrm']; ?></td>
                                <td><?php echo $requisicao['cod_produto'] . ' - ' . $requisicao['nome_produto']; ?></td>
                                <td><?php echo $requisicao['qtde']; ?></td>
                                <td>R$ <?php echo number_format($requisicao['valor'], 2, ',', '.'); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($requisicao['dt_rm'])); ?></td>
                                <td><?php echo $requisicao['tipo']; ?></td>
                                <td>
                                    <span class="label <?php echo ($requisicao['situacao'] == 'Aprovada') ? 'label-success' : 
                                        (($requisicao['situacao'] == 'Reprovada') ? 'label-danger' : 'label-warning'); ?>">
                                        <?php echo $requisicao['situacao']; ?>
                                    </span>
                                </td>
                                <td><?php echo $requisicao['nome_requisitante']; ?></td>
                                <td><?php echo $requisicao['nome_aprovador']; ?></td>
                                <td>
                                    <a href="editar_requisicao.php?id=<?php echo $requisicao['idrm']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    
                                    <?php if($requisicao['situacao'] == 'Em Aprovação'): ?>
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAprovar<?php echo $requisicao['idrm']; ?>">Aprovar</button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalExcluir<?php echo $requisicao['idrm']; ?>">Excluir</button>
                                    <?php endif; ?>
                                    
                                    <!-- Modal de aprovação para cada requisição -->
                                    <div class="modal fade" id="modalAprovar<?php echo $requisicao['idrm']; ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Confirmar Aprovação</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirma aprovação da requisição #<?php echo $requisicao['idrm']; ?>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="../../controllers/requisicao/aprovar_requisicao.php" method="post">
                                                        <input type="hidden" name="idrm" value="<?php echo $requisicao['idrm']; ?>">
                                                        <button type="submit" class="btn btn-success">Sim</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal de exclusão para cada requisição -->
                                    <div class="modal fade" id="modalExcluir<?php echo $requisicao['idrm']; ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Confirmar Exclusão</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirma exclusão da requisição #<?php echo $requisicao['idrm']; ?>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="../../controllers/requisicao/excluir_requisicao.php" method="post">
                                                        <input type="hidden" name="idrm" value="<?php echo $requisicao['idrm']; ?>">
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
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">Nenhuma requisição encontrada</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabela-requisicoes').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
                },
                "order": [[0, "desc"]]
            });
        });
    </script>
</body>
</html>
