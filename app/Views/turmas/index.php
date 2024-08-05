<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="/assets/js/order_pagination.js" defer></script>
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/modal_delete.js"></script>
    <link rel="stylesheet" href="/assets/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <title>Turmas</title>
</head>

<body>
    <section id="turmas">
        <div class="container">
            <button onclick="goBack()">Voltar</button>
            <div class="containt-header">
                <h1>Turmas</h1>
                <a href="/turmas/adicionar" class="button">Cadastrar turma</a>
            </div>
            <!-- busca por nome -->
            <div class="search">
                <input type="text" id="searchTerm" class="searchTerm" placeholder="Digite o nome da turma">
                <button type="submit" id="searchButton" class="searchButton">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <!-- ... -->
            <div class="table-container">
                <table id="alunosTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">ID <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(1)">Nome <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(2)">Descrição <i class="fa-solid fa-sort-up"></i></th>
                            <th onclick="sortTable(3)">Tipo <i class="fa-solid fa-sort-up"></i></th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turmas as $turma): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($turma->id, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($turma->nome, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($turma->descricao, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($turma->tipo, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="/turmas/atualizar/<?php echo $turma->id; ?>"><i
                                            class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="#" class="delete-turma" data-id="<?php echo $turma->id; ?>"><i
                                            class="fa-regular fa-trash-can"></i></a>
                                    <form action="/turmas/deletar/<?php echo $turma->id; ?>" method="post"
                                        class="delete-form" style="display:none;">
                                        <input type="hidden" name="_METHOD" value="DELETE">
                                    </form>
                                    <a href="/turmas/visualizar/<?php echo $turma->id; ?>"><i
                                            class="fa-regular fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Contêiner para os botões de paginação -->
            <div class="pagination-container"></div>
        </div>
    </section>

    <!-- Modal de exclusão da turma -->
    <div id="confirmDeleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Tem certeza que deseja excluir essa turma?</p>
            <button id="confirmDeleteBtn">Sim</button>
            <button id="cancelDeleteBtn">Não</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById("confirmDeleteModal");
            const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
            const closeBtn = document.querySelector(".close");
            let formToSubmit;

            document.querySelectorAll('.delete-turma').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    formToSubmit = this.nextElementSibling;
                    modal.style.display = "block";
                });
            });

            confirmDeleteBtn.addEventListener('click', function () {
                formToSubmit.submit();
            });

            cancelDeleteBtn.addEventListener('click', function () {
                modal.style.display = "none";
            });

            closeBtn.addEventListener('click', function () {
                modal.style.display = "none";
            });

            window.addEventListener('click', function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>