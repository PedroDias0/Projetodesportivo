<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    echo "Tem de iniciar sessão.";
    exit();
}

if ($_SESSION["perfil"] != "gestor" && $_SESSION["perfil"] != "rececionista") {
    echo "Acesso negado.";
    exit();
}

$sql = "
SELECT 
    r.id,
    r.data_jogo,
    r.hora_inicio,
    r.hora_fim,
    r.valor_total,
    r.estado,
    r.checkin,
    u.nome AS atleta,
    c.numero AS campo,
    t.nome AS tipo_campo
FROM reservas r
INNER JOIN utilizadores u ON r.utilizador_id = u.id
INNER JOIN campos c ON r.campo_id = c.id
INNER JOIN tipos_campo t ON c.tipo_campo_id = t.id
ORDER BY r.data_jogo DESC, r.hora_inicio DESC
";

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 0) {
    echo "<p>Não existem reservas registadas.</p>";
    exit();
}

echo "<table border='1' cellpadding='8'>";
echo "<tr>
        <th>ID</th>
        <th>Atleta</th>
        <th>Tipo Campo</th>
        <th>Campo</th>
        <th>Data</th>
        <th>Início</th>
        <th>Fim</th>
        <th>Valor</th>
        <th>Estado</th>
        <th>Check-in</th>
        <th>Ações</th>
      </tr>";

while ($reserva = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $reserva["id"] . "</td>";
    echo "<td>" . $reserva["atleta"] . "</td>";
    echo "<td>" . $reserva["tipo_campo"] . "</td>";
    echo "<td>" . $reserva["campo"] . "</td>";
    echo "<td>" . $reserva["data_jogo"] . "</td>";
    echo "<td>" . $reserva["hora_inicio"] . "</td>";
    echo "<td>" . $reserva["hora_fim"] . "</td>";
    echo "<td>" . $reserva["valor_total"] . "€</td>";
    echo "<td>" . $reserva["estado"] . "</td>";
    echo "<td>" . ($reserva["checkin"] ? "Sim" : "Não") . "</td>";

    echo "<td>";

    if ($reserva["estado"] == "ativa" && !$reserva["checkin"]) {
        echo "
        <form action='php/checkin.php' method='POST' style='display:inline;'>
            <input type='hidden' name='reserva_id' value='" . $reserva["id"] . "'>
            <button type='submit'>Confirmar check-in</button>
        </form>
        ";
    }

    echo "
    <form action='php/pagamento.php' method='POST' style='display:inline;'>
        <input type='hidden' name='reserva_id' value='" . $reserva["id"] . "'>
        <input type='number' step='0.01' name='montante' placeholder='Montante' required>
        <select name='tipo'>
            <option value='parcial'>Parcial</option>
            <option value='total'>Total</option>
        </select>
        <button type='submit'>Registar pagamento</button>
    </form>
    ";

    echo "</td>";
    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);
?>