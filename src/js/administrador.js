fetch("php/admin_reservas.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("lista-admin-reservas").innerHTML = data;
    });