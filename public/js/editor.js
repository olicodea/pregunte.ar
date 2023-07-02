async function findRespuestas(idRespuesta) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/preguntasSugeridas/findRespuestas&idRespuesta=' + idRespuesta,
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

function insertarRespuestas(modalAnswers, respuestas) {
    Object.values(respuestas).forEach(respuesta => {
        const li = document.createElement("li");
        li.textContent = respuesta.respuesta;
        if(respuesta.esCorrecta) {
            li.textContent += " - " + "RESPUESTA CORRECTA";
        }
        modalAnswers.append(li);
    })
}

function cancelarModal(tipo) {
    const modal = document.getElementById(`modal-${tipo}`);
    modal.classList.add('hidden');
}

function mostrarNotificacion(mensaje, redirect = null, color = 'bg-blue-500') {
    const notificationElement = document.getElementById('notification');
    notificationElement.classList.remove("hidden");

    const notification = document.createElement('div');
    notification.classList.add('notification', color);
    notification.textContent = mensaje;

    notification.style.opacity = '0';
    notificationElement.append(notification);

    setTimeout(function () {
        notification.style.opacity = '1';
    }, 10);

    setTimeout(function () {
        notification.style.opacity = '0';
        setTimeout(function () {
            notification.remove();
            if(redirect) {
                window.location.href = redirect;
            }
        }, 300)
    }, 3000);
}

function mostrarNotificacionError(mensaje, redirect = null) {
    mostrarNotificacion(mensaje, redirect, "bg-red-500");
}