//Lida com a ordenação e paginação da tabela
document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPage = 5;
    let currentPage = 1;
    const table = document.getElementById("alunosTable");
    const tbody = table.querySelector("tbody");
    const paginationContainer = document.querySelector(".pagination-container");
    let sortedRows = Array.from(tbody.querySelectorAll("tr"));
    let sortDirection = "asc"; // Direção inicial da ordenação

    function renderTable(page) {
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;

        sortedRows.forEach((row, index) => {
            row.style.display = (index >= startIndex && index < endIndex) ? "" : "none";
        });

        renderPaginationButtons(sortedRows.length);
    }

    function renderPaginationButtons(totalRows) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        paginationContainer.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement("button");
            button.textContent = i;
            button.className = i === currentPage ? 'active' : '';
            button.addEventListener('click', () => {
                currentPage = i;
                renderTable(currentPage);
            });
            paginationContainer.appendChild(button);
        }
    }

    function sortTable(columnIndex) {
        const headers = table.getElementsByTagName("th");

        // Remova as classes de ordenação de todos os cabeçalhos
        for (let i = 0; i < headers.length; i++) {
            headers[i].classList.remove("asc");
            headers[i].classList.remove("desc");
        }

        // Alterna a direção de ordenação
        sortDirection = sortDirection === "asc" ? "desc" : "asc";
        headers[columnIndex].classList.add(sortDirection);

        // Ordena as linhas
        sortedRows.sort((rowA, rowB) => {
            const cellA = rowA.getElementsByTagName("TD")[columnIndex].innerText.toLowerCase();
            const cellB = rowB.getElementsByTagName("TD")[columnIndex].innerText.toLowerCase();

            if (sortDirection === "asc") {
                return cellA.localeCompare(cellB);
            } else {
                return cellB.localeCompare(cellA);
            }
        });

        // Reanexar as linhas ordenadas ao tbody
        sortedRows.forEach(row => tbody.appendChild(row));

        // Atualize a tabela após a ordenação
        renderTable(currentPage);
    }

    function initializeSorting() {
        const nameColumnIndex = 1; 
        sortDirection = "desc"; 
        sortedRows = Array.from(tbody.querySelectorAll("tr"));
        sortTable(nameColumnIndex);
    }

    initializeSorting();
    renderTable(currentPage);

    const headers = table.querySelectorAll("th");
    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            sortedRows = Array.from(tbody.querySelectorAll("tr")); 
            sortTable(index);
        });
    });
});

