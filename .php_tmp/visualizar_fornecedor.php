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
    <title>Lista de Fornecedores</title>
</head>

<body>
    <div class="container-fluid">
        <div style="margin-top: 20px;">
            <h3>Lista de Fornecedores</h3>
        </div>

        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message_type'] . '" role="alert">
                ' . $_SESSION['message'] . '
            </div>';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        <div class="text-right" style="margin-bottom: 15px;">
            <a href="adicionar_fornecedor.php" class="btn btn-success">Cadastrar fornecedor</a>
        </div>
        
        <div class="table-responsive">
            <table id="tabela-fornecedores" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>CNPJ</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../../controllers/fornecedor/listar_fornecedor.php';

                    foreach ($fornecedores as $row) {
                        $id_fornecedor = $row['id_fornecedor'];
                        $nome = $row['nome_fornecedor'];
                        $email = $row['email_fornecedor'];
                        $cnpj = $row['cnpj'];
                        $telefone = $row['telefone'];
                        $status = $row['status'];

                        // Estilizar o conteúdo do status
                        if ($status == "inativo") {
                            $estilo = "<span style='color:red;'>$status</span>";
                        } else {
                            $estilo = $status;
                        }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($cnpj, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $estilo; ?></td>
                            <td>
                                <a href="editar_fornecedor.php?id=<?php echo $id_fornecedor; ?>" class="btn btn-primary btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalExcluir<?php echo $id_fornecedor; ?>">Excluir</button>
                                
                                <!-- Modal de exclusão para cada fornecedor -->
                                <div class="modal fade" id="modalExcluir<?php echo $id_fornecedor; ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Confirmar Exclusão</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Confirma exclusão do fornecedor: <strong><?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?></strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="deletar_fornecedor.php?id=<?php echo $id_fornecedor; ?>" class="btn btn-danger">Sim</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabela-fornecedores').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
                },
                "order": [[0, "asc"]]
            });
        });
    </script>
</body>

</html>
