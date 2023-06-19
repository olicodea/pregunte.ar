function mostrarModalReportadas(idPregunta, pregunta) {
    const modal = document.getElementById('modal-reportadas');
    modal.classList.remove('hidden');

    modal.addEventListener('click', function(event) {
        if (event.target === document.querySelector('.modal-overlay')) {
            cancelarModal("reportadas");
        }
    });
}