async function mostrarModal(idPregunta, pregunta, usuario, idRespuesta) {
    const modal = document.getElementById('modal-sugeridas');
    modal.classList.remove('hidden');

    const modalTitle = document.getElementById('modal-title');
    modalTitle.textContent = `Pregunta sugerida por ${usuario}`;

    const modalQuestion = document.getElementById('modal-question');
    modalQuestion.textContent = pregunta;

    const modalAnswers = document.getElementById('modal-answers');
    modalAnswers.textContent = "";

    const inputIdPreguntaHidden = document.createElement("input");
    inputIdPreguntaHidden.type = "hidden";
    inputIdPreguntaHidden.id = "inputIdPreguntaHidden";
    inputIdPreguntaHidden.value = idPregunta;
    modalQuestion.append(inputIdPreguntaHidden);

    let respuestas = await findRespuestas(idRespuesta);
    insertarRespuestas(modalAnswers, respuestas);

    modal.addEventListener('click', function(event) {
        if (event.target === document.querySelector('.modal-overlay')) {
            cancelarModal("sugeridas");
        }
    });
}

function aprobarPregunta() {
    const inputIdHidden = document.getElementById('inputIdPreguntaHidden');
    const idPregunta = inputIdHidden.value;
    const contenedorPregunta = document.getElementById(`contenedor-${idPregunta}`);

    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/preguntasSugeridas/aprobarPregunta',
            method: 'POST',
            data: {
                idPregunta: idPregunta
            },
            success: function (response) {
                if(response) {
                    contenedorPregunta.remove();
                    mostrarNotificacion('La pregunta se ha aprobado correctamente', '/preguntasSugeridas');
                }
            },
            error: function (xhr, status, error) {
                console.log('Error al enviar los datos al servidor');
                reject(error);
            }
        });
        cancelarModal("sugeridas");
    });
}

function rechazarPregunta() {
    const inputIdHidden = document.getElementById('inputIdPreguntaHidden');
    const idPregunta = inputIdHidden.value;
    const contenedorPregunta = document.getElementById(`contenedor-${idPregunta}`);

    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/preguntasSugeridas/rechazarPregunta',
            method: 'POST',
            data: {
                idPregunta: idPregunta
            },
            success: function (response) {
                if(response) {
                    contenedorPregunta.remove();
                    mostrarNotificacion('La pregunta se ha rechazado correctamente', '/preguntasSugeridas');
                }
            },
            error: function (xhr, status, error) {
                console.log('Error al enviar los datos al servidor');
                reject(error);
            }
        });
        cancelarModal("sugeridas");
    });
}