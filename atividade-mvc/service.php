<?php

class MatriculaService
{
    // Idade mínima por curso
    private array $idadeMinimaPorCurso = [
        'Engenharia'     => 17,
        'Medicina'       => 18,
        'Direito'        => 17,
        'Administração'  => 16,
        'Design'         => 16,
    ];

    // Cursos com bolsa disponível (idade <= limite ganha bolsa)
    private array $bolsaPorCurso = [
        'Engenharia'     => ['idade_max' => 20, 'desconto' => 30],
        'Administração'  => ['idade_max' => 22, 'desconto' => 25],
        'Design'         => ['idade_max' => 21, 'desconto' => 20],
    ];

    /**
     * Processa a matrícula aplicando regras de negócio.
     * Retorna um array com os dados processados e informações de bolsa.
     * Lança Exception se alguma regra falhar.
     */
    public function processarMatricula(string $nome, int $idade, string $curso): array
    {
        // Verificar se o curso existe
        if (!array_key_exists($curso, $this->idadeMinimaPorCurso)) {
            throw new Exception("O curso '$curso' não está disponível. Cursos disponíveis: " . implode(', ', array_keys($this->idadeMinimaPorCurso)));
        }

        // Verificar idade mínima do curso
        $idadeMinima = $this->idadeMinimaPorCurso[$curso];
        if ($idade < $idadeMinima) {
            throw new Exception("Idade mínima para o curso de $curso é $idadeMinima anos. Você informou $idade anos.");
        }

        // Verificar elegibilidade para bolsa de estudos
        $bolsa = null;
        if (isset($this->bolsaPorCurso[$curso])) {
            $regra = $this->bolsaPorCurso[$curso];
            if ($idade <= $regra['idade_max']) {
                $bolsa = $regra['desconto'];
            }
        }

        return [
            'nome'  => $nome,
            'idade' => $idade,
            'curso' => $curso,
            'bolsa' => $bolsa,
        ];
    }
}
