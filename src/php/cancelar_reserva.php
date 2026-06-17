<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    header("Location: ../login.html");
    exit();
}

$utilizador_id = $_SESSION["utilizador_id"];
$reserva_id = $_POST["reserva_id"];

$sql = "
SELECT * FROM reservas 
WHERE id = $reserva_id 
AND utilizador_id = $utilizador_id
";

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 0) {
    echo "Reserva não encontrada.";
    exit();
}

$reserva = mysqli_fetch_assoc($resultado);

$data_hora_reserva = $reserva["data_jogo"] . " " . $reserva["hora_inicio"];
$limite_cancelamento = date("Y-m-d H:i:s", strtotime("+24 hours"));

if ($data_hora_reserva <= $limite_cancelamento) {
    echo "Não é possível cancelar reservas com menos de 24 horas de antecedência.";
    echo "<br><a href='../consultar_reservas.html'>Voltar</a>";
    exit();
}

$sql_update = "
UPDATE reservas
SET estado = 'cancelada'
WHERE id = $reserva_id
AND utilizador_id = $utilizador_id
";

if (mysqli_query($conn, $sql_update)) {
    header("Location: ../consultar_reservas.html");
    exit();
} else {
    echo "Erro ao cancelar reserva: " . mysqli_error($conn);
}

mysqli_close($conn);
?>