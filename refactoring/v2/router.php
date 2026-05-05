<?php

require_once __DIR__ . '/middleware.php';

/**
 * Router - Avalia a URL e o metodo HTTP.
 * GET  -> exibe o formulario
 * POST -> aciona o Middleware e depois o Controller
 */
class Router
{
    private MatriculaController $controller;

    public function __construct(MatriculaController $controller)
    {
        $this->controller = $controller;
    }

    public function rotear(): void
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $this->controller->exibirFormulario();

        } elseif ($metodo === 'POST') {
            $dadosLimpos = Middleware::validar($_POST);

            $this->controller->store(
                $dadosLimpos['nome'],
                $dadosLimpos['idade'],
                $dadosLimpos['curso']
            );
        }
    }
}
