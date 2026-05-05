<?php

/**
 * Classe Database - Singleton para conexao com o banco de dados.
 * Le as configuracoes do arquivo config.ini e retorna uma unica instancia PDO.
 * Nenhum outro arquivo do sistema deve saber como conectar ao banco.
 */
class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $configPath = __DIR__ . '/config.ini';

            if (!file_exists($configPath)) {
                throw new RuntimeException("Arquivo de configuracao config.ini nao encontrado.");
            }

            $config = parse_ini_file($configPath, true);

            if ($config === false) {
                throw new RuntimeException("Erro ao ler o arquivo de configuracao config.ini.");
            }

            $driver = $config['database']['driver'] ?? 'sqlite';
            $dbPath = $config['database']['path'] ?? 'database.sqlite';

            $dsn = $driver . ':' . __DIR__ . '/' . $dbPath;

            self::$instance = new PDO($dsn);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return self::$instance;
    }
}
