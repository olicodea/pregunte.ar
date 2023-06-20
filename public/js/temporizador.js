function getTiempoRestante() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/partida/tiempoRestante',
            method: 'GET',
            success: function (response) {
                resolve(Math.floor(response.tiempoRestante));
            },
            error: function (xhr, status, error) {
                console.log(error)
                console.log('Error al enviar los datos al servidor');
                reject(error);
            }
        });
    });
}

function iniciaTemporizador() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/partida/iniciaTemporizadorEnSesion',
            method: 'GET',
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                console.log('Error al enviar los datos al servidor');
                reject(error);
            }
        });
    });
}

function borrarTemporizador() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/partida/borrarTemporizador',
            method: 'GET',
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                console.log('Error al enviar los datos al servidor');
                reject(error);
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", async function() {
    var tiempoRestante = await getTiempoRestante()
    var contadorElemento = document.getElementById("temporizador");
    var tiempoRespuesta = document.getElementById("tiempoRespuesta");
    var contador = 0;

    if(contadorElemento) {
        function actualizarContador() {
            contador+= 1000;
            let tiempoRestanteSegundos = Math.max(0, Math.floor((tiempoRestante - contador) / 1000));
            contadorElemento.innerHTML = tiempoRestanteSegundos;
            tiempoRespuesta.value = 10000 - Math.max(0, Math.floor((tiempoRestante - contador)));
            if(tiempoRestanteSegundos === 9) {
                iniciaTemporizador();
            }
        }

        function timeout() {
            borrarTemporizador();
            window.location.href = '/partida/responder';
        }

        setInterval(actualizarContador, 1000);
        setTimeout(timeout, tiempoRestante);
    }
});