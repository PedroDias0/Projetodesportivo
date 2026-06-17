fetch("php/perfil.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("dados-perfil").innerHTML = data;
    });