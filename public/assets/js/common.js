//usuário retorna para a página de onde veio

function goBack() {
    window.history.back();
}

//buscar usuarios por nome
document.addEventListener('DOMContentLoaded', () => {
    const searchTermInput = document.getElementById('searchTerm');
    const searchButton = document.getElementById('searchButton');
    const table = document.getElementById('alunosTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    function filterTable() {
        const searchTerm = searchTermInput.value.toLowerCase();
        Array.from(rows).forEach(row => {
            const nome = row.getElementsByTagName('td')[1].textContent.toLowerCase();
            if (nome.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchTermInput.addEventListener('input', filterTable);
    searchButton.addEventListener('click', (event) => {
        event.preventDefault();
        filterTable();
    });
});

//obrigar select em turmas 
function validateForm() {
    const tipo = document.getElementById('options').value;
    if (tipo === "Selecione") {
        alert("Por favor, selecione um tipo de turma válido.");
        return false;
    }
    return true;
}