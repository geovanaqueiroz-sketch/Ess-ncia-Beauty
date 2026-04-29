<?php

require_once __DIR__ . '/middleware.php';
require_once __DIR__ . '/controller.php';

class Router
{
    /**
     * Avalia a URL e o método HTTP da requisição.
     * GET  → exibe o formulário (view.php)
     * POST → aciona o Middleware e depois o Controller
     */
    public function rotear(): void
    {
        $metodo = $_SERVER['REQUEST_METHOD'];
        $controller = new MatriculaController();

        if ($metodo === 'GET') {
            $controller->exibirFormulario();
        } elseif ($metodo === 'POST') {
            // Middleware valida os dados antes de entregar ao Controller
            Middleware::validar($_POST);

            // Se chegou aqui, a validação passou
            $nome  = trim($_POST['nome']);
            $idade = intval($_POST['idade']);
            $curso = $_POST['curso'];

            $controller->processarMatricula($nome, $idade, $curso);
        }
    }
}
