<?php

/**
 * Front Controller - Ponto de entrada único da aplicação.
 * Recebe a visita do navegador e aciona o Router.
 */

require_once __DIR__ . '/router.php';

$router = new Router();
$router->rotear();
