<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

// Verificar se foi fornecido um ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: visualizar_requisicao.php');
    exit();
}

// Buscar os dados da requisição
require_once '../../controllers/requisicao/buscar_requisicao.php';

// Carregar produtos para o select
require_once '../../controllers/produto/listar_produto.php';

// Carregar usuários para o select (opcional)
// require_once '../../controllers/usuario/listar_usuario.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Editar Requisição</title>
</head>

<body>
    <div class="container">
        <div style="margin-top: 20px;">
            <h3>Editar Requisição</h3>
        </div>
        
        <?php if (isset($requisicao_encontrada) && $requisicao_encontrada): ?>
            <form name="formulario" id="formularioRequisicao" action="../../controllers/requisicao/atualizar_requisicao.php" method="post" onsubmit="return validarFormulario()">
                <input type="hidden" name="idrm" value="<?php echo $idrm; ?>">
                <input type="hidden" name="user_requisicao" value="<?php echo $user_requisicao; ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <label for="cod_produto">Produto*</label>
                        <select name="cod_produto" id="cod_produto" class="form-control" required onchange="atualizarValor()">
                            <option value="">Selecione um produto</option>
                            <?php foreach($produtos as $produto): ?>
                                <option value="<?php echo $produto['codigo']; ?>" 
                                        data-preco="<?php echo $produto['preco_compra']; ?>"
                                        <?php echo ($cod_produto == $produto['codigo']) ? 'selected' : ''; ?>>
                                    <?php echo $produto['codigo'] . ' - ' . $produto['produto']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="qtde">Quantidade*</label>
                        <input type="number" name="qtde" id="qtde" min="1" class="form-control" value="<?php echo $qtde; ?>" required onchange="calcularValorTotal()">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <label for="valor">Valor Total</label>
                        <input type="text" name="valor" id="valor" class="form-control" value="<?php echo number_format($valor, 2, ',', '.'); ?>">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="dt_rm">Data</label>
                        <input type="datetime-local" name="dt_rm" id="dt_rm" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($dt_rm)); ?>">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo" class="form-control">
                            <option value="RM" <?php echo ($tipo == 'RM') ? 'selected' : ''; ?>>RM - Requisição de Material</option>
                            <option value="OC" <?php echo ($tipo == 'OC') ? 'selected' : ''; ?>>OC - Ordem de Compra</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="situacao">Situação</label>
                        <select name="situacao" id="situacao" class="form-control">
                            <option value="Em Aprovação" <?php echo ($situacao == 'Em Aprovação') ? 'selected' : ''; ?>>Em Aprovação</option>
                            <option value="Aprovada" <?php echo ($situacao == 'Aprovada') ? 'selected' : ''; ?>>Aprovada</option>
                            <option value="Reprovada" <?php echo ($situacao == 'Reprovada') ? 'selected' : ''; ?>>Reprovada</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label>Solicitante</label>
                        <input type="text" class="form-control" value="<?php echo $nome_requisitante; ?>" readonly>
                    </div>
                    
                    <div class="col-md-6">
                        <label>Aprovador</label>
                        <input type="text" name="user_aprovador" class="form-control" value="<?php echo $user_aprovador; ?>" readonly>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">Atualizar</button>
                    <a href="visualizar_requisicao.php" class="btn btn-danger">Cancelar</a>
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
                                <p>Confirma atualização da requisição?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="enviarFormulario()">OK</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">
                Requisição não encontrada!
            </div>
            <a href="visualizar_requisicao.php" class="btn btn-primary">Voltar</a>
        <?php endif; ?>
    </div>

    <script>
        function validarFormulario() {
            var produto = document.getElementById('cod_produto').value;
            var qtde = document.getElementById('qtde').value;
            
            if (!produto || !qtde || qtde < 1) {
                alert("Selecione um produto e informe uma quantidade válida.");
                return false;
            }
            return true;
        }
        
        function atualizarValor() {
            calcularValorTotal();
        }
        
        function calcularValorTotal() {
            var select = document.getElementById('cod_produto');
            var qtde = document.getElementById('qtde').value || 0;
            
            if (select.selectedIndex > 0) {
                var preco = select.options[select.selectedIndex].getAttribute('data-preco') || 0;
                var total = parseFloat(preco) * parseInt(qtde);
                document.getElementById('valor').value = total.toFixed(2).replace(".", ",");
            }
        }
        
        function enviarFormulario() {
            if (validarFormulario()) {
                $('#confSalvar').modal('hide');
                document.getElementById('formularioRequisicao').submit();
            }
        }
        
        $(document).ready(function() {
            // Formatar valor
            $("#valor").blur(function() {
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
