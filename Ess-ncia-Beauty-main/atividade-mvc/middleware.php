<?php

class Middleware
{
    public static function validar()
    {
        if (
            empty($_POST['nome']) ||
            empty($_POST['idade']) ||
            empty($_POST['curso'])
        ) {
            die("Todos os campos são obrigatórios.");
        }
    }
}