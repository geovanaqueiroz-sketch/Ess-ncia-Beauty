<?php

require_once __DIR__ . '/BusinessRuleException.php';

/**
 * MatriculaController - Controller enxuto.
 * Recebe suas dependencias via construtor (DI).
 * O metodo store() contem apenas um bloco try-catch, sem if/else de regras.
 */
class MatriculaController
{
    private MatriculaService $service;

    public function __construct(MatriculaService $service)
    {
        $this->service = $service;
    }

    /**
     * Salva os dados - apenas try-catch.
     * Se capturar BusinessRuleException, renderiza a view com erro.
     * Se houver sucesso, redireciona o usuario.
     */
    public function store(string $nome, int $idade, string $curso): void
    {
        try {
            $resultado = $this->service->processarMatricula($nome, $idade, $curso);

            $mensagem = "Matricula realizada com sucesso! Aluno: {$resultado['nome']}, Curso: {$resultado['curso']}.";

            if ($resultado['bolsa'] !== null) {
                $mensagem .= " Parabens! Voce ganhou uma bolsa de {$resultado['bolsa']}% de desconto!";
            }

            $erro = null;
            require __DIR__ . '/view.php';

        } catch (BusinessRuleException $e) {
            $erro = $e->getMessage();
            $mensagem = null;
            require __DIR__ . '/view.php';

        } catch (Exception $e) {
            $erro = "Ocorreu um erro interno. Tente novamente mais tarde.";
            $mensagem = null;
            require __DIR__ . '/view.php';
        }
    }

    public function exibirFormulario(): void
    {
        $mensagem = null;
        $erro = null;
        require __DIR__ . '/view.php';
    }
}
