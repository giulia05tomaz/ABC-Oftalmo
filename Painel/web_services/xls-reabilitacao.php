<?php
session_start();
include_once("../includes/conexao.php");

$query = $_SESSION['queryReabilitacao'];
$result = mysqli_query($conn, $query);
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Relatório de Reabilitação</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    $html = ' 
        <h1 align="center">Relatório de Reabilitação</h1>
        <table align="center">
            <tr>
                <td class="text-center"><b>Empresa</b></td>
                <td class="text-center"><b>Unidade</b></td>
                <td class="text-center"><b>Cargo</b></td>
                <td class="text-center"><b>Nome</b></td>
                <td class="text-center"><b>CPF</b></td>
                <td class="text-center"><b>Matrícula</b></td>
                <td class="text-center"><b>Nº Benefício</b></td>
                <td class="text-center"><b>CID</b></td>
                <td class="text-center"><b>Espécie</b></td>
                <td class="text-center"><b>Data do Início</b></td>
                <td class="text-center"><b>Data de Cessação</b></td>
                <td class="text-center"><b>Situação</b></td>
                <td class="text-center"><b>Contato com</b></td>
                <td class="text-center"><b>Forma de Contato</b></td>
                <td class="text-center"><b>Data do Contato</b></td>
                <td class="text-center"><b>Observação</b></td>
                <td class="text-center"><b>Contato com</b></td>
                <td class="text-center"><b>Forma de Contato</b></td>
                <td class="text-center"><b>Data do Contato</b></td>
                <td class="text-center"><b>Observação</b></td>
                <td class="text-center"><b>Contato com</b></td>
                <td class="text-center"><b>Forma de Contato</b></td>
                <td class="text-center"><b>Data do Contato</b></td>
                <td class="text-center"><b>Observação</b></td>
            </tr>';


    while ($lr = mysqli_fetch_assoc($result)) {
        // $id = $lr['idtrabalhador'];
        $html =  $html .
            '<tr>
            <td class="text-center">' . $lr['empresa'] . '</td>
            <td class="text-center">' . $lr['unidade'] . '</td>
            <td class="text-center">' . $lr['cargo'] . '</td>
            <td class="text-center">' . $lr['nome'] . '</td>
            <td class="text-center">' . $lr['cpf'] . '</td>
            <td class="text-center">' . $lr['matricula'] . '</td>
            <td class="text-center">' . $lr['numerobeneficio'] . '</td>
            <td class="text-center">' . $lr['cid'] . '</td>
            <td class="text-center">' . $lr['especie'] . '</td>
            <td class="text-center">' . $lr['datainicio'] . '</td>
            <td class="text-center">' . $lr['datacessacao'] . '</td>
            <td class="text-center">' . $lr['situacao'] . '</td>';

        $query_contato = "SELECT AES_DECRYPT(AES_DECRYPT(c.contatocom, 'odiaquevem'), SHA2(c.id2, 512)) AS contatocom,
        AES_DECRYPT(AES_DECRYPT(c.formacontato, 'odiaquevem'), SHA2(c.id2, 512)) AS formacontato,
        AES_DECRYPT(AES_DECRYPT(c.datacontato, 'odiaquevem'), SHA2(c.id2, 512)) AS datacontato,
        AES_DECRYPT(AES_DECRYPT(c.observacao, 'odiaquevem'), SHA2(c.id2, 512)) AS observacao
        from contato c
        where AES_DECRYPT(AES_DECRYPT(c.idtrabalhador, 'odiaquevem'), SHA2(c.id2, 512)) = " . $lr['idtrabalhador'] . "
        order by AES_DECRYPT(AES_DECRYPT(c.datacontato, 'odiaquevem'), SHA2(c.id2, 512)) desc
        limit 3";
        $result_contato = mysqli_query($conn, $query_contato);

        $arr = '';
        while ($lr_contato = mysqli_fetch_assoc($result_contato)) {
            // $arr = json_decode($lr_contato['observacao']);
            // echo "obs: $arr->observacao <br>";
            $html = $html .
                '<td class="text-center">' . $lr_contato['contatocom'] . '</td>
            <td class="text-center">' . $lr_contato['formacontato'] . '</td>
            <td class="text-center">' . $lr_contato['datacontato'] . '</td>
            <td class="text-center">' . $lr_contato['observacao'] . '</td>';
            // break;
        }
        $html = $html . '</tr>';
        // var_dump($arr);
    }

    $html = $html . ' </table> ';
    $arquivo = "relatorio_reabilitacao.xls";
    header("Expires: 0");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
    header("Content-Description: PHP Generated Data");

    echo $html;
    exit; ?>
</body>

</html>