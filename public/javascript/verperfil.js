
    $.ajax({
    type: "GET",
    url: "../../controllers/php/verifi.php",
    success: function(data) {
    // Parsea el objeto JSON
    var mensajes = JSON.parse(data);

    // Muestra los mensajes en los inputs correspondientes
    $("#nombre_completo").val(mensajes.nombre_completo);
    $("#correo").val(mensajes.correo);
    $("#usuario").val(mensajes.usuario);
    $("#rol").val(mensajes.rol);
}
});

$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "../../controllers/php/verifi.php",
        success: function(data) {
            var mensajes = JSON.parse(data);
            $("#nombre_completo").val(mensajes.nombre_completo);
            $("#correo").val(mensajes.correo);
            $("#usuario").val(mensajes.usuario);
            $("#rol").val(mensajes.rol);
        }
    });

    document.getElementById("editar-datos").addEventListener("click", function() {
        var inputs = document.querySelectorAll("input[type='text']");
        inputs.forEach(function(input) {
            input.disabled = !input.disabled;
        });
    });

    document.getElementById("guardar-datos").addEventListener("click", function() {
        var inputs = document.querySelectorAll("input[type='text']");
        inputs.forEach(function(input) {
            input.disabled = true;
        });

        var nombre_completo = document.getElementById("nombre_completo").value;
        var correo = document.getElementById("correo").value;
        var usuario = document.getElementById("usuario").value;
        

        var datos = {
            nombre_completo: nombre_completo,
            correo: correo,
            usuario: usuario
        };

        fetch("../../controllers/php/actualizar.php", {
            method: "POST",
            body: JSON.stringify(datos),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                alert("Datos actualizados con éxito");
            } else {
                alert("Error al actualizar datos");
            }
        })
        .catch(error => console.error("Error:", error));
    });
});
