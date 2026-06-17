<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    echo "Tem de iniciar sessão.";
    exit();
}

if ($_SESSION["perfil"] != "gestor") {
    echo "Acesso negado. Apenas o gestor pode gerir atletas.";
    exit();
}

$sql = "
SELECT id, nome, email, perfil, estado
FROM utilizadores
ORDER BY id ASC
";

$resultado = mysqli_query($conn, $sql);

echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Perfil</th>
        <th>Estado</th>
        <th>Ação</th>
      </tr>";

while ($user = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $user["id"] . "</td>";
    echo "<td>" . $user["nome"] . "</td>";
    echo "<td>" . $user["email"] . "</td>";
    echo "<td>" . ucfirst($user["perfil"]) . "</td>";
    echo "<td>" . ucfirst($user["estado"]) . "</td>";

    echo "<td>";

    if ($user["estado"] == "ativo" && $user["perfil"] == "atleta") {
        echo "
        <form action='php/inativar_atleta.php' method='POST'>
            <input type='hidden' name='id' value='" . $user["id"] . "'>
            <button type='submit' class='danger'>Inativar</button>
        </form>";
    } else {
        echo "<span class='badge'>Sem ação</span>";
    }

    echo "</td>";
    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);
?>