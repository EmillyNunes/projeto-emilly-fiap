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
    <section id="create_turma">
        <div class="container">
            <button onclick="goBack()">Voltar</button>
            <form action="/turmas/adicionar" method="post" onsubmit="return validateForm()">
                <div class="containt-header">
                    <h1>Turma</h1>
                    <button type="submit" class="button">Salvar turma</button>
                </div>
                <div>
                    <h2>
                        Nome da turma
                    </h2>
                    <input type="text" id="nome" name="nome" required placeholder="nome da turma">
                    <h2>
                        Tipo da Turma
                    </h2>
                    <div class="select-wrapper">
                        <select id="options" name="tipo" required>
                            <option value="Selecione" selected>Selecione</option>
                            <option value="Técnologo">Técnologo</option>
                            <option value="MBA">MBA</option>
                            <option value="Graduação">Graduação</option>
                            <option value="Pós Graduação">Pós Graduação</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>

                    <h3>
                        Descrição
                    </h3>
                    <textarea id="message" name="descricao" rows="4" placeholder="Descrição" required></textarea>
                </div>
            </form>
        </div>
    </section>
</body>

</html>