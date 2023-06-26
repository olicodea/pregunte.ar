const Btn_ImprimirJugadoresPais = document.getElementById("ImprimirJugadoresPais");
const Btn_ImprimirJugadoresGenero = document.getElementById("ImprimirJugadoresGenero");
const Btn_ImprimirJugadoresGrupoEdad = document.getElementById("ImprimirJugadoresGrupoEdad");

Btn_ImprimirJugadoresPais.addEventListener("click", () => imprimirReporte("imgJugadoresPais", "estadisticasJugadores", "jugadoresPais"));

Btn_ImprimirJugadoresGenero.addEventListener("click", () => imprimirReporte("imgJugadoresGenero", "estadisticasJugadores", "jugadoresGenero"));

Btn_ImprimirJugadoresGrupoEdad.addEventListener("click", () => imprimirReporte("imgJugadoresGrupoEdad", "estadisticasJugadores", "jugadoresGrupoEdad"));

document.getElementById('dropdown-toggle-pais').addEventListener('click', function() {
    document.getElementById('dropdown-menu-pais').classList.toggle('hidden');
});

document.querySelectorAll('#dropdown-menu-pais li').forEach(function(item) {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        const filter = event.target.dataset.filter;

        const img = document.getElementById("imgJugadoresPais");
        img.src = "estadisticasJugadores/mostrarJugadoresPorPais&option=" + filter;
    });
});

document.getElementById('dropdown-toggle-genero').addEventListener('click', function() {
    document.getElementById('dropdown-menu-genero').classList.toggle('hidden');
});

document.querySelectorAll('#dropdown-menu-genero li').forEach(function(item) {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        const filter = event.target.dataset.filter;

        const img = document.getElementById("imgJugadoresGenero");
        img.src = "estadisticasJugadores/mostrarCantidadJugadoresPorGenero&option=" + filter;
    });
});