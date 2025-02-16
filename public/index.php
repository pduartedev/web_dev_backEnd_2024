<?php
require_once '../src/index.php';

// Roteamento básico
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/') {
    $controller = new HomeController();
    $controller->index();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
?>