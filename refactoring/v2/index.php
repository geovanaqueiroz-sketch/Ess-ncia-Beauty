<?php

/**
 * Front Controller e Container de Injecao de Dependencia simplificado.
 * Aqui o PDO, o Repositorio e o Service sao instanciados e "montados"
 * antes de serem entregues ao Controller.
 */

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/MatriculaRepository.php';
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/router.php';

// --- Container de Injecao de Dependencia ---

// 1. Obter a instancia unica do PDO via Singleton
$pdo = Database::getInstance();

// 2. Instanciar o Repositorio passando o PDO
$repository = new MatriculaRepository($pdo);

// 3. Instanciar o Service passando a Interface do Repositorio (DI)
$service = new MatriculaService($repository);

// 4. Instanciar o Controller passando o Service (DI)
$controller = new MatriculaController($service);

// 5. Instanciar o Router passando o Controller e rotear a requisicao
$router = new Router($controller);
$router->rotear();
