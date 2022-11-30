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


$dayInicial =  $_SESSION['dayAgendainicio'];
$dayfim =  $_SESSION['dayAgendafim'];
$item = json_decode($_GET['item'], true);

$mpdf->WriteHTML(
    '<html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Recibos</title>
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
            width: 70%;
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
  
      <p>Paciente: ' . $item['namePac'] . ' | TEL: ' . $item['cel'] . ' | Email: ' . $item['email'] . ' </p>
      <p>Recebido por: ' .   $_SESSION['nomeUsuario'] . ' Nº Recibo: ' . $item['identificador'] . ' Data Emissão: ' . date('d/m/Y') . '</p>
      <h1 align="center">Recibo</h1>
      <table>
          <tr>
              <td colspan="4" class="tdCol1">Procedimentos</td>
              <td colspan="4" class="tdCol2">Valor</td>
  
          </tr>'
);

$selectobs = "SELECT  * FROM    procedimentos where id in (" . $item['proced'] . ")";
$resultObs = mysqli_query($conn, $selectobs);
while ($linha_result = mysqli_fetch_assoc($resultObs)) {
    $IScONVENIO = $item['convenio'] == 'SIM' ? number_format($linha_result['valorConv'], 2) : number_format($linha_result['valorPart'], 2);
    $mpdf->WriteHTML(
        '<tr>
                            <td colspan="4" >' . $linha_result['descProcedimento'] . '</td>
                            <td colspan="4" >R$ ' . $IScONVENIO . '</td>
                         </tr>'
    );
}

$mpdf->WriteHTML(
    '
      </table>

      <p class ="total">Total: R$ ' . number_format($item['total'], 2) . '</p>
      <p  style =" margin-top: 5px;">Total pago: R$ ' . number_format($item['totalRcb'], 2) . '</p>
      <p  style =" margin-top: 5px;">Descontos: R$ ' . number_format($item['discontos'], 2) . '</p>
      <p  style =" margin-top: 5px;">Valor a pagar: R$ ' . number_format($item['total'] -  $item['totalRcb'] - $item['discontos'], 2) . '</p>
  
      <p class ="footer">ABC OFTALMOLOGIA | Tel: (11) 96338-8538 - Avenida Antártico, 381 - Sala 123,127 ,
      Jardim do Mar, São Bernardo do Campo - SP</p>
  </body>
  
  </html>
                '
);


$arquivo = "Recibo-" . str_replace(" ", "-", $item['namePac']) . "-" . date('d-m-Y') . ".pdf";

$mpdf->Output($arquivo, 'I');

// I - Abre no navegador
// F - Salva o arquivo no servidor
// D - Salva o arquivo no computador do usuário
