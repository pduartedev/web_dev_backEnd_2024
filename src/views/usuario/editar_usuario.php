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
    <title>Editar Usuário</title>
    <style>
        .container {
            margin-top: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Editar Usuário</h3>
            </div>
            <div class="panel-body">
                <?php if (isset($usuario_encontrado) && $usuario_encontrado): ?>
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['message_type']; ?>" role="alert">
                            <?php 
                            echo $_SESSION['message']; 
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <form name="formulario" id="formularioUsuario" action="../../controllers/usuario/atualizar_usuario.php" method="post" onsubmit="return validarFormulario()">
                        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome_usuario">Nome do Usuário*</label>
                                    <input type="text" name="nome_usuario" id="nome_usuario" class="form-control" value="<?php echo htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email*</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="senha">Nova Senha (deixe em branco para manter atual)</label>
                                    <input type="password" name="senha" id="senha" class="form-control">
                                    <small class="text-muted">A senha só será alterada se um novo valor for informado</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmar_senha">Confirmar Nova Senha</label>
                                    <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permissao">Permissão*</label>
                                    <select name="permissao" id="permissao" class="form-control" required>
                                        <option value="1" <?php echo ($permissao == 1) ? 'selected' : ''; ?>>Administrador</option>
                                        <option value="2" <?php echo ($permissao == 2) ? 'selected' : ''; ?>>Gerente</option>
                                        <option value="3" <?php echo ($permissao == 3) ? 'selected' : ''; ?>>Usuário Padrão</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status*</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Ativo" <?php echo ($status == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                                        <option value="Inativo" <?php echo ($status == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center" style="margin-top: 20px;">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">
                                <i class="glyphicon glyphicon-floppy-disk"></i> Salvar Alterações
                            </button>
                            <a href="visualizar_usuario.php" class="btn btn-danger">
                                <i class="glyphicon glyphicon-remove"></i> Cancelar
                            </a>
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
                                        <p>Confirma atualização do usuário?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" onclick="enviarFormulario()">OK</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
                    <div class="text-center">
                        <a href="visualizar_usuario.php" class="btn btn-primary">
                            <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function validarFormulario() {
            var nome = document.getElementById('nome_usuario').value;
            var email = document.getElementById('email').value;
            var senha = document.getElementById('senha').value;
            var confirmarSenha = document.getElementById('confirmar_senha').value;
            var permissao = document.getElementById('permissao').value;
            
            if (!nome || !email || !permissao) {
                alert("Os campos Nome, Email e Permissão são obrigatórios.");
                return false;
            }
            
            // Só valida as senhas se alguma delas foi preenchida
            if (senha || confirmarSenha) {
                if (senha !== confirmarSenha) {
                    alert("As senhas não conferem.");
                    return false;
                }
                
                // Validação de complexidade de senha (opcional)
                if (senha.length < 6) {
                    alert("A nova senha deve ter pelo menos 6 caracteres.");
                    return false;
                }
            }
            
            return true;
        }
        
        function enviarFormulario() {
            if (validarFormulario()) {
                $('#confSalvar').modal('hide');
                document.getElementById('formularioUsuario').submit();
            }
        }
    </script>
</body>
</html>
