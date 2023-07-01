let contenedorCategorias = document.querySelector("#contenedor-categorias");
contenedorCategorias.addEventListener("click", function(event) {
    const target = event.target;
    if (target.classList.contains("modal-button") || target.classList.contains("icon")) {
        event.stopPropagation();

        if (target.dataset.action === "eliminar") {
            abrirModalEliminarCategoria(target.dataset.idCategoria, target.dataset.descripcion);
        }

        if(target.parentElement.dataset.action === "eliminar") {
            abrirModalEliminarCategoria(target.parentElement.dataset.idCategoria, target.parentElement.dataset.descripcion);
        }

        if(target.dataset.action === "editar" || target.parentElement.dataset.action === "editar") {
            const idCategoria = target.dataset.idCategoria ?? target.parentElement.dataset.idCategoria;
            window.location.href = "/categoria/comenzarEdicionCategoria&idCategoria=" + idCategoria;
        }

    }
});

function abrirModalEliminarCategoria(idCategoria, descripcion) {
    const modal = document.getElementById('modal-eliminar');
    modal.classList.remove('hidden');

    const modalCategory = document.getElementById('modal-eliminar-category');
    modalCategory.textContent = descripcion;

    const inputIdCategoriaHidden = document.createElement("input");
    inputIdCategoriaHidden.type = "hidden";
    inputIdCategoriaHidden.id = "inputIdCategoriaHidden";
    inputIdCategoriaHidden.value = idCategoria;
    modalCategory.append(inputIdCategoriaHidden);

    modal.addEventListener('click', function(event) {
        if (event.target === document.querySelector('.modal-overlay')) {
            cancelarModal("eliminar");
        }
    });
}


function eliminarCategoria() {
    const inputIdHidden = document.getElementById('inputIdCategoriaHidden');
    const idCategoria = inputIdHidden.value;
    const contenedorCategoria = document.getElementById(`contenedor-${idCategoria}`);

    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/categoriasActivas/eliminarCategoria',
            method: 'POST',
            data: {
                idCategoria: idCategoria
            },
            success: function (response) {
                if(response) {
                    contenedorCategoria.remove();
                    mostrarNotificacion('La categoría se ha eliminado correctamente', '/categoriasActivas');
                }
            },
            error: function (xhr, status, error) {
                console.log('Error al eliminar categoría');
                reject(error);
            }
        });
        cancelarModal("eliminar");
    });
}