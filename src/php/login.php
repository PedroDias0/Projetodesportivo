<?php
session_start();
include "ligacao.php";

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM utilizadores WHERE email = '$email' AND estado = 'ativo'";
$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 1) {
    $utilizador = mysqli_fetch_assoc($resultado);

    if (password_verify($password, $utilizador["password"])) {
        $_SESSION["utilizador_id"] = $utilizador["id"];
        $_SESSION["nome"] = $utilizador["nome"];
        $_SESSION["perfil"] = $utilizador["perfil"];

        if ($utilizador["perfil"] == "gestor" || $utilizador["perfil"] == "rececionista") {
            header("Location: ../administrador.html");
        } else {
            header("Location: ../reservar.html");
        }
        exit();
    }
}

echo "Email ou password inválidos.";
echo "<br><a href='../login.html'>Voltar</a>";

mysqli_close($conn);
?>