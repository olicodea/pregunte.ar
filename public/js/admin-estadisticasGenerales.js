const Btn_ImprimirCantidadPartidas = document.getElementById("ImprimirCantidadPartidas");
const Btn_ImprimirCantidadJugadores = document.getElementById("ImprimirCantidadJugadores");
const Btn_ImprimirCantidadPreguntas = document.getElementById("ImprimirCantidadPreguntas");
const Btn_ImprimirCantidadUsuariosNuevos = document.getElementById("ImprimirCantidadUsuariosNuevos");
Btn_ImprimirCantidadPartidas.addEventListener("click", () => imprimirReporte("imgCantidadPartidas", "estadisticasGenerales", "cantidadPartidas"));

Btn_ImprimirCantidadJugadores.addEventListener("click", () => imprimirReporte("imgCantidadJugadores", "estadisticasGenerales", "cantidadJugadores"));

Btn_ImprimirCantidadPreguntas.addEventListener("click", () => imprimirReporte("imgCantidadPreguntas", "estadisticasGenerales", "cantidadPreguntas"));

Btn_ImprimirCantidadUsuariosNuevos.addEventListener("click", () => imprimirReporte("imgCantidadUsuariosNuevos", "estadisticasGenerales", "cantidadUsuariosNuevos"))
document.getElementById('dropdown-toggle-usuarios-totales').addEventListener('click', function() {
    document.getElementById('dropdown-menu-usuarios-totales').classList.toggle('hidden');
});

document.getElementById('dropdown-toggle-preguntas-totales').addEventListener('click', function() {
    document.getElementById('dropdown-menu-preguntas-totales').classList.toggle('hidden');
});

document.querySelectorAll('#dropdown-menu-usuarios-totales li').forEach(function(item) {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        const filter = event.target.dataset.filter;

        const img = document.getElementById("imgCantidadJugadores");
        img.src = "estadisticasGenerales/mostrarCantidadJugadores&option=" + filter;
    });
});

document.querySelectorAll('#dropdown-menu-preguntas-totales li').forEach(function(item) {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        const filter = event.target.dataset.filter;

        const img = document.getElementById("imgCantidadPreguntas");
        img.src = "estadisticasGenerales/mostrarCantidadPreguntas&option=" + filter;
    });
});