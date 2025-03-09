<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" />
    <link rel="stylesheet" href="/webProject/public/css/styles.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body>
    <div>
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <!-- <div class="col-xl-3 col-md-3">
                    <div class="card text-center bg-primary text-white mb-4">
                        <div class="card-body">Produtos Ativos<br><?php echo "<font size='30'>$produtos</font>" ?>
                        </div>
                    </div>
                </div> -->
                <!--Inicio div primeira row-->
                <div class="row">
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Indicador 1</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Ver detalhes</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">Indicador 2</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Ver detalhes</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Indicador 2</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Ver detalhes</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Indicador 3</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Ver detalhes</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
            </div>
            <!--termina div da primeira row-->
            <div class="row">
                <div class="col-xl-6 col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Gráfico de Área
                            </div>
                            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Gráfico de Colunas
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                <div class="col-xl-6 col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            RMs emitidas por mês (1)
                        </div>
                        <div class="card-body"><canvas id="grafico1" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                RMs emitidas por mês (2)
                            </div>
                            <div class="card-body"><canvas id="grafico2" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
            </div>
    </div>
    </main>
    </div>
    <script src="/webProject/public/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="/webProject/public/demo/chart-area-demo.js"></script>
    <script src="/webProject/public/demo/chart-bar-demo.js"></script>
    <script src="/webProject/src/includes/grafico1.php"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="/webProject/public/js/datatables-simple-demo.js"></script>

</body>

</html>