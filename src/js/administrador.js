const params = new URLSearchParams(window.location.search);
const mensagem = document.getElementById("mensagem");

if (params.get("sucesso") === "pagamento") {
    mensagem.innerHTML = "✅ Pagamento registado com sucesso.";
    mensagem.style.display = "block";

    setTimeout(() => {
        mensagem.style.display = "none";
    }, 5000);
}

if (params.get("sucesso") === "checkin") {
    mensagem.innerHTML = "✅ Check-in confirmado com sucesso.";
    mensagem.style.display = "block";

    setTimeout(() => {
        mensagem.style.display = "none";
    }, 5000);
}

fetch("php/admin_reservas.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("lista-admin-reservas").innerHTML = data;
    });