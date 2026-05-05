<?php

/**
 * Interface IMatriculaRepository - Contrato para o repositorio de matriculas.
 * Define os metodos obrigatorios que qualquer implementacao deve seguir.
 */
interface IMatriculaRepository
{
    public function save(AlunoModel $aluno): bool;

    public function find(int $id): ?AlunoModel;

    public function delete(int $id): bool;
}
