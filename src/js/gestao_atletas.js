fetch("php/listar_atletas.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("lista-atletas").innerHTML = data;
    });