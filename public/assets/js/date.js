document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('data_nascimento');

    // Forçar o calendário a abrir quando clicar no campo de data
    dateInput.addEventListener('click', function () {
        this.showPicker(); 
    });
});