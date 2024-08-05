<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="./assets/view_turma.js"></script>
    <script src="/assets/js/common.js"></script>
    <link rel="stylesheet" href="/assets/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <title>Trurma - ADS</title>
</head>

<body>
    <section id="edit_turma">
        <div class="container">
            <button onclick="goBack()">Voltar</button>
            <form action="/turmas/atualizar/<?php echo $turma->getId(); ?>" method="post"
                onsubmit="return validateForm()">
                <div class="containt-header">
                    <h1>Turma</h1>
                    <button type="submit" class="button">Atualizar</button>
                </div>
                <div>
                    <input type="hidden" name="_METHOD" value="PUT">
                    <h2>
                        Nome da Turma
                    </h2>
                    <input type="text" id="nome" name="nome"
                        value="<?php echo htmlspecialchars($turma->getNome(), ENT_QUOTES, 'UTF-8'); ?>">

                    <h2>
                        Tipo da Turma
                    </h2>
                    <div class="select-wrapper">
                        <select id="options" name="tipo">
                            <option value="Selecione">Selecione</option>
                            <option value="Técnologo" <?php if ($turma->getTipo() == 'Técnologo')
                                echo 'selected'; ?>>
                                Técnologo</option>
                            <option value="MBA" <?php if ($turma->getTipo() == 'MBA')
                                echo 'selected'; ?>>MBA</option>
                            <option value="Graduação" <?php if ($turma->getTipo() == 'Graduação')
                                echo 'selected'; ?>>
                                Graduação</option>
                            <option value="Pós Graduação" <?php if ($turma->getTipo() == 'Pós Graduação')
                                echo 'selected'; ?>>Pós Graduação</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>

                    <h2>
                        Descrição
                    </h2>
                    <textarea id="message"
                        name="descricao"><?php echo htmlspecialchars($turma->getDescricao(), ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
            </form>
        </div>
    </section>
</body>

</html>