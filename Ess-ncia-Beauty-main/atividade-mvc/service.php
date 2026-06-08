<?php

require_once __DIR__ . '/BusinessRuleException.php';

class MatriculaService
{
    private $repo;

    public function __construct(IMatriculaRepository $repo)
    {
        $this->repo = $repo;
    }

    private array $idadeMinimaPorCurso = [
        'Engenharia' => 17,
        'Medicina' => 18,
        'Direito' => 17,
        'Administração' => 16,
        'Design' => 16,
    ];

    public function processarMatricula(
        string $nome,
        int $idade,
        string $curso
    ): array {

        if (!isset($this->idadeMinimaPorCurso[$curso])) {
            throw new BusinessRuleException("Curso inválido.");
        }

        if ($idade < $this->idadeMinimaPorCurso[$curso]) {
            throw new BusinessRuleException(
                "Idade mínima para $curso é {$this->idadeMinimaPorCurso[$curso]}"
            );
        }

        $dados = [
            'nome' => $nome,
            'idade' => $idade,
            'curso' => $curso
        ];

        $this->repo->save($dados);

        return $dados;
    }
}