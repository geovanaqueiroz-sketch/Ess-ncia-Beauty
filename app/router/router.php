<?php

require_once __DIR__ . '/../controller/UsuarioController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$controller = new UsuarioController();

if ($uri === '/' || $uri === '/index') {
    $controller->index();
    exit;
}

if ($uri === '/cadastro') {
    $controller->cadastro();
    exit;
}

echo "404 - Página não encontrada";
