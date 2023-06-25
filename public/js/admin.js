async function imprimirReporte(idImg, modulo, reporte, nombreUsuario = null) {
    const imgGrafico = document.getElementById(idImg);
    const canvas = document.createElement("canvas");
    const context = canvas.getContext("2d");

    canvas.width = imgGrafico.width;
    canvas.height = imgGrafico.height;

    context.drawImage(imgGrafico, 0, 0);

    const base64 = canvas.toDataURL("image/jpg");

    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/${modulo}/imprimirReporte&reporte=${reporte}&nombreUsuario=${nombreUsuario}`, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.responseType = 'blob';

    xhr.onload = function () {
        if (xhr.status === 200) {
            const blobUrl = URL.createObjectURL(xhr.response);

            window.open(blobUrl);
        }
    };

    const encodedData = encodeURIComponent(base64);
    const requestData = `imagen=${encodedData}`;

    xhr.send(requestData);
}