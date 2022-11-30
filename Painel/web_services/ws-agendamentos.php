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

$app->post('/listAgendamentos', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $conn = include('../includes/conexao.php');
            $_SESSION['dayAgendainicio'] = $jsonObj['days1'];
            $_SESSION['dayAgendafim'] = $jsonObj['days2'];
            $andFkPac = $jsonObj['idPac'] == '0' ? '' : 'AND agd.fkPaciente = ' . $jsonObj['idPac'] . '';

            $query = "SELECT hrAgenda,dtAgenda,tpConsulta,confConsulta,pac.namePac as namePac,observacaoAgenda, agd.id as identificadorAgd,
                agd.statusAgenda as statusA, pac.id as idPac
            
             from agendamentos as agd,pacientescli as pac 
             where pac.id = agd.fkPaciente
             $andFkPac
   and   agd.RommConsult = '" . $jsonObj['roomLocation'] . "'
   AND agd.dtAgenda BETWEEN '" . $jsonObj['days1'] . "' AND '" . $jsonObj['days2'] . "'
          ORDER BY agd.dtAgenda asc,agd.hrAgenda asc ";
            $result = mysqli_query($conn, $query);
            $arr = array();
            $i = 0;

            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["identificador"] = $linha_result['identificadorAgd'];
                $arr[$i]["identificadorPac"] = $linha_result['idPac'];
                $arr[$i]["dataAgendamento"] =   date('d/m/Y', strtotime($linha_result['dtAgenda']));
                $arr[$i]["hrAgendamento"] = $linha_result['hrAgenda'];
                $arr[$i]["tpAgendamento"] = $linha_result['tpConsulta'];
                $arr[$i]["nomePacAgendamento"] = $linha_result['namePac'];
                $arr[$i]["statusA"] = $linha_result['statusA'];
                $arr[$i]["confirmarcaoConsu"] = $linha_result['confConsulta'];
                $arr[$i]["obsAgendamento"] = $linha_result['observacaoAgenda'];
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

$app->post('/gravaAgendamento', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            // SELECT *, SUBTIME(hrAgenda,'3000') FROM `agendamentos` where dtAgenda = '2021-10-10'  and SUBTIME(hrAgenda,'3000') BETWEEN SUBTIME(hrAgenda,'29000') and  '09:30:00' or ADDTIME(hrAgenda,'2900') BETWEEN ADDTIME(hrAgenda,'29000') and  '10:40:00'
            $query = "SELECT * FROM `agendamentos` where dtAgenda = '" . $jsonObj['dataAgendamento'] . "' 
     and hrAgenda BETWEEN SUBTIME('" . $jsonObj['hrAgendamento'] . "','2900') and '" . $jsonObj['hrAgendamento'] . "'
     or hrAgenda BETWEEN '" . $jsonObj['hrAgendamento'] . "' and ADDTIME('" . $jsonObj['hrAgendamento'] . "','2900')  
     ";
            $resultQuery = mysqli_query($conn, $query);

            $nvAcesso =  $_SESSION['nvAcesso'];

            if ($nvAcesso <= 3) {

                $insert = "INSERT INTO `agendamentos` (`id`, `RommConsult`, `dtAgenda`, `hrAgenda`, `tpConsulta`, `confConsulta`,
    `observacaoAgenda`, `fkPaciente`,`fkProcedimentos`) 
    VALUES (NULL, '" .  $jsonObj['roomLocation'] . "', '" . $jsonObj['dataAgendamento'] . "', '" . $jsonObj['hrAgendamento'] . "', 
    '" . $jsonObj['tpConsulta'] . "', '" . $jsonObj['confirmadoConsulta'] . "',  '" . $jsonObj['observacaoAgenda'] . "', 
    '" . $jsonObj['identificadorPac'] . " ', '" . json_encode($jsonObj['arrayProcedimentos'])  . "')";

                $result = mysqli_query($conn, $insert);
            } else if ($resultQuery->num_rows  < 1) {


                $insert = "INSERT INTO `agendamentos` (`id`, `RommConsult`, `dtAgenda`, `hrAgenda`, `tpConsulta`, `confConsulta`,  
    `observacaoAgenda`, `fkPaciente`,`fkProcedimentos`) 
    VALUES (NULL, '" .  $jsonObj['roomLocation'] . "', '" . $jsonObj['dataAgendamento'] . "', '" . $jsonObj['hrAgendamento'] . "', 
    '" . $jsonObj['tpConsulta'] . "', '" . $jsonObj['confirmadoConsulta'] . "', '" . $jsonObj['observacaoAgenda'] . "', '" . $jsonObj['identificadorPac'] . " ', '" . json_encode($jsonObj['arrayProcedimentos'])  . "')";

                $result = mysqli_query($conn, $insert);
            } else {
                echo 'invalid';
            }
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});



$app->post('/infoAgendamento', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $insert = "SELECT pac.id as identificador,
            pac.namePac as namePaciente ,
            pac.telPac as telefonePaciente,
            pac.celPac as celularPaciente,
            pac.codeCpfPac as cpfPaciente,
            pac.codeRGPac as rgPaciente,
            pac.dt_nascPac as dataNascimentoPaciente,
            pac.convPac as convenioPaciente,
            pac.nameConvPac as nameConvPaciente,
            DATE_FORMAT(agd.dtAgenda, '%d-%m-%Y') as dataAgendamento,
            agd.hrAgenda as HoraAgendamento,
            agd.tpConsulta as tipoAgendamento,
            agd.confConsulta as confirmaAgendamento,
            agd.observacaoAgenda as observacao,
            agd.fkPaciente as paciente,
            agd.obsMedico as observacaoMed,
          agd.fkProcedimentos as  fkProcedimentos ,
          ifnull((SELECT prt.observacaoProntuario FROM prontuario AS prt WHERE fkpaciente = agd.fkPaciente),'[]') as  obsProntuario 
         FROM agendamentos agd, pacientescli pac  where agd.id = " . $_POST['identificadorModal'] . " and agd.fkPaciente = pac.id
        
         ";
            $result = mysqli_query($conn, $insert);

            echo  json_encode(mysqli_fetch_assoc($result));
            // echo   $insert;
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/updateAgendamento', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);

            $selectobs = "SELECT * FROM prontuario WHERE fkpaciente =" .  $jsonObj['identificadorPac'] . "";
            $resultObs = mysqli_query($conn, $selectobs);

            if ($resultObs->num_rows > 0) {
                $QUERYuP = "UPDATE prontuario SET observacaoProntuario = '" . json_encode($jsonObj['obsmedico']) . "' WHERE fkpaciente = " .  $jsonObj['identificadorPac'] . "";
                $resultObs = mysqli_query($conn, $QUERYuP);
                // echo $QUERYuP;
            } else {
                $queryInsert = "INSERT INTO prontuario VALUES(null, '" . json_encode($jsonObj['obsmedico']) . "', " .  $jsonObj['identificadorPac'] . ")";
                $resultObs = mysqli_query($conn, $queryInsert);
                // echo $queryInsert;
            }
            $statusAgenda = $jsonObj['med'] == '1' ? 'statusAgenda = "atendido",' : '';

            $insert = "UPDATE `agendamentos`  SET `RommConsult` ='" .  $jsonObj['roomLocation'] . "' , `dtAgenda`  ='" .  $jsonObj['dataAgendamento'] . "',
     `hrAgenda`  ='" .  $jsonObj['hrAgendamento'] . "', `tpConsulta`  ='" .  $jsonObj['tpConsulta'] . "', $statusAgenda `confConsulta`  ='" .  $jsonObj['confirmadoConsulta'] . "',
      `procedimento`  ='0', `observacaoAgenda`  ='" .  $jsonObj['observacaoAgenda'] . "',obsMedico = '" . json_encode($jsonObj['obsmedico']) . "', `fkPaciente`  ='" .  $jsonObj['identificadorPac'] . "',
      `fkProcedimentos` = '" . json_encode($jsonObj['arrayProcedimentos'])  . "',`finalyProced` = '" .  $jsonObj['med'] . "'
       WHERE id  =" .  $jsonObj['identificadorAgd'] . " ";
            $result = mysqli_query($conn, $insert);
            echo 'ok' . $insert;
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/deletaAgendamento', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);


            $query = "DELETE FROM agendamentos WHERE id =" . $_POST['identificador'] . " ";
            $result = mysqli_query($conn, $query);
            echo 'ok';
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/verifyAgendamento', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');


            $query = "SELECT * FROM agendamentos agd,pacientescli as pac WHERE isAgendado = 1  and pac.id = agd.fkPaciente ";
            $result = mysqli_query($conn, $query);
            $arr = array();
            $i = 0;
            $_SESSION['numberAgendas'] = $result->num_rows;
            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["dataAgendamento"] =   date('d/m/Y', strtotime($linha_result['dtAgenda']));
                $arr[$i]["numberAgendas"] =  $result->num_rows;
                $i++;
            }
            echo json_encode($arr);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/upStatus', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);


            $query = "UPDATE agendamentos SET statusAgenda = '" . $_POST['value'] . "' WHERE id =" . $_POST['identificador'] . " ";
            $result = mysqli_query($conn, $query);
            echo 'ok';
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/updateAgendaIsAgenda', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);


            $query = "UPDATE agendamentos SET isAgendado = 0  ";
            $result = mysqli_query($conn, $query);
            echo 'ok';
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->get('/listaprocedimentos', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);



            $insert = "SELECT * FROM procedimentos";
            $result = mysqli_query($conn, $insert);
            $arr = array();
            $i = 0;

            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["identificador"] = $linha_result['id'];
                $arr[$i]["descr"] =  $linha_result['descProcedimento'];
                $arr[$i]["valParticular"] = $linha_result['valorPart'];
                $arr[$i]["valConvenio"] = $linha_result['valorConv'];
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

$app->post('/cargaEmpresas(/)', function () use ($app) {

    require_once './PHPExcel-1.8/Classes/PHPExcel.php';

    $conn = include('../includes/conexao.php');
    if (!empty($_FILES["excelEmpresas"])) {

        $extension = (explode('.', $_FILES["excelEmpresas"]["name"])); // For getting Extension of selected file
        $file_ext = strtolower(end($extension));
        $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
        if (in_array($file_ext, $allowed_extension)) //check selected file extension is present in allowed extension array
        {
            $file = $_FILES["excelEmpresas"]["tmp_name"]; // getting temporary source of excel file
            include_once("./PHPExcel-1.8/Classes/PHPExcel.php"); // Add PHPExcel Library in this code
            $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file


            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 1; $row <= $highestRow; $row++) {


                    $dateFormat =  PHPExcel_Style_NumberFormat::toFormattedString(mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)), 'YYYY-MM-dd');

                    $TimerFormat =   PHPExcel_Style_NumberFormat::toFormattedString(mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(1, $row)), 'hh:mm');

                    $tipo = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $nome = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $observacao = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(4, $row)->getValue());

                    $SELECTPac = "SELECT * FROM pacientescli WHERE namePac like '%$nome%'";
                    $result = mysqli_query($conn, $SELECTPac);
                    $linha_result = mysqli_fetch_assoc($result);
                    echo json_encode($TimerFormat);
                    $insert = "INSERT into agendamentos (RommConsult,dtAgenda,hrAgenda,tpConsulta,confConsulta,observacaoAgenda,fkPaciente,fkProcedimentos)
                           VALUES(2,'$dateFormat','$TimerFormat','$tipo','SIM','$observacao', '" . $linha_result['id'] . "','[]') ";
                    $result = mysqli_query($conn, $insert);
                    // return;
                }
            }
        }
    }
    // echo $query;

});

$app->post('/listAgendamentosNew', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $conn = include('../includes/conexao.php');

            $query = "SELECT hrAgenda,dtAgenda,tpConsulta,confConsulta,pac.namePac as namePac,observacaoAgenda, agd.id as identificadorAgd,
                agd.statusAgenda as statusA, pac.id as idPac
              from agendamentos as agd,pacientescli as pac 
              WHERE isAgendado = 1
             AND pac.id = agd.fkPaciente";
            $result = mysqli_query($conn, $query);
            $arr = array();
            $i = 0;

            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["identificador"] = $linha_result['identificadorAgd'];
                $arr[$i]["numberAgendas"] =  $result->num_rows;
                $arr[$i]["identificadorPac"] = $linha_result['idPac'];
                $arr[$i]["dataAgendamento"] =   date('d/m/Y', strtotime($linha_result['dtAgenda']));
                $arr[$i]["hrAgendamento"] = $linha_result['hrAgenda'];
                $arr[$i]["tpAgendamento"] = $linha_result['tpConsulta'];
                $arr[$i]["nomePacAgendamento"] = $linha_result['namePac'];
                $arr[$i]["statusA"] = $linha_result['statusA'];
                $arr[$i]["confirmarcaoConsu"] = $linha_result['confConsulta'];
                $arr[$i]["obsAgendamento"] = $linha_result['observacaoAgenda'];
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

$app->post('/updateAgendaIsAgendaNew', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);


            $query = "UPDATE agendamentos SET isAgendado = 0 where id = " . $jsonObj['id'] . "  ";
            $result = mysqli_query($conn, $query);
            echo 'ok';
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->run();
