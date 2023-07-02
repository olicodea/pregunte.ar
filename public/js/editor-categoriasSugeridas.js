async function mostrarModalCategoriaSugerida(idCategoria, descripcion, usuario, color) {
    const modal = document.getElementById('modal-categorias-sugeridas');
    modal.classList.remove('hidden');

    const modalTitle = document.getElementById('modal-title');
    modalTitle.textContent = `Categoría sugerida`;

    const modalCategory = document.getElementById('modal-category');
    modalCategory.textContent = descripcion;

    const inputIdCategoriaHidden = document.createElement("input");
    inputIdCategoriaHidden.type = "hidden";
    inputIdCategoriaHidden.id = "inputIdCategoriaHidden";
    inputIdCategoriaHidden.value = idCategoria;
    modalCategory.append(inputIdCategoriaHidden);

    modal.addEventListener('click', function(event) {
        if (event.target === document.querySelector('.modal-overlay')) {
            cancelarModal("categorias-sugeridas");
        }
    });
}

function aprobarCategoria() {
    const inputIdHidden = document.getElementById('inputIdCategoriaHidden');
    const idCategoria = Number(inputIdHidden.value);
    const contenedorCategoria = document.getElementById(`contenedor-${idCategoria}`);

    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/categoriasSugeridas/aprobarCategoria',
            method: 'POST',
            data: {
                idCategoria: idCategoria
            },
            success: function (response) {
                if(response) {
                    contenedorCategoria.remove();
                    mostrarNotificacion('La categoría se ha aprobado correctamente', '/categoriasSugeridas');
                    resolve(response);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error al enviar los datos al servidor');
                reject(error);
            }
        });
        cancelarModal("categorias-sugeridas");
    });
}

function rechazarCategoria() {
    const inputIdHidden = document.getElementById('inputIdCategoriaHidden');
    const idCategoria = Number(inputIdHidden.value);
    const contenedorCategoria = document.getElementById(`contenedor-${idCategoria}`);

    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/categoriasSugeridas/rechazarCategoria',
            method: 'POST',
            data: {
                idCategoria: idCategoria
            },
            success: function (response) {
                if(response) {
                    contenedorCategoria.remove();
                    mostrarNotificacion('La categoría se ha rechazado correctamente', '/categoriasSugeridas');
                    resolve(response);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error al enviar los datos al servidor');
                reject(error);
            }
        });
        cancelarModal("categorias-sugeridas");
    });
}