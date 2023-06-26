const Btn_ImprimirCantidadPartidas = document.getElementById("ImprimirCantidadPartidas");
const Btn_ImprimirCantidadJugadores = document.getElementById("ImprimirCantidadJugadores");
const Btn_ImprimirCantidadPreguntas = document.getElementById("ImprimirCantidadPreguntas");

Btn_ImprimirCantidadPartidas.addEventListener("click", () => imprimirReporte("imgCantidadPartidas", "estadisticasGenerales", "cantidadPartidas"));

Btn_ImprimirCantidadJugadores.addEventListener("click", () => imprimirReporte("imgCantidadJugadores", "estadisticasGenerales", "cantidadJugadores"));

Btn_ImprimirCantidadPreguntas.addEventListener("click", () => imprimirReporte("imgCantidadPreguntas", "estadisticasGenerales", "cantidadPreguntas"));

document.getElementById('dropdown-toggle-usuarios-totales').addEventListener('click', function() {
    document.getElementById('dropdown-menu-usuarios-totales').classList.toggle('hidden');
});

document.querySelectorAll('#dropdown-menu-usuarios-totales li').forEach(function(item) {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        const filter = event.target.dataset.filter;

        const img = document.getElementById("imgCantidadJugadores");
        img.src = "estadisticasGenerales/mostrarCantidadJugadores&option=" + filter;
    });
});