<?php
$servidor = "localhost";
$utilizador = "root";
$password = "";
$base_dados = "clube_reservas";

$conn = mysqli_connect($servidor, $utilizador, $password, $base_dados);

if (!$conn) {
    die("Erro na ligação à base de dados: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>