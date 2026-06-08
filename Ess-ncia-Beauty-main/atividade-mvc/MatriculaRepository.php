<?php

require_once __DIR__ . '/IMatriculaRepository.php';

class MatriculaRepository implements IMatriculaRepository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(array $data)
    {
        $sql = "INSERT INTO alunos(nome, idade, curso)
                VALUES(:nome, :idade, :curso)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':nome' => $data['nome'],
            ':idade' => $data['idade'],
            ':curso' => $data['curso']
        ]);
    }

    public function find(int $id)
    {
        return null;
    }

    public function delete(int $id)
    {
        return null;
    }
}