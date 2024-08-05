//Modal exclusão de um aluno
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
        alert("Excluído com sucesso!");
        modal.style.display = "none";
    });
});
