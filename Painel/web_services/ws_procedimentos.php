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

$app->get('/listProcedimentos', function () use ($app) {
    date_default_timezone_set('America/Sao_Paulo');
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

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
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/gravaProcedimentos', function () use ($app) {
    date_default_timezone_set('America/Sao_Paulo');
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);

            $insert = "INSERT into procedimentos values(null,'" . $jsonObj['descricao'] . "','" . $jsonObj['valP'] . "','" . $jsonObj['valC'] . "') ";
            $result = mysqli_query($conn, $insert);
            echo 'insert';
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/infoProcedimento', function () use ($app) {
    date_default_timezone_set('America/Sao_Paulo');
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');


            $insert = "SELECT * FROM procedimentos where id = " . $_POST['identificadorProced'] . "";
            $result = mysqli_query($conn, $insert);
            $linha_result = mysqli_fetch_assoc($result);
            echo '{
        "descproced":"' . $linha_result['descProcedimento'] . '",
        "valConvenio":"' . $linha_result['valorConv'] . '",
        "valParticular":"' . $linha_result['valorPart'] . '"
    }';
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/alteraProcedimentos', function () use ($app) {
    date_default_timezone_set('America/Sao_Paulo');
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);

            $insert = "UPDATE  procedimentos SET  descProcedimento='" . $jsonObj['descricao'] . "',valorPart='" . $jsonObj['valP'] . "',valorConv='" . $jsonObj['valC'] . "'
    WHERE id = " . $jsonObj['identificadorModal'] . "
     ";
            $result = mysqli_query($conn, $insert);
            echo 'update';
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/deletaProcedimentos', function () use ($app) {
    date_default_timezone_set('America/Sao_Paulo');
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $query = "DELETE FROM procedimentos WHERE id =" . $_POST['identificador'] . " ";
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
