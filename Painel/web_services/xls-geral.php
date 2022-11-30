<?php
session_start();
// require_once './PHPExcel-1.8/Classes/PHPExcel.php';
include_once("../includes/conexao.php");

$query = $_SESSION['queryGeral1'];
$result = mysqli_query($conn, $query);
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Relatório Geral</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    $html = '<h1 align="center">Relatório Geral - Agenda de Tarefas</h1>
        <table align="center">
            <tr>
                <td class="text-center"><b>Empresa</b></td>
                <td class="text-center"><b>Unidade</b></td>
                <td class="text-center"><b>Nome</b></td>
                <td class="text-center"><b>Último dia trabalhado</b></td>
                <td class="text-center"><b>Executor</b></td>
                <td class="text-center"><b>Tarefa</b></td>
                <td class="text-center"><b>Descrição</b></td>
                <td class="text-center"><b>Data do Lançamento</b></td>
                <td class="text-center"><b>Data da Execução</b></td>
                <td class="text-center"><b>Tipo</b></td>
                <td class="text-center"><b>Severidade</b></td>
                <td class="text-center"><b>Status</b></td>
                <td class="text-center"><b>Observação</b></td>
            </tr>';

    while ($lr = mysqli_fetch_assoc($result)) {
        $html =  $html .'<tr>
            <td class="text-center">' . $lr['empresa'] . '</td>
            <td class="text-center">' . $lr['unidade'] . '</td>
            <td class="text-center">' . $lr['nome'] . '</td>
            <td class="text-center">' . $lr['ultimodiatrabalho'] . '</td>
            <td class="text-center">' . $lr['nomeusuariorealiza'] . '</td>
            <td class="text-center">' . $lr['tarefa'] . '</td>
            <td class="text-center">' . $lr['descricao'] . '</td>
            <td class="text-center">' . $lr['datalancamento'] . '</td>
            <td class="text-center">' . $lr['dataexecucao'] . '</td>
            <td class="text-center">' . $lr['tipo'] . '</td>
            <td class="text-center">' . $lr['severidade'] . '</td>
            <td class="text-center">' . $lr['status'] . '</td>
            <td class="text-center">' . $lr['observacao'] . '</td>
        </tr>';
    }
    
    $html = $html . ' </table> ';
    $arquivo = "relatorio_geral_agenda_tarefas.xls";
    header("Expires: 0");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
    header("Content-Description: PHP Generated Data");

    echo $html;
    exit;
    ?>
</body>

</html>