<?php
// Este arquivo é o ponto de entrada da aplicação.
// Inicializa o sistema e direciona as requisições para os controladores apropriados.

require_once '../config/config.php';
require_once '../src/controllers/HomeController.php';

$controller = new HomeController();
$controller->index();
?>