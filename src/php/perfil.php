<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    echo "Sessão não iniciada.";
    exit();
}

$id = $_SESSION["utilizador_id"];

$sql = "
SELECT nome, email, documento_tipo, documento_numero, nif, perfil
FROM utilizadores
WHERE id = $id
";

$resultado = mysqli_query($conn, $sql);

if ($utilizador = mysqli_fetch_assoc($resultado)) {

    echo "<div class='perfil-card'>";

    echo "<p><strong>Nome:</strong> " . $utilizador["nome"] . "</p>";

    echo "<p><strong>Email:</strong> " . $utilizador["email"] . "</p>";

    echo "<p><strong>Documento:</strong> "
         . $utilizador["documento_tipo"]
         . " - "
         . $utilizador["documento_numero"]
         . "</p>";

    echo "<p><strong>NIF:</strong> "
         . ($utilizador["nif"] ?: "Não indicado")
         . "</p>";

    echo "<p><strong>Perfil:</strong> "
         . ucfirst($utilizador["perfil"])
         . "</p>";

    echo "</div>";
}

mysqli_close($conn);
?>