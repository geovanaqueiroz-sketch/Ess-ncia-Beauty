<?php

require_once __DIR__ . '/Database.php';

/**
 * Migration - Cria as tabelas do banco usando o Singleton Database.
 */
class Migration
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function executar(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS alunos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            idade INTEGER NOT NULL,
            curso TEXT NOT NULL
        )";

        $this->pdo->exec($sql);
        echo "Migration executada com sucesso! Tabela 'alunos' criada.\n";
    }
}

$migration = new Migration();
$migration->executar();
