<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

// Verificar se foi fornecido um ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: visualizar_usuario.php');
    exit();
}

// Buscar os dados do usuário
require_once '../../controllers/usuario/buscar_usuario.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Excluir Usuário</title>
    <style>
        .container {
            margin-top: 30px;
            max-width: 800px;
        }
        .btn-container {
            margin-top: 20px;
            text-align: center;
        }
        .info-box {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Excluir Usuário</h3>
            </div>
            <div class="panel-body">
                <?php if (isset($usuario_encontrado) && $usuario_encontrado): ?>
                    <div class="alert alert-warning">
                        <h4><i class="glyphicon glyphicon-warning-sign"></i> Atenção</h4>
                        <p>Você está prestes a excluir o usuário: <strong><?php echo htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8'); ?></strong></p>
                        <p>Esta ação não poderá ser desfeita. Tem certeza que deseja continuar?</p>
                    </div>
                    
                    <div class="info-box">
                        <h4>Detalhes do Usuário</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8'); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <strong>Permissão:</strong> 
                                    <?php 
                                        switch($permissao) {
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
                                </p>
                                <p><strong>Status:</strong> <?php echo $status; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <form name="formulario" id="formularioExclusao" action="../../controllers/usuario/excluir_usuario.php" method="post">
                        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                        
                        <div class="btn-container">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confExcluir">
                                <i class="glyphicon glyphicon-trash"></i> Confirmar Exclusão
                            </button>
                            <a href="visualizar_usuario.php" class="btn btn-default">
                                <i class="glyphicon glyphicon-arrow-left"></i> Cancelar
                            </a>
                        </div>
                        
                        <!-- Modal de confirmação -->
                        <div class="modal fade" id="confExcluir" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Confirmar Exclusão</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tem certeza que deseja excluir definitivamente este usuário?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" onclick="enviarFormulario()">Sim, Excluir</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <h4><i class="glyphicon glyphicon-remove"></i> Erro</h4>
                        <p>Usuário não encontrado!</p>
                    </div>
                    <div class="btn-container">
                        <a href="visualizar_usuario.php" class="btn btn-primary">
                            <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        function enviarFormulario() {
            $('#confExcluir').modal('hide');
            document.getElementById('formularioExclusao').submit();
        }
    </script>
</body>
</html>