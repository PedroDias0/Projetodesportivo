<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    echo "Tem de iniciar sessão para consultar as reservas.";
    exit();
}

$utilizador_id = $_SESSION["utilizador_id"];

$sql = "
SELECT 
    r.id,
    r.data_jogo,
    r.hora_inicio,
    r.hora_fim,
    r.luz,
    r.material_qtd,
    r.valor_total,
    r.estado,
    r.checkin,
    c.numero AS campo,
    t.nome AS tipo_campo
FROM reservas r
INNER JOIN campos c ON r.campo_id = c.id
INNER JOIN tipos_campo t ON c.tipo_campo_id = t.id
WHERE r.utilizador_id = $utilizador_id
ORDER BY r.data_jogo DESC, r.hora_inicio DESC
";

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 0) {
    echo "<p>Não existem reservas registadas.</p>";
    exit();
}

echo "<table border='1' cellpadding='8'>";
echo "<tr>
        <th>Tipo de Campo</th>
        <th>Campo</th>
        <th>Data</th>
        <th>Hora Início</th>
        <th>Hora Fim</th>
        <th>Luz</th>
        <th>Material</th>
        <th>Valor</th>
        <th>Estado</th>
        <th>Check-in</th>
        <th>Ação</th>
      </tr>";

while ($reserva = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $reserva["tipo_campo"] . "</td>";
    echo "<td>" . $reserva["campo"] . "</td>";
    echo "<td>" . $reserva["data_jogo"] . "</td>";
    echo "<td>" . $reserva["hora_inicio"] . "</td>";
    echo "<td>" . $reserva["hora_fim"] . "</td>";
    echo "<td>" . ($reserva["luz"] ? "Sim" : "Não") . "</td>";
    echo "<td>" . $reserva["material_qtd"] . "</td>";
    echo "<td>" . $reserva["valor_total"] . "€</td>";
    echo "<td>" . $reserva["estado"] . "</td>";
    echo "<td>" . ($reserva["checkin"] ? "Sim" : "Não") . "</td>";

    if ($reserva["estado"] == "ativa") {
        echo "<td>
                <form action='php/cancelar_reserva.php' method='POST'>
                    <input type='hidden' name='reserva_id' value='" . $reserva["id"] . "'>
                    <button type='submit'>Cancelar</button>
                </form>
              </td>";
    } else {
        echo "<td><span class='badge-cancelada'>Cancelada</span></td>";
    }

    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);
?>