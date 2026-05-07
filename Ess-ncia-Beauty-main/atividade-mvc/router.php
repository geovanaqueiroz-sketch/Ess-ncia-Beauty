<?php

require_once __DIR__ . '/middleware.php';

class Router
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function rotear(): void
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {

            $this->controller->exibirFormulario();

        } elseif ($metodo === 'POST') {

            Middleware::validar();

            $nome = filter_input(
                INPUT_POST,
                'nome',
                FILTER_SANITIZE_SPECIAL_CHARS
            );

            $idade = filter_input(
                INPUT_POST,
                'idade',
                FILTER_VALIDATE_INT
            );

            $curso = filter_input(
                INPUT_POST,
                'curso',
                FILTER_SANITIZE_SPECIAL_CHARS
            );

            $this->controller->processarMatricula(
                $nome,
                $idade,
                $curso
            );
        }
    }
}
