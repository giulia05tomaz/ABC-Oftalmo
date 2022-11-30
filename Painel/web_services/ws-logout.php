<?php

header('Content-type: text/html; charset=utf-8; application/json');
ini_set('default_charset', 'UTF-8');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require './Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//Post de Autenticação

$app->post('/logout(/)', function () use ($app) {

    session_unset();
});



$app->run();
