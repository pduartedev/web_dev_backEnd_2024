<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../views/index.php');
    exit();
}

// Carregar produtos para o select
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
    <title>Adicionar Requisição</title>
</head>

<body>
    <div class="container">
        <div style="margin-top: 20px;">
            <h3>Adicionar Requisição</h3>
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
        
        <form name="formulario" id="formularioRequisicao" action="../../controllers/requisicao/inserir_requisicao.php" method="post" onsubmit="return validarFormulario()">
            <div class="row">
                <div class="col-md-6">
                    <label for="cod_produto">Produto*</label>
                    <select name="cod_produto" id="cod_produto" class="form-control" required onchange="atualizarValor()">
                        <option value="">Selecione um produto</option>
                        <?php foreach($produtos as $produto): ?>
                            <option value="<?php echo $produto['codigo']; ?>" data-preco="<?php echo $produto['preco_compra']; ?>">
                                <?php echo $produto['codigo'] . ' - ' . $produto['produto']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="qtde">Quantidade*</label>
                    <input type="number" name="qtde" id="qtde" min="1" class="form-control" required onchange="calcularValorTotal()">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <label for="valor">Valor Total</label>
                    <input type="text" name="valor" id="valor" class="form-control" readonly>
                </div>
                
                <div class="col-md-4">
                    <label for="dt_rm">Data</label>
                    <input type="datetime-local" name="dt_rm" id="dt_rm" class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>">
                </div>
                
                <div class="col-md-4">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="RM">RM - Requisição de Material</option>
                        <option value="OC">OC - Ordem de Compra</option>
                    </select>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">Cadastrar</button>
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
                            <p>Confirma cadastro da requisição?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="enviarFormulario()">OK</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
            } else {
                document.getElementById('valor').value = "0,00";
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
