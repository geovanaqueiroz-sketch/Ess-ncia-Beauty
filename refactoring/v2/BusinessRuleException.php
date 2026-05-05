<?php

/**
 * BusinessRuleException - Excecao personalizada para regras de negocio.
 * O Service lanca esta excecao quando regras complexas do sistema falham.
 */
class BusinessRuleException extends Exception
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
