window.addEventListener("resize", listarPreguntas);

function mostrarPregunta(pregunta) {
    if(pregunta.length > 50) {
        return pregunta.slice(0, 50) + "...";
    } else {
        return pregunta;
    }
}

let contenedorPreguntas = document.querySelector("#contenedor-preguntas");
const contenedorPreguntasGuardado = contenedorPreguntas.innerHTML;

window.addEventListener("load", () => {
    listarPreguntas()
})

function listarPreguntas() {
    if( window.innerWidth <= 480 ) {
        Array.from(contenedorPreguntas.children).forEach(contenedorPregunta => {
            let pregunta = contenedorPregunta.children[0];
            contenedorPregunta.children[0].textContent = mostrarPregunta(pregunta.textContent);
        })
    } else {
        contenedorPreguntas.innerHTML = contenedorPreguntasGuardado;
    }
}

function abrirModalEliminarPregunta(idPregunta, pregunta) {
    const modal = document.getElementById('modal-eliminar');
    modal.classList.remove('hidden');

    const modalQuestion = document.getElementById('modal-eliminar-question');
    modalQuestion.textContent = pregunta;

    const inputIdPreguntaHidden = document.createElement("input");
    inputIdPreguntaHidden.type = "hidden";
    inputIdPreguntaHidden.id = "inputIdPreguntaHidden";
    inputIdPreguntaHidden.value = idPregunta;
    modalQuestion.append(inputIdPreguntaHidden);

    modal.addEventListener('click', function(event) {
        if (event.target === document.querySelector('.modal-overlay')) {
            cancelarModal("eliminar");
        }
    });
}

async function visualizarPregunta(idPregunta, pregunta, usuario, idRespuesta) {
    const modal = document.getElementById('modal-visualizar');
    modal.classList.remove('hidden');

    const modalTitle = document.getElementById('modal-visualizar-title');
    modalTitle.textContent = `Pregunta creada por ${usuario}`;

    const modalQuestion = document.getElementById('modal-visualizar-question');
    modalQuestion.textContent = pregunta;

    const modalAnswers = document.getElementById('modal-visualizar-answers');
    modalAnswers.textContent = "";

    let respuestas = await findRespuestas(idRespuesta);
    insertarRespuestas(modalAnswers, respuestas);

    modal.addEventListener('click', function(event) {
        if (event.target === document.querySelector('.modal-overlay')) {
            cancelarModal("visualizar");
        }
    });
}

function eliminarPregunta() {
    const inputIdHidden = document.getElementById('inputIdPreguntaHidden');
    const idPregunta = inputIdHidden.value;
    const contenedorPregunta = document.getElementById(`contenedor-${idPregunta}`);

    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/preguntasActivas/eliminarPregunta',
            method: 'POST',
            data: {
                idPregunta: idPregunta
            },
            success: function (response) {
                if(response) {
                    contenedorPregunta.remove();
                    mostrarNotificacion('La pregunta se ha eliminado correctamente', '/preguntasActivas');
                }
            },
            error: function (xhr, status, error) {
                console.log('Error al eliminar pregunta');
                reject(error);
            }
        });
        cancelarModal("eliminar");
    });
}

contenedorPreguntas.addEventListener("click", function(event) {
    const target = event.target;
    if (target.classList.contains("modal-button") || target.classList.contains("icon")) {
        event.stopPropagation();

        if (target.dataset.action === "eliminar") {
            abrirModalEliminarPregunta(target.dataset.idPregunta, target.dataset.pregunta);

        }

        if(target.parentElement.dataset.action === "eliminar") {
            abrirModalEliminarPregunta(target.parentElement.dataset.idPregunta, target.parentElement.dataset.pregunta);
        }

        if(target.dataset.action === "editar" || target.parentElement.dataset.action === "editar") {
            const idPregunta = target.dataset.idPregunta ?? target.parentElement.dataset.idPregunta;
            window.location.href = "/crearPregunta/comenzarEdicion&idPregunta=" + idPregunta;
        }

    } else {
        const contenedorPregunta = target.closest(".preguntas");
        if (contenedorPregunta) {
            visualizarPregunta(
                contenedorPregunta.dataset.idPregunta,
                contenedorPregunta.dataset.pregunta,
                contenedorPregunta.dataset.usuario,
                contenedorPregunta.dataset.idRespuesta
            );
        }
    }
});