<?php

header('Content-type: text/html; charset=utf-8; application/json');
ini_set('default_charset', 'UTF-8');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
date_default_timezone_set('America/Sao_Paulo');
require './Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->POST('/listFechamento', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();
            $jsonObj = json_decode($jsonbruto, true);
            $_SESSION['dayFechamentoinicio'] = $jsonObj['days1'];
            $_SESSION['dayFechamentofim'] = $jsonObj['days2'];

            $query = "SELECT rcb.id as identificadorRcb, rcb.dtInclude as dataInclusao, pac.namePac as namePac,rcb.parcelas as parc,
    rcb.fmPagamento as formaPag, rcb.tipo as typeRcb, rcb.total as Totalpagamento,rcb.discount as discount, rcb.totalRecebido as totalRcb,
    rcb.dtCurdate as dataAtualInclude
      from recebimentos as rcb
     inner join pacientescli as pac on pac.id = rcb.idPaciente
   where   rcb.RommRcb = '" . $jsonObj['roomLocation'] . "'
    AND rcb.dtInclude BETWEEN '" . $jsonObj['days1'] . "' AND '" . $jsonObj['days2'] . "'
          ORDER BY rcb.dtInclude desc ";
            $result = mysqli_query($conn, $query);
            $arr = array();
            $i = 0;

            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["identificador"] = $linha_result['identificadorRcb'];
                $arr[$i]["namePac"] = $linha_result['namePac'];
                $arr[$i]["parc"] = $linha_result['parc'];
                $arr[$i]["dataAtualInclude"] = date('d/m/Y', strtotime($linha_result['dataInclusao']));
                $arr[$i]["total"] = $linha_result['Totalpagamento'];
                $arr[$i]["totalRcb"] = $linha_result['totalRcb'];


                $i++;
            };

            echo json_encode($arr);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});



$app->run();
