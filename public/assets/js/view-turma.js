document.addEventListener('DOMContentLoaded', function() {

    var modal = document.getElementById("matricularAlunoModal");
    var btn = document.getElementById("matricularAlunoBtn");
    var span = document.querySelector("#matricularAlunoModal .close");
    var cancelBtn = document.getElementById("cancelarMatricula");
    var confirmBtn = document.getElementById("matricularAluno");
    var confirmationMessage = document.getElementById("matriculaConfirmation");
    var searchInput = document.getElementById("searchAluno");

    // Quando o usuário clica no botão, abre o modal
    if (btn) {
        btn.onclick = function() {
            modal.style.display = "block";
        }
    }

    // Quando o usuário clica no "x", fecha o modal
    if (span) {
        span.onclick = function() {
            closeModal();
        }
    }

    // Quando o usuário clica em cancelar, fecha o modal
    if (cancelBtn) {
        cancelBtn.onclick = function() {
            closeModal();
        }
    }

    // Filtra a lista de alunos
    if (searchInput) {
        searchInput.addEventListener("input", function() {
            var query = searchInput.value.toLowerCase();
            var resultsContainer = document.getElementById("alunoResults");

            // Simula quando pesquisa as pessoas a apresentarem e serem selecionadas
            var alunos = ["Emilly Nunes Simão Ferreira", "João Silva", "Ana Pereira"];
            var filteredAlunos = alunos.filter(function(aluno) {
                return aluno.toLowerCase().includes(query);
            });

            resultsContainer.innerHTML = "";

            filteredAlunos.forEach(function(aluno) {
                var div = document.createElement("div");
                div.textContent = aluno;
                resultsContainer.appendChild(div);
            });
        });
    }

    function closeModal() {
        modal.style.display = "none";
        confirmationMessage.style.display = "none";
    }
});

//Modal exclusão de uma turma
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("confirmDeleteModal");
    const closeBtn = document.querySelector(".modal .close");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    document.querySelectorAll(".fa-trash-can").forEach(trashIcon => {
        trashIcon.addEventListener("click", function (event) {
            event.preventDefault();
            modal.style.display = "block";
        });
    });

    closeBtn.onclick = function () {
        modal.style.display = "none";
    };

    cancelDeleteBtn.onclick = function () {
        modal.style.display = "none";
    };

    confirmDeleteBtn.addEventListener("click", function () {
        // Lógica para excluir o aluno
        alert("Aluno excluído da turma!");
        modal.style.display = "none";
    });
});

