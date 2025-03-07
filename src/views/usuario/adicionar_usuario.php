<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Adicionar Usuário</title>
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
                <h3 class="panel-title">Adicionar Novo Usuário</h3>
            </div>
            <div class="panel-body">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['message_type']; ?>" role="alert">
                        <?php 
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <form name="formulario" id="formularioUsuario" action="../../controllers/usuario/inserir_usuario.php" method="post" onsubmit="return validarFormulario()">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome_usuario">Nome do Usuário*</label>
                                <input type="text" name="nome_usuario" id="nome_usuario" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email*</label>
                                <input type="email" name="email" id="email" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senha">Senha*</label>
                                <input type="password" name="senha" id="senha" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmar_senha">Confirmar Senha*</label>
                                <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="permissao">Permissão*</label>
                                <select name="permissao" id="permissao" class="form-control" required>
                                    <option value="">Selecione um nível de permissão</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Gerente</option>
                                    <option value="3">Usuário Padrão</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status*</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">
                            <i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar
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
                                    <p>Confirma cadastro do usuário?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" onclick="enviarFormulario()">OK</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
            
            if (!nome || !email || !senha || !confirmarSenha || !permissao) {
                alert("Todos os campos com asterisco (*) são obrigatórios.");
                return false;
            }
            
            if (senha !== confirmarSenha) {
                alert("As senhas não conferem.");
                return false;
            }
            
            // Validação de complexidade de senha (opcional)
            if (senha.length < 6) {
                alert("A senha deve ter pelo menos 6 caracteres.");
                return false;
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
