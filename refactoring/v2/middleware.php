<?php

/**
 * Middleware - Validacao e sanitizacao dos dados de entrada.
 * Aplica filter_input para barrar tentativas de XSS na rota POST.
 */
class Middleware
{
    /**
     * Sanitiza e valida os dados do formulario.
     * Usa filter_input para barrar XSS e validar campos.
     */
    public static function validar(array $dados): array
    {
        $nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT);
        $curso = filter_input(INPUT_POST, 'curso', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($nome) || empty($idade) || empty($curso)) {
            self::encerrarComAviso("Todos os campos sao obrigatorios. Preencha Nome, Idade e Curso.");
        }

        if (trim($nome) === '') {
            self::encerrarComAviso("O campo Nome nao pode estar vazio.");
        }

        if (!is_numeric($idade)) {
            self::encerrarComAviso("O campo Idade deve ser um numero valido.");
        }

        $idadeInt = intval($idade);
        if ($idadeInt <= 0) {
            self::encerrarComAviso("A idade deve ser um numero positivo.");
        }

        return [
            'nome'  => trim($nome),
            'idade' => $idadeInt,
            'curso' => trim($curso),
        ];
    }

    private static function encerrarComAviso(string $mensagemAviso): void
    {
        $erro = $mensagemAviso;
        $mensagem = null;
        require __DIR__ . '/view.php';
        exit;
    }
}
