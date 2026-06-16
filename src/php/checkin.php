<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    header("Location: ../login.html");
    exit();
}

if ($_SESSION["perfil"] != "gestor" && $_SESSION["perfil"] != "rececionista") {
    echo "Acesso negado.";
    exit();
}

$reserva_id = $_POST["reserva_id"];
$operador_id = $_SESSION["utilizador_id"];

$sql = "UPDATE reservas SET checkin = 1 WHERE id = $reserva_id";

if (mysqli_query($conn, $sql)) {
    $log = "INSERT INTO logs (utilizador_id, acao) VALUES ($operador_id, 'Confirmou check-in da reserva $reserva_id')";
    mysqli_query($conn, $log);

    echo "Check-in confirmado com sucesso.";
    echo "<br><a href='../administrador.html'>Voltar ao backoffice</a>";
} else {
    echo "Erro ao confirmar check-in: " . mysqli_error($conn);
}

mysqli_close($conn);
?>