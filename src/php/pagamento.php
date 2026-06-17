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
$montante = $_POST["montante"];
$tipo = $_POST["tipo"];
$operador_id = $_SESSION["utilizador_id"];

$sql = "
INSERT INTO pagamentos
(reserva_id, operador_id, montante, tipo, observacao)
VALUES
($reserva_id, $operador_id, $montante, '$tipo', 'Pagamento registado no backoffice')
";

if (mysqli_query($conn, $sql)) {
    $log = "INSERT INTO logs (utilizador_id, acao) VALUES ($operador_id, 'Registou pagamento da reserva $reserva_id')";
    mysqli_query($conn, $log);

    header("Location: ../administrador.html?sucesso=pagamento");
    exit();
}

mysqli_close($conn);
?>