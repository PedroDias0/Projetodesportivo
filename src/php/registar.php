<?php
include "ligacao.php";

$nome = $_POST["nome"];
$email = $_POST["email"];
$password = $_POST["password"];
$documento_tipo = $_POST["documento_tipo"];
$documento_numero = $_POST["documento_numero"];
$nif = $_POST["nif"];

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO utilizadores 
(nome, email, password, documento_tipo, documento_numero, nif, perfil, estado)
VALUES 
('$nome', '$email', '$password_hash', '$documento_tipo', '$documento_numero', '$nif', 'atleta', 'ativo')";

if (mysqli_query($conn, $sql)) {
    header("Location: ../login.html?registo=sucesso");
    exit();
} else {
    echo "Erro ao registar: " . mysqli_error($conn);
}

mysqli_close($conn);
?>