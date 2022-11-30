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




$dayInicial =  $_SESSION['dayAgendainicio'];
$dayfim =  $_SESSION['dayAgendafim'];
$room =  $_GET['params'] == '1' ? '123' : '127';

$dayIniFormated = date_create($dayInicial);
$dayFimFormated = date_create($dayfim);

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
  
          <h1 align="center">Agendamentos Sala ' . $room . '</h1>
          <h4 >Do dia ' . date_format($dayIniFormated, "d/m/Y ") . ' ao dia ' . date_format($dayFimFormated, "d/m/Y ")  . '</h4>
      <table>
          <tr>
              <td colspan="4" class="tdCol1">Data</td>
              <td colspan="4" class="tdCol1">Horário</td>
              <td colspan="4" class="tdCol1">Tipo</td>
              <td colspan="4" class="tdCol1">Paciente</td>
              <td colspan="4" class="tdCol1">Última Observação</td>
            
  
          </tr>'
);

$selectobs = "SELECT hrAgenda,dtAgenda,tpConsulta,confConsulta,pac.namePac as namePac,observacaoAgenda, agd.id as identificadorAgd from agendamentos as agd,pacientescli as pac where pac.id = agd.fkPaciente
and   agd.RommConsult = '" . $_GET['params'] . "'
AND agd.dtAgenda BETWEEN '" . $dayInicial . "' AND '" . $dayfim . "'
       ORDER BY agd.dtAgenda asc, agd.hrAgenda asc";
$resultObs = mysqli_query($conn, $selectobs);
while ($linha_result = mysqli_fetch_assoc($resultObs)) {

    $mpdf->WriteHTML(
        '<tr>
                           
                            <td colspan="4" >' . date('d/m/Y', strtotime($linha_result['dtAgenda'])) . '</td>
                            <td colspan="4" >' . $linha_result['hrAgenda'] . '</td>
                            <td colspan="4" >' . $linha_result['tpConsulta'] . '</td>
                            <td colspan="4" >' . $linha_result['namePac'] . '</td>
                            <td colspan="4" >' . $linha_result['observacaoAgenda'] . '</td>
                       
                           
                         </tr>'
    );
}

$mpdf->WriteHTML(
    '
      </table>
     
      <p class ="footer">ABC OFTALMOLOGIA | Tel: (11) 96338-8538 - Avenida Antártico, 381 - Sala 123,127 ,
      Jardim do Mar, São Bernardo do Campo - SP</p>
  </body>
  
  </html>
                '
);


$arquivo = "Agendamentos-" . date_format($dayIniFormated, "d-m-Y ") . "-" . date_format($dayFimFormated, "d-m-Y ") . ".pdf";

$mpdf->Output($arquivo, 'I');

// I - Abre no navegador
// F - Salva o arquivo no servidor
// D - Salva o arquivo no computador do usuário
