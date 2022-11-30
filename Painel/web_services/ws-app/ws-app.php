<?php

header('Content-type: text/html; charset=utf-8; application/json');
ini_set('default_charset', 'UTF-8');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
date_default_timezone_set('America/Sao_Paulo');
require '../Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->post('/authenticate', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {


        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);


        $conn = include('../../includes/conexao.php');
        $queryUser = "SELECT * from pacientescli as pc
    where (pc.emailPac = '" . $jsonObj['usuario'] . "' or replace(replace(pc.codeCpfPac,'.',''),'-','') = '" . $jsonObj['usuario'] . "' )
   
     ";

        $resultUser = mysqli_query($conn, $queryUser);
        if ($resultUser->num_rows > 0) {
            $query = "SELECT * from pacientescli as pc,passpacientes as pass
        where pc.id = pass.fkPaciente
        and (pc.emailPac = '" . $jsonObj['usuario'] . "' or replace(replace(pc.codeCpfPac,'.',''),'-','') = '" . $jsonObj['usuario'] . "' )
        and pass.password = MD5('" . $jsonObj['password'] . "')
         ";
            $result = mysqli_query($conn, $query);
            $linhaResult = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {
                echo json_encode($linhaResult);
                return;
            }

            echo 'passInvalid';
        } else {
            echo 'userInvalid';
        }
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/register', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);
        $data = implode("-", array_reverse(explode("/", $jsonObj['dtNascimento'])));


        $query = "SELECT * from pacientescli where codeCpfPac = '" . $jsonObj['cpfUser'] . "'";
        $result = mysqli_query($conn, $query);
        $linhaResultId = mysqli_fetch_assoc($result);
        if ($result->num_rows > 0) {

            $query = "SELECT * from passpacientes where fkPaciente = " .  $linhaResultId['id'] . "";
            $result = mysqli_query($conn, $query);
            $linhaResult = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {
                $insert = "UPDATE  passpacientes set  `password` = '" . md5($jsonObj['passwordConfirm']) . "' where fkPaciente = " . $linhaResultId['id'] . " ";
                $result = mysqli_query($conn, $insert);
            } else {
                $insert = "INSERT into passpacientes values(null,'" . md5($jsonObj['passwordConfirm']) . "'," . $linhaResultId['id'] . ") ";
                $result = mysqli_query($conn, $insert);
            }


            echo 'userExiste';
            return;
        }

        $cep = CEP(str_replace('-', '', $jsonObj['CepUser']));
        $insert = "INSERT into pacientescli values(null,'0','" . $jsonObj['nome'] . "',  '','" . $jsonObj['telUser'] . "',
    '" . $jsonObj['cpfUser'] . "','','" . $jsonObj['email'] . "','" . $data . "',
    '" . $cep['cep'] . "','" . $cep['logradouro'] . "','" . $cep['bairro'] . "','" . $cep['localidade'] . "','" . $cep['uf'] . "','',
    '" . $jsonObj['Convenio'] . "','" . $jsonObj['NameConvenio'] . "','' ) ";
        $result = mysqli_query($conn, $insert);


        $query = "SELECT id from pacientescli where codeCpfPac = '" . $jsonObj['cpfUser'] . "'";
        $result = mysqli_query($conn, $query);
        $linhaResult = mysqli_fetch_assoc($result);

        $insert = "INSERT into passpacientes values(null,'" . md5($jsonObj['passwordConfirm']) . "'," . $linhaResult['id'] . ") ";
        $result = mysqli_query($conn, $insert);
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/updateRegister', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);
        $data = implode("-", array_reverse(explode("/", $jsonObj['dtNascimento'])));

        $cep = CEP(str_replace('-', '', $jsonObj['CepUser']));
        $insert = "UPDATE  pacientescli  set namePac = '" . $jsonObj['nome'] . "',celPac = '" . $jsonObj['telUser'] . "',emailPac = '" . $jsonObj['email'] . "',cepPac = 
    '" . $cep['cep'] . "',addressPac = '" . $cep['logradouro'] . "',neigthPac = '" . $cep['bairro'] . "',cityPac = '" . $cep['localidade'] . "',statePac = '" . $cep['uf'] . "',convPac = 
    '" . $jsonObj['Convenio'] . "',nameConvPac = '" . $jsonObj['NameConvenio'] . "' where id = " . $jsonObj['fkPaciente'] . " ";
        $result = mysqli_query($conn, $insert);

        echo     'update';
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/updatePass', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);

        $insert = "UPDATE  passpacientes set `password` = '" . md5($jsonObj['passwordNew']) . "' where fkPaciente = " . $jsonObj['iduser'] . " ";
        $result = mysqli_query($conn, $insert);
        echo     'update';
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/listhistory', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);
        $arr = array();
        $i = 0;
        $query = "SELECT hrAgenda,dtAgenda,tpConsulta,confConsulta,pac.namePac as namePac,observacaoAgenda, agd.id as identificadorAgd from agendamentos as agd,pacientescli as pac
     where pac.id =  agd.fkPaciente
     and agd.fkPaciente = " . $jsonObj['idenfificadorPac'] . "
     AND agd.finalyProced = 1
           ORDER BY agd.dtAgenda desc ";
        $result = mysqli_query($conn, $query);

        while ($linha_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["identificador"] = $linha_result['identificadorAgd'];
            $arr[$i]["dataAgendamento"] =   date('d/m/Y', strtotime($linha_result['dtAgenda']));
            $arr[$i]["hrAgendamento"] = $linha_result['hrAgenda'];
            $arr[$i]["tpAgendamento"] = $linha_result['tpConsulta'];
            $arr[$i]["nomePacAgendamento"] = $linha_result['namePac'];
            $arr[$i]["confirmarcaoConsu"] = $linha_result['confConsulta'];
            $arr[$i]["obsAgendamento"] = $linha_result['observacaoAgenda'];
            $i++;
        };

        echo json_encode($arr);
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/listagendamento', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);
        $arr = array();
        $i = 0;
        $query = "SELECT hrAgenda,dtAgenda,tpConsulta,confConsulta,pac.namePac as namePac,observacaoAgenda, agd.id as identificadorAgd from agendamentos as agd,pacientescli as pac
    where pac.id =  agd.fkPaciente
    and agd.fkPaciente = " . $jsonObj['idenfificadorPac'] . "
    AND agd.finalyProced = 0
           ORDER BY agd.dtAgenda desc ";
        $result = mysqli_query($conn, $query);

        while ($linha_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["identificador"] = $linha_result['identificadorAgd'];
            $arr[$i]["dataAgendamento"] =   date('d/m/Y', strtotime($linha_result['dtAgenda']));
            $arr[$i]["hrAgendamento"] = $linha_result['hrAgenda'];
            $arr[$i]["tpAgendamento"] = $linha_result['tpConsulta'];
            $arr[$i]["nomePacAgendamento"] = $linha_result['namePac'];
            $arr[$i]["confirmarcaoConsu"] = $linha_result['confConsulta'];
            $arr[$i]["obsAgendamento"] = $linha_result['observacaoAgenda'];
            $i++;
        };

        echo json_encode($arr);
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/gravaAgendamento', function () use ($app) {

    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {

        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);
        // SELECT *, SUBTIME(hrAgenda,'3000') FROM `agendamentos` where dtAgenda = '2021-10-10'  and SUBTIME(hrAgenda,'3000') BETWEEN SUBTIME(hrAgenda,'29000') and  '09:30:00' or ADDTIME(hrAgenda,'2900') BETWEEN ADDTIME(hrAgenda,'29000') and  '10:40:00'
        $query = "SELECT * FROM `agendamentos` where dtAgenda = '" . $jsonObj['dataAgendamento'] . "' 
     and (hrAgenda BETWEEN SUBTIME('" . $jsonObj['hrAgendamento'] . "','2900') and '" . $jsonObj['hrAgendamento'] . "'
     or (hrAgenda BETWEEN '" . $jsonObj['hrAgendamento'] . "' and ADDTIME('" . $jsonObj['hrAgendamento'] . "','2900'))  )
     ";

        $resultQuery = mysqli_query($conn, $query);
        if ($resultQuery->num_rows  < 1) {


            $insert = "INSERT INTO `agendamentos` (`id`, `RommConsult`, `dtAgenda`, `hrAgenda`, `tpConsulta`, `confConsulta`, `procedimento`, 
    `observacaoAgenda`, `fkPaciente`,`fkProcedimentos`,isAgendado) 
    VALUES (NULL, '2', '" . $jsonObj['dataAgendamento'] . "', '" . $jsonObj['hrAgendamento'] . "', 
    '" . $jsonObj['tpConsulta'] . "', 'SIM', '0', '', 
    '" . $jsonObj['identificadorPac'] . " ', '" . json_encode($jsonObj['arrayProcedimentos'])  . "',1)";
            $result = mysqli_query($conn, $insert);

            return;
        }
        echo 'invalid';
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/consultTimer', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);
        // SELECT *, SUBTIME(hrAgenda,'3000') FROM `agendamentos` where dtAgenda = '2021-10-10'  and SUBTIME(hrAgenda,'3000') BETWEEN SUBTIME(hrAgenda,'29000') and  '09:30:00' or ADDTIME(hrAgenda,'2900') BETWEEN ADDTIME(hrAgenda,'29000') and  '10:40:00'
        $query = "SELECT   TIME_FORMAT(hrAgenda, '%H:%i') as hrAgenda FROM `agendamentos` where dtAgenda = '" . $jsonObj['dtConsulta'] . "'";
        $resultQuery = mysqli_query($conn, $query);
        $arr = array();
        $i = 0;
        while ($linha_result = mysqli_fetch_assoc($resultQuery)) {
            $arr[$i]["horarios"] = $linha_result['hrAgenda'];
            $i++;
        };

        echo json_encode($arr);
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/validaQrCode', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');
        $jsonbruto = $app->request()->getBody();

        $jsonObj = json_decode($jsonbruto, true);
        // SELECT *, SUBTIME(hrAgenda,'3000') FROM `agendamentos` where dtAgenda = '2021-10-10'  and SUBTIME(hrAgenda,'3000') BETWEEN SUBTIME(hrAgenda,'29000') and  '09:30:00' or ADDTIME(hrAgenda,'2900') BETWEEN ADDTIME(hrAgenda,'29000') and  '10:40:00'
        $query = "UPDATE pacientescli set convenioAbc = 1 where id =" . $jsonObj['idPaciente'] . " ";
        $resultQuery = mysqli_query($conn, $query);
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});


$app->get('/listProcedimentos', function () use ($app) {
    $charset = $app->request->headers->get('AuthorizationApp');

    if ($charset == 'a3eb5d907e979ba34f45d0b0462f8792') {
        $conn = include('../../includes/conexao.php');

        $query = "SELECT * from procedimentos";
        $result = mysqli_query($conn, $query);
        $arr = array();
        $i = 0;
        while ($linha_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["identificadorProced"] = $linha_result['id'];
            $arr[$i]["descricao"] = $linha_result['descProcedimento'];
            $arr[$i]["vaP"] = $linha_result['valorPart'];
            $arr[$i]["vaC"] = $linha_result['valorConv'];
            $i++;
        };

        echo json_encode($arr);
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

function CEP($cep)
{
    $ch = curl_init();
    $url = "http://viacep.com.br/ws/{$cep}/json/";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $data = curl_exec($ch);

    curl_close($ch);

    return json_decode($data, true);
}


$app->run();
