<?php
session_start();
$conn = include('../../includes/conexao.php');
require_once __DIR__ . '../../vendor/autoload.php';

$mpdf =  new \Mpdf\Mpdf();
([

    'mode' => 'utf-8',
    'format' => 'A4',
    'orientation' => 'L'
]);


// Display result


$dayInicial =  $_SESSION['dayFechamentoinicio'];
$dayfim =  $_SESSION['dayFechamentofim'];


$dayIniFormated = date_create($dayInicial);
$dayFimFormated = date_create($dayfim);
$room =  $_GET['params'] == '1' ? '123' : '127';
$mpdf->WriteHTML(
    '<html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Fechamento</title>
      <style>
          table,
          th,
          td {
              border: 1px solid black;
              border-collapse: collapse;
              align: center;
          }
          table {
            margin-top:20px;
            width: 100%;
          }
          tr{
            width : 100%
          }
          * {
              box-sizing: border-box;
              margin: 0;
              padding: 0;
          }
  
          .row {
              margin-bottom: 20px
          }
  
          /* Create two unequal columns that floats next to each other */
          .column {
              float: left;
              padding: 10px;
  
          }
  
          .left {
              width: 23%;
              padding-top: 40px;
              justify-content: center;
          }
  
          .right {
              width: 70%;
              text-align: center
          }
  
          /* Clear floats after the columns */
          .row:after {
              content: "";
              display: table;
              clear: both;
          }
  
          h1 {
              color: #05336e;
          }
  
          h1 span {
              font-weight: bold;
              font-size: 40px
          }
  
          .right p {
              font-weight: bold;
              margin: initial;
          }
  
          p {
  
              margin: initial;
          }
          .tdCol1{
           
            font-weight: bold;
          }
          .tdCol2{
           
            font-weight: bold;
          }
          .total{
              margin-top:30px;
          }

          .footer{
            position:absolute;
            bottom:0; 
            width:80%;
            text-align:center;
            margin-bottom: 10px;
          }
          td{
          padding: 5px
          }
      </style>
  </head>
  
  <body>
      <div class="row">
          <div class="column left">
  
              <img src="../../imagens/Logo.png" alt="">
          </div>
          <div class="column right">
              <h1><span>ABC </span> oftalmo</h1>
              <p>Oftalmologia Geral - Lente de Contato - Cirurgia de Catarata</p>
              <p>Cirurgia Refrativa - Plástica Ocular - Glaucoma - Exames</p>
              <p>Tel: (11) 23812473 / (11) 96338-8538</p>
              <p>Email: abc.oftalmo@bol.com.br</p>
          </div>
      </div>
  
          <h1 align="center">Fechamento Sala ' . $room . '</h1>
          <h4 >Do dia ' . date_format($dayIniFormated, "d/m/Y ") . ' ao dia ' . date_format($dayFimFormated, "d/m/Y ")  . '</h4>
      <table>
          <tr>
              <td colspan="1" class="tdCol1">Número</td>
              <td colspan="4" class="tdCol1">Data</td>
              <td colspan="4" class="tdCol1">Cliente</td>
              <td colspan="4" class="tdCol1">Pagamento</td>
              <td colspan="4" class="tdCol1">Tipo</td>
              <td colspan="4" class="tdCol1">Total Recebido em Dinheiro</td>
              <td colspan="4" class="tdCol1">Total Recebido em Cartao</td>
              <td colspan="4" class="tdCol1">Tipo de pagamento em cartao</td>
  
          </tr>'
);

$selectobs = "SELECT rcb.id as idRcb, rcb.dtInclude as dtAtual, pac.namePac as nome,rcb.fmPagamento as formaPag,rcb.tipo as typeRcb,
rcb.totalRecebido as totalRcb,rcb.typeCard as typeCard, rcb.totalRecbCard as totalCard
 FROM recebimentos as rcb, pacientescli as pac where  pac.id = rcb.idPaciente
 and   rcb.RommRcb = '" . $_GET['params'] . "'
 and  dtInclude BETWEEN '$dayInicial' and '$dayfim'";
$resultObs = mysqli_query($conn, $selectobs);
while ($linha_result = mysqli_fetch_assoc($resultObs)) {
    $jsonTypePayment = json_decode($linha_result['typeRcb'], true);

    $sumMoney = $jsonTypePayment[0] == "DINHEIRO" ? $sumMoney + $linha_result['totalRcb'] : $sumMoney + 0;
    $sumCard = in_array("CARTAO", $jsonTypePayment)    ? $sumCard + $linha_result['totalCard'] : $sumCard + 0;
    $sumCheque = $jsonTypePayment[2] == "CHEQUE" ? $sumCheque + $linha_result['totalRcb'] : $sumCheque + 0;
    $mpdf->WriteHTML(
        '<tr>
                            <td colspan="1" >' . $linha_result['idRcb'] . '</td>
                            <td colspan="4" >' . date('d/m/Y', strtotime($linha_result['dtAtual'])) . '</td>
                            <td colspan="4" >' . $linha_result['nome'] . '</td>
                            <td colspan="4" >' . $linha_result['formaPag'] . '</td>
                            <td colspan="4" >' . str_replace(array('[', ']', '"',), '', $linha_result['typeRcb'])  . '</td>
                            <td colspan="4" >R$ ' . number_format($linha_result['totalRcb'], 2)  . '</td>
                            <td colspan="4" >R$ ' . number_format($linha_result['totalCard'], 2)  . '</td>
                            <td colspan="4" > ' . str_replace(array('[', ']', '"',), '', $linha_result['typeCard'])  . '</td>
                          
                           
                         </tr>'
    );
}

$mpdf->WriteHTML(
    '
      </table>
      <p class ="total">Total recebido em Dinheiro: R$ ' . number_format($sumMoney, 2) . '</p>
      <p style =" margin-top: 5px;">Total recebido em Cartão: R$ ' . number_format($sumCard, 2) . '</p>
      <p style =" margin-top: 5px;">Total recebido em Cheque: R$ ' . number_format($sumCheque, 2) . '</p>
      <p class ="footer">ABC OFTALMOLOGIA | Tel: (11) 96338-8538 - Avenida Antártico, 381 - Sala 123,127 ,
      Jardim do Mar, São Bernardo do Campo - SP</p>
  </body>
  
  </html>
                '
);


$arquivo = "Fechamento-" . date_format($dayIniFormated, "d-m-Y ") . "-" . date_format($dayFimFormated, "d-m-Y ") . ".pdf";

$mpdf->Output($arquivo, 'I');

// I - Abre no navegador
// F - Salva o arquivo no servidor
// D - Salva o arquivo no computador do usuário
