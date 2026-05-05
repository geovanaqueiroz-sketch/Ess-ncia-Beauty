<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/IMatriculaRepository.php';
require_once __DIR__ . '/model.php';

/**
 * MatriculaRepository - Implementacao concreta do repositorio.
 * Todo o SQL (PDO) fica contido estritamente dentro do Repositorio.
 */
class MatriculaRepository implements IMatriculaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(AlunoModel $aluno): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO alunos (nome, idade, curso) VALUES (:nome, :idade, :curso)"
        );
        $stmt->bindValue(':nome', $aluno->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':idade', $aluno->getIdade(), PDO::PARAM_INT);
        $stmt->bindValue(':curso', $aluno->getCurso(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function find(int $id): ?AlunoModel
    {
        $stmt = $this->pdo->prepare("SELECT * FROM alunos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        $aluno = new AlunoModel();
        $aluno->setNome($row['nome']);
        $aluno->setIdade((int)$row['idade']);
        $aluno->setCurso($row['curso']);

        return $aluno;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM alunos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
