<?php

require_once __DIR__ . '/IMatriculaRepository.php';
require_once __DIR__ . '/BusinessRuleException.php';
require_once __DIR__ . '/model.php';

/**
 * MatriculaService - Regra de negocio com Injecao de Dependencia.
 * O Service NAO instancia o Repositorio internamente.
 * Recebe a Interface do Repositorio como parametro no construtor (DI).
 */
class MatriculaService
{
    private IMatriculaRepository $repository;

    private array $idadeMinimaPorCurso = [
        'Engenharia'     => 17,
        'Medicina'       => 18,
        'Direito'        => 17,
        'Administração'  => 16,
        'Design'         => 16,
    ];

    private array $bolsaPorCurso = [
        'Engenharia'     => ['idade_max' => 20, 'desconto' => 30],
        'Administração'  => ['idade_max' => 22, 'desconto' => 25],
        'Design'         => ['idade_max' => 21, 'desconto' => 20],
    ];

    public function __construct(IMatriculaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Processa a matricula aplicando regras de negocio.
     * Lanca BusinessRuleException se alguma regra falhar.
     */
    public function processarMatricula(string $nome, int $idade, string $curso): array
    {
        if (!array_key_exists($curso, $this->idadeMinimaPorCurso)) {
            throw new BusinessRuleException(
                "O curso '$curso' nao esta disponivel. Cursos disponiveis: "
                . implode(', ', array_keys($this->idadeMinimaPorCurso))
            );
        }

        $idadeMinima = $this->idadeMinimaPorCurso[$curso];
        if ($idade < $idadeMinima) {
            throw new BusinessRuleException(
                "Idade minima para o curso de $curso e $idadeMinima anos. Voce informou $idade anos."
            );
        }

        $bolsa = null;
        if (isset($this->bolsaPorCurso[$curso])) {
            $regra = $this->bolsaPorCurso[$curso];
            if ($idade <= $regra['idade_max']) {
                $bolsa = $regra['desconto'];
            }
        }

        $aluno = new AlunoModel();
        $aluno->setNome($nome);
        $aluno->setIdade($idade);
        $aluno->setCurso($curso);
        $this->repository->save($aluno);

        return [
            'nome'  => $nome,
            'idade' => $idade,
            'curso' => $curso,
            'bolsa' => $bolsa,
        ];
    }
}
