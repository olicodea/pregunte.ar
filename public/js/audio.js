window.addEventListener("DOMContentLoaded", function() {
    var correcto = document.getElementById("respuestaOk");
    var incorrecto = document.getElementById("respuestaMal");
    var audio = document.getElementById("audio");

    if(correcto){
        var url = "audio/correcta";
        ajax(url);
    }else if (incorrecto){
        var url = "audio/incorrecta";
        ajax(url);

    }
    function ajax(url){
        var xhr = new XMLHttpRequest();

        xhr.open("GET", url, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var respuesta = xhr.responseText;
                console.log(respuesta);
                audio.src = respuesta;
                audio.play();
            }
        };

        xhr.send();
           }
});