<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="/assets/js/view-turma.js" defer></script>
    <script src="/assets/js/order_pagination.js" defer></script>
    <script src="/assets/js/common.js"></script>
    <link rel="stylesheet" href="/assets/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <title>Turma - ADS</title>
</head>

<body>
    <!-- Seção de visualização das turmas e a possibilidade de cadastrar um novo aluno na turma que está sendo visualizada -->
    <section id="view_turma">
        <div class="container">
            <button onclick="goBack()">Voltar</button>
            <div class="containt-header">
                <h1>Turma</h1>
                <button id="matricularAlunoBtn">Matricular aluno</button>
            </div>
            <div>
                <h2><?php echo htmlspecialchars($turma->getNome(), ENT_QUOTES, 'UTF-8'); ?> -
                    <?php echo htmlspecialchars($turma->getTipo(), ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <h3>Descrição</h3>
                <p><?php echo htmlspecialchars($turma->getDescricao(), ENT_QUOTES, 'UTF-8'); ?></p>

            </div>
            <div class="search">
                <input type="text" class="searchTerm" placeholder="Digite o nome do aluno">
                <button type="submit" class="searchButton">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div class="table-container">
                <table id="alunosTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">ID <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(1)">Nome <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(2)">Idade <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(3)">Usuário <i class="fa-solid fa-sort-up"></i></th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($alunos)): ?>
                            <tr>
                                <td colspan="5">Nenhum aluno encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($alunos as $aluno): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($aluno->id); ?></td>
                                    <td><?php echo htmlspecialchars($aluno->nome); ?></td>
                                    <td><?php echo htmlspecialchars($aluno->data_nascimento); ?></td>
                                    <td><?php echo htmlspecialchars($aluno->email); ?></td>
                                    <td>
                                        <a href="/alunos/atualizar/<?php echo $aluno->id; ?>"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                        <a href=""><i class="fa-regular fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Contêiner para os botões de paginação -->
            <div class="pagination-container"></div>

            <!-- Modal de exclusão de aluno da turma -->
            <div id="confirmDeleteModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Tem certeza que deseja excluir esse(a) aluno(a) da turma?</p>
                    <button id="confirmDeleteBtn">Sim</button>
                    <button id="cancelDeleteBtn">Não</button>
                </div>
            </div>

            <!-- Modal para matricular aluno -->
            <div id="matricularAlunoModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Matricular Aluno</h2>
                    <p>Busque o nome do aluno abaixo para matriculá-lo a essa turma</p>
                    <form id="matricularAlunoForm" action="/matriculas/adicionar" method="POST">
                        <input type="hidden" name="turma_id" value="<?= htmlspecialchars($idTurma) ?>">
                        <select name="aluno_id" id="aluno" required>
                            <option value="">Selecione um aluno sem turma</option>
                            <?php if (!empty($alunosNaoMatriculados)): ?>
                                <?php foreach ($alunosNaoMatriculados as $aluno): ?>
                                    <option value="<?= htmlspecialchars($aluno->id) ?>"><?= htmlspecialchars($aluno->nome) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Nenhum aluno disponível</option>
                            <?php endif; ?>
                        </select>
                        <button id="matricularAluno" type="submit">Matricular Aluno</button>
                        <button id="cancelarMatricula" type="button">Cancelar</button>
                    </form>
                </div>
            </div>

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var matricularAlunoBtn = document.getElementById('matricularAlunoBtn');
            var matricularAlunoModal = document.getElementById('matricularAlunoModal');
            var closeBtns = document.getElementsByClassName('close');
            var cancelBtn = document.getElementById('cancelarMatricula');
            var matricularAlunoButton = document.getElementById('matricularAluno');

            // Show the modal
            matricularAlunoBtn.addEventListener('click', function () {
                matricularAlunoModal.style.display = 'block';
            });

            // Hide the modal
            Array.from(closeBtns).forEach(function (btn) {
                btn.addEventListener('click', function () {
                    matricularAlunoModal.style.display = 'none';
                });
            });

            cancelBtn.addEventListener('click', function () {
                matricularAlunoModal.style.display = 'none';
            });

            // Close the modal if the user clicks outside of it
            window.addEventListener('click', function (event) {
                if (event.target === matricularAlunoModal) {
                    matricularAlunoModal.style.display = 'none';
                }
            });

            // Disabilitar o botão se não for possível matricular o aluno
            var alunoSelect = document.getElementById('aluno');

            alunoSelect.addEventListener('change', function () {
                var alunoId = alunoSelect.value;
                if (alunoId === '') {
                    matricularAlunoButton.disabled = true;
                } else {
                    matricularAlunoButton.disabled = false;
                }
            });

            // Verifica a validade da matrícula após a seleção
            var form = document.getElementById('matricularAlunoForm');

            form.addEventListener('submit', function (event) {
                var alunoId = alunoSelect.value;
                if (alunoId === '') {
                    // Previne o envio do formulário se não houver um aluno selecionado
                    event.preventDefault();
                    alert('Por favor, selecione um aluno para matricular.');
                }
            });
        });

    </script>
</body>

</html>