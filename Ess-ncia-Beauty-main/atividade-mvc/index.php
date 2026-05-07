<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/IMatriculaRepository.php';
require_once __DIR__ . '/MatriculaRepository.php';
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/router.php';

$pdo = Database::getInstance();

$repo = new MatriculaRepository($pdo);

$service = new MatriculaService($repo);

$controller = new MatriculaController($service);

$router = new Router($controller);

$router->rotear();