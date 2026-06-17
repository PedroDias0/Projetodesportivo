fetch("php/listar_reservas.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("lista-reservas").innerHTML = data;
    });