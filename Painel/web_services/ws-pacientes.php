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

$app->get('/listPacientes', function () use ($app) {

    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {


            $conn = include('../includes/conexao.php');

            $query = "SELECT * from pacientescli ";
            $result = mysqli_query($conn, $query);
            $arr = array();
            $i = 0;

            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["identificadorPac"] = $linha_result['id'];
                $arr[$i]["nomePaciente"] = $linha_result['namePac'];
                $arr[$i]["CpfPaciente"] = $linha_result['codeCpfPac'];
                $arr[$i]["rgPaciente"] = $linha_result['codeRGPac'];
                $arr[$i]["dtNascimento"] = date('d/m/Y', strtotime($linha_result['dt_nascPac']));
                $arr[$i]["telPaciente"] = $linha_result['telPac'];
                $arr[$i]["celpaciente"] = $linha_result['celPac'];
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
$app->post('/gravaPacientes', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $query = "SELECT * from pacientescli where codeCpfPac = '" . $jsonObj['CpfPaciente'] . "'";
            $result = mysqli_query($conn, $query);
            if ($result->num_rows > 0) {
                echo 'userExiste';
            } else {
                $insert = "INSERT into pacientescli values(null,'0','" . $jsonObj['namePaciente'] . "',  '" . $jsonObj['telPaciente'] . "','" . $jsonObj['celularPaciente'] . "',
        '" . $jsonObj['CpfPaciente'] . "','" . $jsonObj['RgPaciente'] . "','" . $jsonObj['emailPaciente'] . "','" . $jsonObj['dataNasciPaciente'] . "',
        '" . $jsonObj['CepPaciente'] . "','" . $jsonObj['EndPaciente'] . "','" . $jsonObj['BairroPaciente'] . "','" . $jsonObj['cidadePaciente'] . "','" . $jsonObj['EstadoPaciente'] . "','" . $jsonObj['NumeroPaciente'] . "',
        '" . $jsonObj['isConvenio'] . "','" . $jsonObj['nomeConvenio'] . "','" . $jsonObj['observacaoAgenda'] . "' ) ";
                $result = mysqli_query($conn, $insert);
                // echo $insert;
            }
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/VerificaPacientes', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $query = "SELECT * from pacientescli where replace(replace(codeCpfPac,'.',''),'-','') ='" . $jsonObj['cpfpacinte'] . "' ";
            $result = mysqli_query($conn, $query);
            if ($result->num_rows > 0) {
                echo 'userExiste';
            }
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/listaInfopaciente', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            // $jsonbruto = $app->request()->getBody();

            // $jsonObj = json_decode($jsonbruto, true);
            $query = "SELECT id as identificador,
      namePac as namePaciente ,
      telPac as telefonePaciente,
      celPac as celularPaciente,
      codeCpfPac as cpfPaciente,
      codeRGPac as rgPaciente,
      emailPac as emailPaciente,
      dt_nascPac as dataNascimentoPaciente,
      cepPac as cepPaciente,
      addressPac  as enderecoPaciente,
      neigthPac as bairroPaciente,
      cityPac as cidadePaciente,
      statePac as estadoPaciente,
      numAddPac as numeroPaciente,
      convPac as convenioPaciente,
      nameConvPac as nameConvPaciente,
      infoCompPac as infoComplementares
    from pacientescli where id = " .  $_POST['identificador'] . " ";
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

$app->post('/pesquisarPacientes', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $query = "SELECT * from pacientescli where namePac like '" . $_POST['inputFilter'] . "%' 
            OR replace(replace(codeCpfPac,'.',''),'-','') like '" . $_POST['inputFilter'] . "%'
            ";
            $result = mysqli_query($conn, $query);


            $arr = array();
            $i = 0;



            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["identificadorPac"] = $linha_result['id'];
                $arr[$i]["countids"] =  $i;
                $arr[$i]["nomePaciente"] = $linha_result['namePac'];
                $arr[$i]["CpfPaciente"] = $linha_result['codeCpfPac'];
                $arr[$i]["isConvenio"] = $linha_result['convPac'];
                $arr[$i]["nomeConvenio"] = $linha_result['nameConvPac'];
                $arr[$i]["dtNascimento"] = date('d/m/Y', strtotime($linha_result['dt_nascPac']));
                $arr[$i]["telPaciente"] = $linha_result['telPac'];
                $arr[$i]["celpaciente"] = $linha_result['celPac'];
                $i++;
            };

            echo  json_encode($arr);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/alterarPaciente', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();


            $jsonObj = json_decode($jsonbruto, true);

            $query = "UPDATE  pacientescli SET namePac =  '" . $jsonObj['namePaciente'] . "', telPac =  '" . $jsonObj['telPaciente'] . "',celPac = '" . $jsonObj['celularPaciente'] . "',
   codeCpfPac =  '" . $jsonObj['CpfPaciente'] . "',codeRGPac = '" . $jsonObj['RgPaciente'] . "',emailPac = '" . $jsonObj['emailPaciente'] . "',dt_nascPac = '" . $jsonObj['dataNasciPaciente'] . "',
   cepPac = '" . $jsonObj['CepPaciente'] . "',addressPac = '" . $jsonObj['EndPaciente'] . "',neigthPac = '" . $jsonObj['BairroPaciente'] . "',cityPac = '" . $jsonObj['cidadePaciente'] . "',
   statePac = '" . $jsonObj['EstadoPaciente'] . "',numAddPac = '" . $jsonObj['NumeroPaciente'] . "',
    convPac = '" . $jsonObj['isConvenio'] . "',nameConvPac = '" . $jsonObj['nomeConvenio'] . "',infoCompPac = '" . $jsonObj['observacaoAgenda'] . "' WHERe id  = " . $jsonObj['identificador'] . "   ";
            $result = mysqli_query($conn, $query);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/deletaPaciente', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $query = "DELETE FROM pacientescli WHERE id =" . $_POST['identificador'] . " ";
            $result = mysqli_query($conn, $query);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->run();
