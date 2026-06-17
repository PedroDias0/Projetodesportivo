<?php
session_start();
include "ligacao.php";

if (!isset($_SESSION["utilizador_id"])) {
    header("Location: ../login.html");
    exit();
}

if ($_SESSION["perfil"] != "gestor") {
    echo "Acesso negado.";
    exit();
}

$id = $_POST["id"];

$sql = "
UPDATE utilizadores
SET estado = 'inativo'
WHERE id = $id
AND perfil = 'atleta'
";

if (mysqli_query($conn, $sql)) {
    header("Location: ../gestao_atletas.html");
    exit();
} else {
    echo "Erro ao inativar atleta: " . mysqli_error($conn);
}

mysqli_close($conn);
?>