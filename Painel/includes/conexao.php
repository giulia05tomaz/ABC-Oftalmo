<?php
$servidor = "localhost";
$usuario = "root";
$pass = '';
$dbname = "abc_oftalmo";
$conn = mysqli_connect($servidor, $usuario, $pass, $dbname);
$conn->set_charset("utf8");

// $servidor = "162.241.203.142";
// $usuario = "abcoft32_Abc_oftalmo127";
// $pass = '-u&S-wEy^.]}Abc_oftalmo';
// $dbname = "abcoft32_abc_oftalmo";
// $conn = mysqli_connect($servidor, $usuario, $pass, $dbname);
// $conn->set_charset("utf8");
if (!$conn) {
  die("Falha na conexao: " . mysqli_connect_error());
} else {
  date_default_timezone_set('America/Sao_Paulo');
  return $conn;
  //echo "Conexao realizada com sucesso";
}
