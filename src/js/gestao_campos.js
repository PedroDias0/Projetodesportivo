const params = new URLSearchParams(window.location.search);
const mensagem = document.getElementById("mensagem");

if (params.get("sucesso") === "campo") {
    mensagem.innerHTML = "✅ Preços atualizados com sucesso.";
    mensagem.style.display = "block";

    setTimeout(() => {
        mensagem.style.display = "none";
    }, 5000);
}


fetch("php/listar_campos.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("lista-campos").innerHTML = data;
    });