<?php

/**
 * Middleware - Validacao e sanitizacao dos dados de entrada.
 * Aplica sanitizacao com strip_tags e filter_var para barrar XSS na rota POST.
 */
class Middleware
{
    /**
     * Sanitiza e valida os dados do formulario.
     * Usa o parametro $dados (ao inves de ler direto do superglobal) para
     * manter testabilidade. Aplica strip_tags para remover tags HTML/script
     * sem causar double-encoding (a view ja usa htmlspecialchars na saida).
     */
    public static function validar(array $dados): array
    {
        $nome  = isset($dados['nome']) ? strip_tags(trim($dados['nome'])) : '';
        $idade = isset($dados['idade']) ? filter_var($dados['idade'], FILTER_SANITIZE_NUMBER_INT) : '';
        $curso = isset($dados['curso']) ? strip_tags(trim($dados['curso'])) : '';

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
            'nome'  => $nome,
            'idade' => $idadeInt,
            'curso' => $curso,
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
