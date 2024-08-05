<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="/assets/js/modal_delete.js"></script>
    <script src="/assets/js/order_pagination.js" defer></script>
    <script src="/assets/js/common.js"></script>
    <link rel="stylesheet" href="/assets/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <title>Alunos</title>
</head>

<body>
    <section id="alunos">
        <div class="container">
            <button onclick="goBack()">Voltar</button>
            <div class="containt-header">
                <h1>Alunos</h1>
                <a href="/alunos/adicionar" class="button">Cadastrar Aluno</a>
            </div>
            <!-- busca por nome -->
            <div class="search">
                <input type="text" id="searchTerm" class="searchTerm" placeholder="Digite o nome da turma">
                <button type="submit" id="searchButton" class="searchButton">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <!-- .. -->
            <div class="table-container">
                <table id="alunosTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">ID <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(1)">Nome <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(3)">Usuário <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(2)">Data de Nascimento <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(4)">Turma <i class="fa-solid fa-sort-up"></i></th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aluno->id, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($aluno->nome, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($aluno->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($aluno->data_nascimento, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($aluno->turma, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="/alunos/atualizar/<?php echo $aluno->id; ?>"><i
                                            class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="#" class="delete-btn" data-id="<?php echo $aluno->id; ?>"><i
                                            class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
            <div class="pagination-container"></div> <!-- Contêiner para os botões de paginação -->
        </div>
    </section>
    <!-- Modal para exclusão de alunos  -->
    <div id="confirmDeleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Tem certeza que deseja excluir o aluno(a) <span id="studentName"></span>?</p>
            <button id="confirmDeleteBtn">Sim</button>
            <button id="cancelDeleteBtn">Não</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const modal = document.getElementById('confirmDeleteModal');
            const confirmButton = document.getElementById('confirmDeleteBtn');
            const cancelButton = document.getElementById('cancelDeleteBtn');
            let studentIdToDelete = null;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    studentIdToDelete = this.getAttribute('data-id');
                    modal.style.display = 'block';
                });
            });

            confirmButton.addEventListener('click', function () {
                fetch(`/alunos/deletar/${studentIdToDelete}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-HTTP-Method-Override': 'DELETE'
                    },
                    body: new URLSearchParams({
                        '_METHOD': 'DELETE'
                    })
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erro ao excluir o aluno.');
                    }
                }).catch(() => alert('Erro ao excluir o aluno.'));
            });

            cancelButton.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            document.querySelector('.modal .close').addEventListener('click', function () {
                modal.style.display = 'none';
            });
        });

    </script>

</body>

</html>