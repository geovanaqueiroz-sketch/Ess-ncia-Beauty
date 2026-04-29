<?php

require_once __DIR__ . '/service.php';
require_once __DIR__ . '/model.php';

class MatriculaController
{
    private MatriculaService $service;

    public function __construct()
    {
        $this->service = new MatriculaService();
    }

    /**
     * Processa a matrícula: chama o Service para regras de negócio
     * e o Model para salvar no banco de dados.
     */
    public function processarMatricula(string $nome, int $idade, string $curso): void
    {
        try {
            // Chamar o serviço para aplicar as regras de negócio
            $resultado = $this->service->processarMatricula($nome, $idade, $curso);

            // Instanciar o Model e salvar no SQLite
            $aluno = new AlunoModel();
            $aluno->setNome($resultado['nome']);
            $aluno->setIdade($resultado['idade']);
            $aluno->setCurso($resultado['curso']);
            $aluno->save();

            // Montar mensagem de sucesso
            $mensagem = "Matrícula realizada com sucesso! Aluno: {$resultado['nome']}, Curso: {$resultado['curso']}.";

            if ($resultado['bolsa'] !== null) {
                $mensagem .= " Parabéns! Você ganhou uma bolsa de {$resultado['bolsa']}% de desconto!";
            }

            require __DIR__ . '/view.php';

        } catch (Exception $e) {
            $erro = $e->getMessage();
            require __DIR__ . '/view.php';
        }
    }

    /**
     * Exibe o formulário vazio.
     */
    public function exibirFormulario(): void
    {
        $mensagem = null;
        $erro = null;
        require __DIR__ . '/view.php';
    }
}
