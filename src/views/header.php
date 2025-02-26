<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestão de Estoques</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body>
    <header>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Sistema de Gestão</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active">
                    <p style="color: aliceblue; padding-top: 10px;">Usuário ativo: <?php echo $_SESSION['usuario']?></p>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown"><i class="fas fa-user"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Configurações</a></li>
                        <li><a class="dropdown-item" href="#!">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="../controllers/logoff.php">Logoff</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <aside
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Principal</div>
                        <a class="nav-link" href="menu.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Operações</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#cadastros">
                            <div class="sb-nav-link-icon"><i class="fa fa-plus-square"></i></div>
                            Cadastros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="cadastros" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="adicionar_categoria.php" target="iframe">Categorias</a>
                                <a class="nav-link" href="#" target="iframe">Fornecedores</a>
                                <a class="nav-link" href="#" target="iframe">Produtos</a>
                                <a class="nav-link" href="#" target="iframe">Requisições</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#relatorios">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Relatórios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="relatorios" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="rel_tabela.php">Por tabela</a>
                                <a class="nav-link" href="rel_requisicoes.php">Requisições</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#graficos">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Gráficos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="graficos" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="#">Gráfico 1</a>
                                <a class="nav-link" href="#">Gráfico 2</a>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Exportar</div>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tabelas
                        </a>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                            Parâmetros
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Class para permitir que o conteúdo do iframe flua no espaço quando menu sair-->
        <div id="layoutSidenav_content"> 
            <iframe src="dashboard.php" name="iframe" width="100%" height="100%"></iframe>
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
</body>
</html>