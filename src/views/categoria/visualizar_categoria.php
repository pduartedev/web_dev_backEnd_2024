<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Categorias</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <style>
        .container {
            margin: 0 auto;
            max-width: 1200px;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 40px">
        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        <h3>Lista de categorias</h3>
        <div style="text-align: right; margin-top:20px;">
            <a href="adicionar_categoria.php" role="button" class="btn btn-success btn-sm">Cadastrar categoria</a>
        </div>
        <br>
        <table id="table_id" class="table">
            <thead>
                <tr>
                    <th scope="col">Descrição da categoria</th>
                    <th scope="col"> Status</th>
                    <th scope="col" style="text-align: center"> Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../../controllers/categoria/listar_categoria.php';

                foreach ($categorias as $row) {
                    $id_categoria = $row['id_categoria'];
                    $categoria = $row['categoria'];
                    $status = $row['status'];

                    // Estilizar o conteúdo do status
                    if ($status == "inativo") {
                        $estilo = "<span style='color:red;'>$status</span>";
                    } else {
                        $estilo = $status;
                    }
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $estilo; ?></td>
                        <td style="text-align: center">
                            <a title="Editar" href="editar_categoria.php?id=<?php echo $id_categoria; ?>" role="button" class="btn btn-warning btn-sm">
                                <i class="far fa-edit"></i>&nbsp; Editar
                            </a>
                            <a title="Excluir" href="deletar_categoria.php?id=<?php echo $id_categoria; ?>" role="button" class="btn btn-danger btn-sm">
                                <i class="far fa-trash-alt"></i>&nbsp; Excluir
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                "language": {
                    "lengthMenu": "Mostrando _MENU_ registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro encontrado",
                    "infoFiltered": "(Filtrado de _MAX_ registros totais)",
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeira",
                        "last": "&Uacute;ltima",
                        "next": "Pr&oacute;xima",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
</body>

</html>