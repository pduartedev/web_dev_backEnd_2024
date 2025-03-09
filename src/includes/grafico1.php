// TODO: CONSERTAR GRÁFICO
<?php

//determina o tipo de dados que será enviado
header('Content-Type: application/json');

include('database.php'); //inclui a conexão com o BD

$sql = "SET lc_time_names = 'pt_BR'"; //seta o idioma Port no banco
$result = mysqli_query($conec, query: $sql); //envia para o banco

//query que busca os dados agrupados. Vamos buscar as RMs emitidas por mês
$sql = "SELECT MONTHNAME(dt_rm) as mes, COUNT(qtde) AS qt
FROM requisicao WHERE tipo = 'RM' GROUP BY MONTH(dt_rm) ORDER BY dt_rm;";

$result = mysqli_query($conec, query: $sql);

$data = [];

//preenche um array com os dados do banco
while ($row = mysqli_fetch_array($result)) {
    $data[] = $row;
}
//envia para o js gerar o gráfico
echo json_encode($data);
?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Requisições Mensais</h5>
    </div>
    <div class="card-body">
        <canvas id="grafico1"></canvas>
    </div>
</div>

<script>
    async function carregarDados() {
        //carrega os dados do arquivo php
        const resposta = await fetch('./graficos/dados1.php');
        //converte dados em json
        const dados = await resposta.json();
        //recebe cada chave do map
        const meses = dados.map(item => item.mes);
        const qtde = dados.map(item => item.qt);
        //pega valor máximo para alimentar o eixo Y
        const maximo = Math.max.apply(null, qtde);
        //indica o id que receberá o gráfico
        const ctx = document.getElementById('grafico1').getContext('2d');
        //monta o gráfico
        new Chart(ctx, {
            type: 'bar', //tipo do gráfico ('bar','line','pie',etc.)
            data: {
                labels: meses, //carrega os dados dos rótulos
                datasets: [{
                    label: 'RM.',
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: qtde //carrega os dados dos rótulos
                }]
            },
            options: {
                responsive: true,
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: maximo,
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .2)",
                        }
                    }],
                },
                legend: {
                    display: false
},
            },
        });
    }
    carregarDados();
</script>