const Btn_ImprimirJugadoresPais = document.getElementById("ImprimirJugadoresPais");
const Btn_ImprimirJugadoresGenero = document.getElementById("ImprimirJugadoresGenero");
const Btn_ImprimirJugadoresGrupoEdad = document.getElementById("ImprimirJugadoresGrupoEdad");

Btn_ImprimirJugadoresPais.addEventListener("click", () => imprimirReporte("imgJugadoresPais", "estadisticasJugadores", "jugadoresPais"));

Btn_ImprimirJugadoresGenero.addEventListener("click", () => imprimirReporte("imgJugadoresGenero", "estadisticasJugadores", "jugadoresGenero"));

Btn_ImprimirJugadoresGrupoEdad.addEventListener("click", () => imprimirReporte("imgJugadoresGrupoEdad", "estadisticasJugadores", "jugadoresGrupoEdad"));