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

$app->get('/listusers', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $query = "SELECT * from users ORDER BY id DESC ";
            $result = mysqli_query($conn, $query);
            $arr = array();
            $i = 0;

            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["identificadorUsers"] = $linha_result['id'];
                $arr[$i]["nomeusuario"] = $linha_result['nameUser'];
                $arr[$i]["emailusuario"] = $linha_result['emaiUser'];
                $arr[$i]["nivelUsuario"] = $linha_result['nvUser'];
                $arr[$i]["nivelUsuario"] = $linha_result['nvUser'];
                $arr[$i]["statusUser"] = $linha_result['status'];
                $i++;
            };

            echo json_encode($arr);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {

        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/gravaUsers', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');
            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $query = "SELECT * from users where emaiUser = '" . $jsonObj['emailUser'] . "' OR userLogin = '" . $jsonObj['nameLogin'] . "'";
            $result = mysqli_query($conn, $query);
            if ($result->num_rows > 0) {
                echo 'userExiste';
            } else {
                $insert = "INSERT into users values(null,'" . $jsonObj['nameLogin'] . "',   MD5('" . $jsonObj['passwordUser'] . "'),'" . $jsonObj['nameUser'] . "',
        '" . $jsonObj['emailUser'] . "','" . $jsonObj['nvUser'] . "'," . $jsonObj['statusUser'] . ",0 ) ";
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
$app->post('/informationUser', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $query = "SELECT * from users where id = " . $_POST['identificador'] . " ";
            $result = mysqli_query($conn, $query);

            $linha_result = mysqli_fetch_assoc($result);
            if ($result->num_rows > 0) {
                echo '{
            "loginUser":"' . $linha_result['userLogin'] . '",
            "nameUser":"' . $linha_result['nameUser'] . '",
            "emailUser":"' . $linha_result['emaiUser'] . '",
            "statusUser":"' . $linha_result['status'] . '",
               "nvUser":"' . $linha_result['nvUser'] . '"
        }';
            } else {
                $insert = "INSERT into users values(null,'" . $jsonObj['nameLogin'] . "',   MD5('" . $jsonObj['passwordUser'] . "'),'" . $jsonObj['nameUser'] . "',
        '" . $jsonObj['emailUser'] . "','" . $jsonObj['nvUser'] . "'," . $jsonObj['statusUser'] . ",0 ) ";
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
$app->post('/alteraUsers', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $jsonbruto = $app->request()->getBody();

            $jsonObj = json_decode($jsonbruto, true);
            $loginUser = $jsonObj['nameLogin'];
            $nameUser = $jsonObj['nameUser'];
            $passwordUser = isset($jsonObj['passwordUser']);
            $emailUser = $jsonObj['emailUser'];
            $nvUser = $jsonObj['nvUser'];
            $statusUser = $jsonObj['statusUser'];
            $identificador = $jsonObj['identificador'];
            $passwordValid = $passwordUser ? ",passwordUser = MD5('" . $jsonObj['passwordUser'] . "')" : '';

            $_SESSION['nvAcesso'] =  $nvUser;
            $_SESSION['email'] =  $emailUser;
            $_SESSION['nomeUsuario'] = $nameUser;


            $insert = "UPDATE users set userLogin = '" . $loginUser . "',nameUser = '" . $nameUser . "' ,emaiUser = '" . $emailUser . "' ,
    nvUser = '" . $nvUser . "',`status` = " . $statusUser . " $passwordValid where id = $identificador ";
            $result = mysqli_query($conn, $insert);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});

$app->post('/deletaUsuarios', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $query = "DELETE FROM users WHERE id =" . $_POST['identificador'] . " ";
            $result = mysqli_query($conn, $query);
        } else {
            $app->halt(401, '{"Message":"Sem acesso"}');
        }
    } else {
        echo 'Sem acesso';
        $app->halt(401, '{"Message":"Sem acesso"}');
    }
});
$app->post('/desbloqueioUser', function () use ($app) {
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $Email =   $_SESSION['email'];
        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] == $token_padrao) {
            $conn = include('../includes/conexao.php');

            $query = "UPDATE users SET qdTentativas = '0' WHERE id =" . $_POST['identificador'] . " ";
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
