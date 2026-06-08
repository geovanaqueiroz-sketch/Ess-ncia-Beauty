<?php

class Middleware
{
    /**
     * Valida os dados do formulário antes de passar ao Controller.
     * Verifica se todos os campos foram preenchidos e se a idade é um número.
     * Retorna true se válido, ou encerra com mensagem de aviso.
     */
    public static function validar(array $dados): bool
    {
        // Verificar se todos os campos foram preenchidos
        if (empty($dados['nome']) || empty($dados['idade']) || empty($dados['curso'])) {
            self::encerrarComAviso("Todos os campos são obrigatórios. Preencha Nome, Idade e Curso.");
        }

        // Verificar se o nome não é apenas espaços
        if (trim($dados['nome']) === '') {
            self::encerrarComAviso("O campo Nome não pode estar vazio.");
        }

        // Verificar se a idade é realmente um número
        if (!is_numeric($dados['idade'])) {
            self::encerrarComAviso("O campo Idade deve ser um número válido.");
        }

        // Verificar se a idade é um número inteiro positivo
        $idade = intval($dados['idade']);
        if ($idade <= 0) {
            self::encerrarComAviso("A idade deve ser um número positivo.");
        }

        return true;
    }

    /**
     * Encerra o processo com uma mensagem de aviso amigável.
     */
    private static function encerrarComAviso(string $mensagemAviso): void
    {
        $erro = $mensagemAviso;
        $mensagem = null;
        require __DIR__ . '/view.php';
        exit;
    }
}
