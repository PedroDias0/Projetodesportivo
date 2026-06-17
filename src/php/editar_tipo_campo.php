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
$nome = $_POST["nome"];
$modalidade = $_POST["modalidade"];
$piso = $_POST["piso"];
$cobertura = $_POST["cobertura"];
$preco_base = str_replace(",", ".", $_POST["preco_base"]);
$preco_luz = str_replace(",", ".", $_POST["preco_luz"]);
$preco_material = str_replace(",", ".", $_POST["preco_material"]);

$sql = "
UPDATE tipos_campo
SET 
    nome = '$nome',
    modalidade = '$modalidade',
    piso = '$piso',
    cobertura = '$cobertura',
    preco_base = $preco_base,
    preco_luz = $preco_luz,
    preco_material = $preco_material
WHERE id = $id
";

if (mysqli_query($conn, $sql)) {
    header("Location: ../gestao_campos.html?sucesso=campo");
    exit();
} else {
    echo "Erro ao atualizar tipo de campo: " . mysqli_error($conn);
}

mysqli_close($conn);
?>