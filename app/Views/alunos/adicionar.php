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
    <title>Adicionar Aluno</title>
</head>

<body>

    <section id="create_aluno">
        <div class="container">
            <button onclick="goBack()">Voltar</button>
            <form action="/alunos/adicionar" method="post">
                <div class="containt-header">
                    <h1>Adicionar Aluno</h1>
                    <button type="submit" class="button">Adicionar Aluno</button>
                </div>

                <div>
                    <h2>Nome do aluno</h2>
                    <input type="text" id="nome" name="nome" placeholder="Nome do aluno" required>

                    <h2>Data de Nascimento</h2>
                    <div class="date-container">
                        <input type="date" id="data_nascimento" name="data_nascimento" placeholder="Data de Nascimento"
                            required>
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <h2>Turma (opcional)</h2>
                    <div class="select-wrapper">
                        <select id="turma-select" name="turma_id">
                            <option value="" selected>Selecione</option>

                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>

                    <h2>Usuário</h2>
                    <input type="email" id="email" name="email" placeholder="Digite o e-mail do usuário" required>
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
                    turmas.forEach(turma => {
                        const option = document.createElement('option');
                        option.value = turma.id;
                        option.textContent = turma.nome;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao carregar turmas:', error));
        });

    </script>

</body>

</html>