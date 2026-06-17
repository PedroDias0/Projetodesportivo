<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    header("Location: ../login.html");
    exit();
}

$utilizador_id = $_SESSION["utilizador_id"];
$tipo_campo_id = $_POST["tipo_campo_id"];
$data_jogo = $_POST["data_jogo"];
$hora_inicio = $_POST["hora_inicio"];
$hora_fim = $_POST["hora_fim"];
$luz = isset($_POST["luz"]) ? 1 : 0;
$material_qtd = $_POST["material_qtd"];
$nif_faturacao = $_POST["nif_faturacao"];

$data_hora_inicio = $data_jogo . " " . $hora_inicio;
$agora = date("Y-m-d H:i");

if ($data_hora_inicio < $agora) {
    echo "Não é possível criar reservas para horários passados.";
    echo "<br><a href='../reservar.html'>Voltar</a>";
    exit();
}

if ($hora_inicio >= $hora_fim) {
    echo "A hora de início tem de ser anterior à hora de fim.";
    echo "<br><a href='../reservar.html'>Voltar</a>";
    exit();
}

$sql_tipo = "SELECT * FROM tipos_campo WHERE id = $tipo_campo_id";
$res_tipo = mysqli_query($conn, $sql_tipo);
$tipo = mysqli_fetch_assoc($res_tipo);

$sql_campo = "
SELECT c.id
FROM campos c
WHERE c.tipo_campo_id = $tipo_campo_id
AND c.estado = 'disponivel'
AND c.id NOT IN (
    SELECT r.campo_id
    FROM reservas r
    WHERE r.data_jogo = '$data_jogo'
    AND r.estado = 'ativa'
    AND (
        ('$hora_inicio' < r.hora_fim AND '$hora_fim' > r.hora_inicio)
    )
)
LIMIT 1
";

$res_campo = mysqli_query($conn, $sql_campo);

if (mysqli_num_rows($res_campo) == 0) {
    echo "Não existem campos disponíveis deste tipo para a data e horário escolhidos.";
    echo "<br><a href='../reservar.html'>Voltar</a>";
    exit();
}

$campo = mysqli_fetch_assoc($res_campo);
$campo_id = $campo["id"];

$valor_total = $tipo["preco_base"];

if ($luz == 1) {
    $valor_total += $tipo["preco_luz"];
}

$valor_total += ($material_qtd * $tipo["preco_material"]);

$sql_insert = "
INSERT INTO reservas
(utilizador_id, campo_id, data_jogo, hora_inicio, hora_fim, luz, material_qtd, nif_faturacao, valor_total, estado, checkin)
VALUES
($utilizador_id, $campo_id, '$data_jogo', '$hora_inicio', '$hora_fim', $luz, $material_qtd, '$nif_faturacao', $valor_total, 'ativa', 0)
";

if (mysqli_query($conn, $sql_insert)) {
    header("Location: ../consultar_reservas.html");
    exit();
} else {
    echo "Erro ao criar reserva: " . mysqli_error($conn);
}

mysqli_close($conn);
?>