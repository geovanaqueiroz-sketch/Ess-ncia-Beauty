<?php

/**
 * AlunoModel - Entidade simples com propriedades e metodos magicos.
 * Nao contem nenhum SQL. A persistencia e responsabilidade do Repositorio.
 */
class AlunoModel
{
    private ?int $id = null;
    private string $nome;
    private int $idade;
    private string $curso;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getIdade(): int
    {
        return $this->idade;
    }

    public function getCurso(): string
    {
        return $this->curso;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setIdade(int $idade): void
    {
        $this->idade = $idade;
    }

    public function setCurso(string $curso): void
    {
        $this->curso = $curso;
    }
}
