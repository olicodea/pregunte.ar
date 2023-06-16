document.addEventListener("DOMContentLoaded", function() {
    var contadorElemento = document.getElementById("temporizador");
    var contador = 0;



    if(contadorElemento){
        function actualizarContador() {
            contador++;
            sessionStorage.setItem("segundos", contador);
            contadorElemento.textContent = 10-contador;
        }

        function timeout() {
            window.location.href = "/partida/responder";
        }

        setInterval(actualizarContador, 1000);
        setTimeout(timeout,10000);
    }

});