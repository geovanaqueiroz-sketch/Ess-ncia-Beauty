<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula de Aluno</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #ffe0e6 0%, #ffb6c1 50%, #ffc0cb 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #d63384;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .subtitulo {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: 600;
            font-size: 0.95rem;
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #ff69b4;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff69b4, #ff1493);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-top: 10px;
        }

        button:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.4);
        }

        .mensagem-sucesso {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .mensagem-erro {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Matrícula de Aluno</h1>
    <p class="subtitulo">Preencha os dados para realizar a matrícula</p>

    <?php if (!empty($mensagem)): ?>
        <div class="mensagem-sucesso"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <?php if (!empty($erro)): ?>
        <div class="mensagem-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" action="/">
        <div class="campo">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Digite o nome do aluno">
        </div>

        <div class="campo">
            <label for="idade">Idade</label>
            <input type="number" id="idade" name="idade" placeholder="Digite a idade" min="1" max="120">
        </div>

        <div class="campo">
            <label for="curso">Curso</label>
            <select id="curso" name="curso">
                <option value="">Selecione o curso...</option>
                <option value="Engenharia">Engenharia</option>
                <option value="Medicina">Medicina</option>
                <option value="Direito">Direito</option>
                <option value="Administração">Administração</option>
                <option value="Design">Design</option>
            </select>
        </div>

        <button type="submit">Matricular</button>
    </form>
</div>

</body>
</html>
