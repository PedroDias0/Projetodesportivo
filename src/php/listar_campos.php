<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    echo "Tem de iniciar sessão.";
    exit();
}

if ($_SESSION["perfil"] != "gestor") {
    echo "Acesso negado. Apenas o gestor pode gerir campos e preços.";
    exit();
}

$sql = "
SELECT id, nome, modalidade, piso, cobertura, preco_base, preco_luz, preco_material
FROM tipos_campo
ORDER BY id ASC
";

$resultado = mysqli_query($conn, $sql);

echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Tipo de Campo</th>
        <th>Preço Base</th>
        <th>Preço Luz</th>
        <th>Preço Material</th>
        <th>Ação</th>
      </tr>";

while ($campo = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";

    echo "<td>" . $campo["id"] . "</td>";

    echo "<td>
        <form action='php/editar_tipo_campo.php' method='POST' id='form" . $campo["id"] . "'>
            <input type='hidden' name='id' value='" . $campo["id"] . "'>
            <input type='hidden' name='modalidade' value='" . $campo["modalidade"] . "'>
            <input type='hidden' name='piso' value='" . $campo["piso"] . "'>
            <input type='hidden' name='cobertura' value='" . $campo["cobertura"] . "'>
            <input type='text' name='nome' value='" . $campo["nome"] . "'>
        </form>
    </td>";

    echo "<td><input form='form" . $campo["id"] . "' type='text' name='preco_base' value='" . $campo["preco_base"] . "'></td>";
    echo "<td><input form='form" . $campo["id"] . "' type='text' name='preco_luz' value='" . $campo["preco_luz"] . "'></td>";
    echo "<td><input form='form" . $campo["id"] . "' type='text' name='preco_material' value='" . $campo["preco_material"] . "'></td>";

    echo "<td><button form='form" . $campo["id"] . "' type='submit'>Guardar</button></td>";

    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);
?>