<?php

require_once __DIR__ . '/BusinessRuleException.php';

class MatriculaController
{
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function processarMatricula(
        string $nome,
        int $idade,
        string $curso
    ): void {

        try {

            $resultado = $this->service
                ->processarMatricula($nome, $idade, $curso);

            $mensagem = "Matrícula realizada com sucesso!";

            require __DIR__ . '/view.php';

        } catch (BusinessRuleException $e) {

            $erro = $e->getMessage();

            require __DIR__ . '/view.php';

        } catch (Exception $e) {

            $erro = "Erro interno.";

            require __DIR__ . '/view.php';
        }
    }

    public function exibirFormulario(): void
    {
        require __DIR__ . '/view.php';
    }
}