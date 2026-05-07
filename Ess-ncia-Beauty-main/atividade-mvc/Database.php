<?php

class Database
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {

            $config = parse_ini_file(__DIR__ . '/config.ini');

            self::$instance = new PDO(
                'sqlite:' . $config['db_path']
            );

            self::$instance->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }

        return self::$instance;
    }
}