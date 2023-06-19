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


async function getComentariosDeReportes(idPregunta) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/preguntasReportadas/comentariosReportesPorIdPregunta',
            method: 'POST',
            data: {
                idPregunta: idPregunta
            },
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                console.log('Error al listar los comentarios');
                reject(error);
            }
        });
    });
}

async function mostrarModalReportadas(idPregunta, cantidadReportes) {
    const modal = document.getElementById('modal-reportadas');
    modal.classList.remove('hidden');

    const modalTitle = document.getElementById('modal-reportadas-title');
    modalTitle.textContent = `La pregunta tiene ${cantidadReportes} reportes con estos comentarios:`;

    const modalComments = document.getElementById("modal-reportadas-comments");

    const comentarios = await getComentariosDeReportes(idPregunta);
    comentarios.forEach(item => {
        const comment = document.createElement("li");
        comment.innerHTML = `<li>- ${item.comentario}</li>`;
        modalComments.append(comment);
    })

    const inputIdPreguntaHidden = document.createElement("input");
    inputIdPreguntaHidden.type = "hidden";
    inputIdPreguntaHidden.id = "inputIdPreguntaHidden-reportadas";
    inputIdPreguntaHidden.value = idPregunta;
    modal.append(inputIdPreguntaHidden);

    modal.addEventListener('click', function(event) {
        if (event.target === document.querySelector('.modal-overlay')) {
            cancelarModal("reportadas");
        }
    });
}

function rechazarReporte() {
    const inputHidden = document.getElementById("inputIdPreguntaHidden-reportadas");
    const idPregunta = inputHidden.value;
    const contenedorReporte = document.getElementById(`contenedor-${idPregunta}`);

    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/preguntasReportadas/rechazarReporte',
            method: 'POST',
            data: {
                idPregunta: idPregunta
            },
            success: function (response) {
                if(response) {
                    contenedorReporte.remove();
                    mostrarNotificacion('El reporte se ha rechazado con exito', '/preguntasReportadas');
                }
            },
            error: function (xhr, status, error) {
                console.log('Error al rechazar el reporte');
                reject(error);
            }
        });
        cancelarModal("reportadas");
    });
}

function editarPreguntaReportada() {
    const inputHidden = document.getElementById("inputIdPreguntaHidden-reportadas");
    const idPregunta = inputHidden.value;
    window.location.href = "/crearPregunta/comenzarEdicion&idPregunta=" + idPregunta;
}