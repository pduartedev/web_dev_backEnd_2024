<?php
// Ativa exibição de erros durante o desenvolvimento
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario'])) {
    // Apenas para teste, permitir o acesso sem login
    // header('Location: ../../views/index.php');
    // exit();
}

// Carregar a lista de usuários - use caminho absoluto
require_once $_SERVER['DOCUMENT_ROOT'] . '/webProject/src/controllers/usuario/listar_usuario.php';
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
    <title>Gerenciar Usuários</title>
</head>

<body>
    <div class="container-fluid">
        <div style="margin-top: 20px;">
            <h3>Gerenciamento de Usuários</h3>
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
            <a href="adicionar_usuario.php" class="btn btn-success">Novo Usuário</a>
        </div>
        
        <!-- Info de debug -->
        <div class="panel panel-info">
            <div class="panel-heading">Informações de Depuração</div>
            <div class="panel-body">
                <p>PHP Version: <?php echo phpversion(); ?></p>
                <p>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
                <p>Current Path: <?php echo __FILE__; ?></p>
                <?php if (!isset($usuarios) || !is_array($usuarios)): ?>
                    <p class="text-danger">A variável $usuarios não está definida corretamente.</p>
                <?php elseif (count($usuarios) == 0): ?>
                    <p class="text-warning">Não há usuários cadastrados no sistema.</p>
                <?php else: ?>
                    <p class="text-success">Total de usuários encontrados: <?php echo count($usuarios); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="table-responsive">
            <table id="tabela-usuarios" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Permissão</th>
                        <th>Status</th>
                        <th>Data de Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($usuarios) && count($usuarios) > 0): ?>
                        <?php foreach($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['id_usuario']; ?></td>
                                <td><?php echo $usuario['nome_usuario']; ?></td>
                                <td><?php echo $usuario['email']; ?></td>
                                <td>
                                    <?php 
                                        switch($usuario['permissao']) {
                                            case 1:
                                                echo "Administrador";
                                                break;
                                            case 2:
                                                echo "Gerente";
                                                break;
                                            case 3:
                                                echo "Usuário Padrão";
                                                break;
                                            default:
                                                echo "Desconhecido";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <span class="label <?php echo ($usuario['status'] == 'Ativo') ? 'label-success' : 'label-danger'; ?>">
                                        <?php echo $usuario['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                        echo !empty($usuario['dt_cadastro']) ? 
                                            date('d/m/Y H:i', strtotime($usuario['dt_cadastro'])) : 
                                            ''; 
                                    ?>
                                </td>
                                <td>
                                    <a href="editar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-primary btn-sm">
                                        <i class="glyphicon glyphicon-pencil"></i> Editar
                                    </a>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalExcluir<?php echo $usuario['id_usuario']; ?>">
                                        <i class="glyphicon glyphicon-trash"></i> Excluir
                                    </button>
                                    
                                    <!-- Modal de exclusão para cada usuário -->
                                    <div class="modal fade" id="modalExcluir<?php echo $usuario['id_usuario']; ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Confirmar Exclusão</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirma exclusão do usuário: <strong><?php echo $usuario['nome_usuario']; ?></strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="../../controllers/usuario/excluir_usuario.php" method="post">
                                                        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
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
                            <td colspan="7" class="text-center">Nenhum usuário encontrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabela-usuarios').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
                },
                "order": [[0, "desc"]]
            });
        });
    </script>
</body>
</html>
