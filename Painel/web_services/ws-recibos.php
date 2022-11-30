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

$app->POST('/listRecibos', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $_SESSION['dayAgendainicio'] = null;
            $_SESSION['dayAgendafim'] = null;
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);

            $_SESSION['dayAgendainicio'] = $jsonObj['days1'];
            $_SESSION['dayAgendafim'] = $jsonObj['days2'];

            $query = "SELECT rcb.id as identificadorRcb, rcb.dtInclude as dataInclusao, pac.namePac as namePac,rcb.parcelas as parc,
    rcb.fmPagamento as formaPag, rcb.tipo as typeRcb, rcb.total as Totalpagamento,rcb.discount as discount, rcb.totalRecebido as totalRcb,
    rcb.dtInclude as dataAtualInclude, replace(replace(rcb.idProcedimentos,'[',''),']','')  as idProced,rcb.totalRecbCard as totalCard,
    pac.convPac as convenio,pac.celPac as cel,pac.emailPac as email

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
                $arr[$i]["email"] = $linha_result['email'];
                $arr[$i]["cel"] = $linha_result['cel'];
                $arr[$i]["parc"] = $linha_result['parc'];
                $arr[$i]["convenio"] = $linha_result['convenio'];
                $arr[$i]["proced"] = $linha_result['idProced'];
                $arr[$i]["dataAtualInclude"] = date('d/m/Y', strtotime($linha_result['dataAtualInclude']));
                $arr[$i]["total"] = $linha_result['Totalpagamento'];
                $arr[$i]["discontos"] = $linha_result['discount'];
                $arr[$i]["totalRcb"] = $linha_result['totalRcb'] + $linha_result['totalCard'];
                $arr[$i]["dataInclusao"] =   date('d/m/Y', strtotime($linha_result['dataInclusao']));
                $arr[$i]["typeRcb"] = $linha_result['typeRcb'];

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


$app->post('/filterAgendamentoPac', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');


            $query1 = "SELECT  replace(replace(fkProcedimentos,'[',''),']','') as  fkProcedimentos FROM agendamentos
     WHERE dtAgenda = '" . $_POST['DtRecido'] . "' 
    AND fkPaciente= '" . $_POST['identificadorPac'] . "' 
    AND tpConsulta = 'EXAME'";
            $result1 = mysqli_query($conn, $query1);
            $linha_result = mysqli_fetch_assoc($result1);
            $arr = array();
            $i = 0;

            $procedimentos =  $linha_result['fkProcedimentos'];

            if ($result1->num_rows > 0) {


                $query2 = "SELECT * FROM procedimentos
    WHERE id in($procedimentos) ";
                $result2 = mysqli_query($conn, $query2);


                while ($linha_result = mysqli_fetch_assoc($result2)) {
                    $arr[$i]["identificador"] = $linha_result['id'];
                    $arr[$i]["descproc"] = $linha_result['descProcedimento'];
                    $arr[$i]["valParticular"] = $linha_result['valorPart'];
                    $arr[$i]["valConvenio"] = $linha_result['valorConv'];

                    $i++;
                };
                echo json_encode($arr);
            } else {
                echo json_encode($arr);
            }
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/infosRecibos', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);


            $query = "SELECT * FROM recebimentos AS rcb, pacientescli as pac where rcb.id =" . $_POST['identificador'] . " 
            and pac.id = rcb.idPaciente";
            $result = mysqli_query($conn, $query);
            $linha_result = mysqli_fetch_assoc($result);
            echo json_encode($linha_result);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/gravaRecibos', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $query = "SELECT * FROM recebimentos WHERE idPaciente = " . $jsonObj['identificadorPac'] . "  AND dtInclude = '" . $jsonObj['dataRecibo'] . "' ";
            $result = mysqli_query($conn, $query);
            if ($result->num_rows > 0) {
                echo 'regExist';
                return;
            }
            $query = "INSERT INTO recebimentos VALUES(null,'" . json_encode($jsonObj['procedimentos']) . "','" . $jsonObj['identificadorPac'] . "','" . $jsonObj['valTotal'] . "','" . $jsonObj['valPago'] . "','" . $jsonObj['valPagoCard'] . "',
            '" . $jsonObj['valDiscount'] . "','" . $jsonObj['valAPay'] . "','" . json_encode($jsonObj['typePayment']) . "','" . $jsonObj['formPayment'] . "','" . json_encode($jsonObj['typeCard']) . "','" . $jsonObj['parcels'] . "',CURDATE(),'" . $jsonObj['dataRecibo'] . "',CURDATE(),
            '" . $jsonObj['rowinsert'] . "') ";
            $result = mysqli_query($conn, $query);
            echo 'ok', $query;
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/updateRecibos', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();


            $jsonObj = json_decode($jsonbruto, true);
            $query = "UPDATE recebimentos SET idProcedimentos =  '" . json_encode($jsonObj['procedimentos']) . "',total = '" . $jsonObj['valTotal'] . "',totalRecebido = '" . $jsonObj['valPago'] . "',totalRecbCard = '" . $jsonObj['valPagoCard'] . "',discount = 
            '" . $jsonObj['valDiscount'] . "',valaPay = '" . $jsonObj['valAPay'] . "',tipo = '" . json_encode($jsonObj['typePayment']) . "',fmPagamento = '" . $jsonObj['formPayment'] . "',
            typeCard = '" . json_encode($jsonObj['typeCard']) . "',
            parcelas = '" . $jsonObj['parcels'] . "',dtVencimento = CURDATE(),dtInclude='" . $jsonObj['dataRecibo'] . "',dtCurdate = CURDATE(),
            RommRcb =  '" . $jsonObj['rowinsert'] . "' WHERE id = " . json_encode($jsonObj['idprocedimentos']) . " ";
            $result = mysqli_query($conn, $query);
            // echo $query;
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});


$app->post('/filterAgendamentoPac', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();


            $jsonObj = json_decode($jsonbruto, true);

            $insert = "INSERT INTO recebimentos VALUES(NULL,'" . $jsonObj[''] . "','" . $jsonObj['identificadorPac'] . "',
    '" . $jsonObj['valTotal'] . "','" . $jsonObj['valPago'] . "','" . $jsonObj['valDiscount'] . "','" . $jsonObj['valAPay'] . "',
    '" . $jsonObj['typePayment'] . "','" . $jsonObj['formPayment'] . "','" . $jsonObj['parcels'] . "','" . $jsonObj['dataVenc'] . "',
    '" . $jsonObj['dataRecibo'] . "',CURDATE(),'" . $jsonObj['rowinsert'] . "')";
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/deletaRecibos', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $query = "DELETE FROM recebimentos WHERE id =" . $_POST['identificador'] . " ";
            $result = mysqli_query($conn, $query);
            $insert = "";
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->run();
