const Btn_ImprimirCantidadPartidas = document.getElementById("ImprimirCantidadPartidas");
const Btn_ImprimirCantidadJugadores = document.getElementById("ImprimirCantidadJugadores");
const Btn_ImprimirCantidadPreguntas = document.getElementById("ImprimirCantidadPreguntas");

Btn_ImprimirCantidadPartidas.addEventListener("click", () => imprimirReporte("imgCantidadPartidas", "estadisticasGenerales", "cantidadPartidas"));

Btn_ImprimirCantidadJugadores.addEventListener("click", () => imprimirReporte("imgCantidadJugadores", "estadisticasGenerales", "cantidadJugadores"));

Btn_ImprimirCantidadPreguntas.addEventListener("click", () => imprimirReporte("imgCantidadPreguntas", "estadisticasGenerales", "cantidadPreguntas"));