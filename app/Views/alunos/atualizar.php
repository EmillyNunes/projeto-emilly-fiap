<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="/assets/js/aluno.js"></script>
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/date.js"></script>
    <link rel="stylesheet" href="/assets/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <title>Aluno - <?php echo htmlspecialchars($aluno->getNome(), ENT_QUOTES, 'UTF-8'); ?></title>
</head>

<body>

    <section id="edit_aluno">
        <div class="container">
            <button onclick="goBack()">Voltar</button>
            <form action="/alunos/atualizar/<?php echo $aluno->getId(); ?>" method="post">
                <div class="containt-header">
                    <h1>Aluno - <?php echo htmlspecialchars($aluno->getNome(), ENT_QUOTES, 'UTF-8'); ?></h1>
                    <button type="submit" class="button">Atualizar</button>
                    <input type="hidden" name="_METHOD" value="PUT">
                </div>
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome"
                        value="<?php echo htmlspecialchars($aluno->getNome(), ENT_QUOTES, 'UTF-8'); ?>">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email"
                        value="<?php echo htmlspecialchars($aluno->getEmail(), ENT_QUOTES, 'UTF-8'); ?>">

                    <label for="data_nascimento">Data de Nascimento:</label>
                    <div class="date-container">
                        <input type="date" id="data_nascimento" name="data_nascimento"
                            value="<?php echo htmlspecialchars($aluno->getDataNascimento(), ENT_QUOTES, 'UTF-8'); ?>">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <label for="turma">Turma:</label>
                    <div class="select-wrapper">
                        <select id="turma-select" name="turma">
                            <option value="">Selecione</option>

                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/turmas/json')
                .then(response => response.json())
                .then(turmas => {
                    const select = document.getElementById('turma-select');
                    const alunoTurmaId = <?php echo json_encode($matriculaAtual ? $matriculaAtual->id_turma : null); ?>;

                    turmas.forEach(turma => {
                        const option = document.createElement('option');
                        option.value = turma.id;
                        option.textContent = turma.nome;

                        if (turma.id == alunoTurmaId) {
                            option.selected = true;
                        }

                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao carregar turmas:', error));
        });
    </script>

</body>

</html>