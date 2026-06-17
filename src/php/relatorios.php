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

$total_reservas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservas"))["total"];
$reservas_ativas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservas WHERE estado='ativa'"))["total"];
$reservas_canceladas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservas WHERE estado='cancelada'"))["total"];
$total_utilizadores = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM utilizadores"))["total"];
$total_faturado = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(montante),0) AS total FROM pagamentos"))["total"];
$total_checkins = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservas WHERE checkin=1"))["total"];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatórios</title>
    <link rel="stylesheet" href="../css/relatorios.css">
</head>
<body>

<header>
    <h1>ProjetoDesportivo</h1>
    <nav>
        <a href="../administrador.html">Backoffice</a>
        <a href="../index.html">Início</a>
        <a href="logout.php">Sair</a>
    </nav>
</header>

<div class="container">
    <h2>Relatórios Gerenciais</h2>

    <div class="cards">
        <div class="card">
            <span>Total de reservas</span>
            <strong><?php echo $total_reservas; ?></strong>
        </div>

        <div class="card">
            <span>Reservas ativas</span>
            <strong><?php echo $reservas_ativas; ?></strong>
        </div>

        <div class="card">
            <span>Reservas canceladas</span>
            <strong><?php echo $reservas_canceladas; ?></strong>
        </div>

        <div class="card">
            <span>Total de utilizadores</span>
            <strong><?php echo $total_utilizadores; ?></strong>
        </div>

        <div class="card">
            <span>Total faturado</span>
            <strong><?php echo $total_faturado; ?>€</strong>
        </div>

        <div class="card">
            <span>Total de check-ins</span>
            <strong><?php echo $total_checkins; ?></strong>
        </div>
    </div>

    <h3>Receita por tipo de campo</h3>

    <table>
        <tr>
            <th>Tipo de Campo</th>
            <th>Total Faturado</th>
        </tr>

        <?php
        $sql_receita = "
        SELECT t.nome, IFNULL(SUM(p.montante),0) AS total
        FROM tipos_campo t
        LEFT JOIN campos c ON c.tipo_campo_id = t.id
        LEFT JOIN reservas r ON r.campo_id = c.id
        LEFT JOIN pagamentos p ON p.reserva_id = r.id
        GROUP BY t.id, t.nome
        ";

        $resultado_receita = mysqli_query($conn, $sql_receita);

        while ($linha = mysqli_fetch_assoc($resultado_receita)) {
            echo "<tr>";
            echo "<td>" . $linha["nome"] . "</td>";
            echo "<td>" . $linha["total"] . "€</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h3>Histórico de ações</h3>

    <table>
        <tr>
            <th>Data</th>
            <th>Utilizador</th>
            <th>Ação</th>
        </tr>

        <?php
        $sql_logs = "
        SELECT l.data_acao, u.nome, l.acao
        FROM logs l
        LEFT JOIN utilizadores u ON l.utilizador_id = u.id
        ORDER BY l.data_acao DESC
        ";

        $resultado_logs = mysqli_query($conn, $sql_logs);

        while ($log = mysqli_fetch_assoc($resultado_logs)) {
            echo "<tr>";
            echo "<td>" . $log["data_acao"] . "</td>";
            echo "<td>" . $log["nome"] . "</td>";
            echo "<td>" . $log["acao"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a class="voltar" href="../administrador.html">Voltar ao backoffice</a>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>