<?php
header('Content-type: text/html; charset=utf-8; application/json');

session_start();

require '../web_services/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//Post de Autenticação
$app->post('/authenticate(/)', function () use ($app) {

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $token = MD5(MD5('quaestum') . $jsonObj['email'] . date("dmy"));


    // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";


    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    // Estabeleça o fuso horário
    date_default_timezone_set('America/Sao_Paulo');

    //query de login
    $query = "SELECT * from users where email='" . $jsonObj['email'] . "' and senha = md5('" . $jsonObj['senha'] . "');";
    //Captura o Resultado
    $result = mysqli_query($conn, $query);
    //Conta as linhas que retornaram
    $row_cnt = $result->num_rows;


    $query2 = 'SELECT email,senha FROM `users` ;';
    //Captura o Resultado
    $result2 = mysqli_query($conn, $query2);

    $arr2 = array();
    $i = 0;




    while ($consulta_result = mysqli_fetch_assoc($result2)) {
        $arr2[$i]["email"] = $consulta_result['email'];
        $arr2[$i]["senha"] = $consulta_result['senha'];
        $i++;
    }


    if ($row_cnt > 0) {
        //Retorna status
        echo '{
            "autenticacao": 1,
            "token":"' . $token . '",
            "resultOff":' . json_encode($arr2) . '
        }';
    } else {
        //Retorna status
        echo '{
            "autenticacao": 0
        }';
    }
});


//Post de Autenticação
$app->get('/listaMotoristas(/)', function () use ($app) {

    // // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    //query de login
    $query = 'SELECT id, nome, cnh, validade_cnh, funcao, cpf,rg, url_foto FROM `funcionarios`  ORDER BY `nome` ASC';
    //Captura o Resultado
    $result = mysqli_query($conn, $query);

    //Conta as linhas que retornaram
    $row_cnt = $result->num_rows;
    $arr = array();
    $i = 0;

    function data($data)
    {
        return date("d/m/Y", strtotime($data));
    }

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {

            $arr[$i]["id"] = $consulta_result['id'];
            $arr[$i]["nome"] = is_null($consulta_result['nome']) ? 'Sem nome' : $consulta_result['nome'];
            $arr[$i]["cnh"] = is_null($consulta_result['cnh']) ? 'Sem nome' : $consulta_result['cnh'];
            $arr[$i]["validade_cnh"] = is_null($consulta_result['cnh']) ? '10/10/1900' : data($consulta_result['validade_cnh']);
            $arr[$i]["funcao"] = is_null($consulta_result['funcao']) ? 'na' : $consulta_result['funcao'];
            $arr[$i]["cpf"] = is_null($consulta_result['cpf']) ? 'Sem cpf' : $consulta_result['cpf'];
            $arr[$i]["rg"] = is_null($consulta_result['rg']) ? 'Sem rg' : $consulta_result['rg'];
            $arr[$i]["foto"] =  is_null($consulta_result['url_foto']) ? 'na' : $consulta_result['url_foto'];
            $i++;
        }
        // echo json_encode($arr);
    }


    $query = 'SELECT id, nome FROM `motoristas`  ORDER BY `nome` ASC';
    //Captura o Resultado
    $result = mysqli_query($conn, $query);

    //Conta as linhas que retornaram
    $row_cnt = $result->num_rows;
    $arr2 = array();
    $i = 0;



    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr2[$i]["id"] = $consulta_result['id'];
            $arr2[$i]["nome"] = $consulta_result['nome'];
            $i++;
        }
    }
    $dataJson = '{
        "array1":' . json_encode($arr) . ',   
        "array2":' . json_encode($arr2) . ' 
       }';
    echo $dataJson;
});

$app->get('/listarPlacas(/)', function () use ($app) {

    // // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    //query de login
    $query = 'SELECT id, placa FROM `veiculos`  ORDER BY `placa` ASC';
    //Captura o Resultado
    $result = mysqli_query($conn, $query);

    //Conta as linhas que retornaram
    $row_cnt = $result->num_rows;
    $arr = array();
    $i = 0;


    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {

            $arr[$i]["placa"] = $consulta_result['placa'];
            $arr[$i]["id"] = $consulta_result['id'];

            $i++;
        }
        echo json_encode($arr);
    }
});
//salva dados do checklist
$app->post('/SaveChecklist(/)', function () use ($app) {

    // // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");
    date_default_timezone_set('America/Sao_Paulo');
    // echo 'asd';
    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $dadosJson = $jsonObj['jsonDadosEnv'];
    $AssinaturaFis = $jsonObj['assinaturaFiscal'];
    $AssinaturaMot = $jsonObj['assinaturaMot'];
    $email = $jsonObj['email'];
    $placa = $jsonObj['placaVeic'];
    $cpfMot = $jsonObj['cpfMot'];
    $polo = '';
    $justificativa = '';
    $nmSubstituido = '';
    $turno = '';
    $dataPlantao = '';
    $jsonCerto = json_decode($dadosJson, true);
    $tpMovimentacao = $jsonCerto[0]['Movimentacao'];

    if ($jsonCerto[0]['Jornada'] == "Plantão Avulso") {

        $polo = $jsonCerto[0]['Polo'];
        $justificativa = $jsonCerto[0]['Justificativa'];
        $nmSubstituido = $jsonCerto[0]['NomeSubstituido'];
        $turno = $jsonCerto[0]['Turno'];
        $dataPlantao = $jsonCerto[0]['DataPlantao'];

        $selecetExiste = "SELECT * FROM `dobras`
        where nome ='$AssinaturaMot' 
        and cpf = '$cpfMot'
        and `data` = '$dataPlantao'
        and user_email = '$email'
        and justificativa = '$justificativa'
        and polo = '$polo'
        ";
        $result = mysqli_query($conn, $selecetExiste);
        if ($result->num_rows > 0) {
        } else {
            $querya = 'INSERT INTO `dobras` (`nome`, `cpf`, `data`, `user_email`, `data_log`, `turno_dobrado`, `polo`, `justificativa`) 
    VALUES ("' . $AssinaturaMot . '", "' . $cpfMot . '", "' . $dataPlantao . '", "' . $email . '", current_timestamp(), "' . $turno . '", "' . $polo . '", "' . $justificativa . '");';
            $result = mysqli_query($conn, $querya);
        }
    }

    if ($jsonCerto[0]['Substituicao'] == true) {
        $selecetExiste = "SELECT * FROM substituicao WHERE momento_substituicao = current_timestamp()
        AND nome_substituido = '$nmSubstituido'
        AND cpf_substituto = '$cpfMot'
        AND email_usuário = '$email'
        AND cpf_substituido  = (SELECT cpf FROM `motoristas` where nome = '$nmSubstituido')
        ";
        $result = mysqli_query($conn, $selecetExiste);
        if ($result->num_rows > 0) {
        } else {
            $queryb = "INSERT INTO `substituicao` (`id`, `nome_substituido`, `cpf_substituido`, `nome_substituto`, `cpf_substituto`, `polo`, `turno_substituido`, `dia_da_falta`, `email_usuário`, `justificativa`, `momento_substituicao`) 
VALUES (NULL, '" . $nmSubstituido . "', (SELECT cpf FROM `motoristas` where nome = '$nmSubstituido' ), '" . $AssinaturaMot . "', '" . $cpfMot . "', '" . $polo . "', '" . $turno . "', '" . $dataPlantao . "', '" . $email . "', '" . $justificativa . "', current_timestamp());";
            $result = mysqli_query($conn, $queryb);
        }
    }

    $query = "INSERT INTO `check_list` (`id`, `email_usuario`, `check_list`,`tpMovimentacao`,`placaVeic`,`cpfMot`,`nomeMot`, `assinatura_motorista`, `assinatura_fiscal`, `data`,`hr_registro`,`flag`) 
    VALUES(null,'$email'," . json_encode($dadosJson) . ",'$tpMovimentacao','$placa','$cpfMot','$AssinaturaMot','$AssinaturaMot','$AssinaturaFis',CURDATE(),CURTIME(),0);";
    // echo $query;
    $result = mysqli_query($conn, $query);
    if ($result  > 0) {
        echo 'Enviado';
    } else {
        echo 'N Enviado';
    }
    // echo $result;
});

$app->post('/enviaFotos(/)', function () use ($app) {


    $dir = date('m-Y');
    // $dir = '07-2020';
    extract($_POST);
    $error = array();
    $extension = array("jpeg", "jpg", "png", "gif");

    foreach ($_FILES["image"]["tmp_name"] as $key => $tmpName) {

        $file_name = $_FILES["image"]["name"][$key];

        // $ext=pathinfo($file_name,PATHINFO_EXTENSION);


        if (is_dir('./Imagens/' . $dir)) {
            // echo "O diretório já existe.";

            if (!file_exists('./Imagens/' . $dir . '/' . $file_name)) {
                move_uploaded_file($file_tmp = $_FILES["image"]["tmp_name"][$key], './Imagens/' . $dir . '/' . $file_name = $_FILES["image"]["name"][$key]);
                echo ' Enviado ';
            } else {

                echo ' Foto já existe ';
            }
        } else {
            mkdir('./Imagens/' . $dir . '/', 0777, true);
            move_uploaded_file($_FILES['image']['tmp_name'][$key], './Imagens/' . $dir . '/' . $_FILES['image']['name'][$key]);
            echo ' dir ';
        }
    }
});

$app->post('/copyCheck(/)', function () use ($app) {

    // // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");
    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $Placa = $jsonObj['Placa'];

    //query de login
    $query = "SELECT  *  FROM `check_list` where placaVeic = '$Placa'
    AND tpMovimentacao  = 'Retorno'
    ORDER BY `id` DESC limit 1";

    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        $linharesult = mysqli_fetch_assoc($result);
        echo json_encode($linharesult);
    } else {
        echo 'vazio';
    }
});

$app->post('/historicoCheck(/)', function () use ($app) {

    // // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");
    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $Placa = $jsonObj['placa'];

    //query de login
    $query = "SELECT id, check_list, placaVeic, DATE_FORMAT(`data`,'%d/%m/%Y')as data, hr_registro, nomeMot, cpfMot,email_usuario FROM `check_list`
    where placaVeic = '$Placa' 
    and check_list like '%\"Avarias\":[{\"%'
    ORDER BY `check_list`.`id`  DESC";

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;
    $arr = array();
    $i = 0;


    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["id"] = $consulta_result['id'];
            $arr[$i]["check_list"] = json_decode($consulta_result['check_list']);
            $arr[$i]["placaVeic"] = $consulta_result['placaVeic'];
            $arr[$i]["data"] = $consulta_result['data'];
            $arr[$i]["hr_registro"] = $consulta_result['hr_registro'];
            $arr[$i]["nomeMot"] = $consulta_result['nomeMot'];
            $arr[$i]["cpfMot"] = $consulta_result['cpfMot'];
            $arr[$i]["email_suario"] = $consulta_result['email_usuario'];

            $i++;
        }
        echo json_encode($arr);
    } else {
        echo 'sem Registro';
    }
});

$app->post('/listarChecklistsPendentes(/)', function () use ($app) {

    // // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");
    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $email = $jsonObj['email'];

    //query de login
    $query = "SELECT * FROM `check_list`
    where email_usuario = '$email' 
    and flag = 1
    ORDER BY `id`  DESC";

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;
    $arr = array();
    $i = 0;

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["id"] = $consulta_result['id'];
            $arr[$i]["checklist"] = json_decode($consulta_result['check_list']);
            $arr[$i]["placaVeic"] = $consulta_result['placaVeic'];
            $arr[$i]["data"] = $consulta_result['data'];
            $arr[$i]["hr_registro"] = $consulta_result['hr_registro'];
            $arr[$i]["nomeMot"] = $consulta_result['nomeMot'];
            $arr[$i]["cpfMot"] = $consulta_result['cpfMot'];
            $arr[$i]["email_suario"] = $consulta_result['email_usuario'];
            $arr[$i]["flag"] = 1;

            $i++;
        }
        echo json_encode($arr);
    } else {
        echo 'vazio';
    }
});

$app->post('/updateChecklistPendentes(/)', function () use ($app) {

    // // conexao DB online
    $servidor = "34.95.231.113";
    $usuario = "root";
    $senha = 'abc123**';
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");
    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $email = $jsonObj['email'];


    $dadosJson = $jsonObj['jsonDadosEnv'];
    $AssinaturaFis = $jsonObj['assinaturaFiscal'];
    $AssinaturaMot = $jsonObj['assinaturaMot'];
    $email = $jsonObj['email'];
    $placa = $jsonObj['placaVeic'];
    $cpfMot = $jsonObj['cpfMot'];
    $idchecklist = $jsonObj['idChecklist'];


    //   echo $query;CURDATE(),CURTIME()
    $update = "UPDATE checklit set email_usuario = '$email',check_list = " . json_encode($dadosJson) . ",placaVeic = '$placa',data =CURDATE() , hr_registro = CURTIME(), cpfMot = '$cpfMot',assinatura_motorista = '$AssinaturaMot',assinatura_fiscal = '$AssinaturaFis', flag = 0 where id = $idchecklist";
    $result = mysqli_query($conn, $update);
});

$app->post('/uploadImageNew(/)', function () use ($app) {

    // // conexao DB online

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $foto = $jsonObj['image'];
    $name_foto = $jsonObj['name_foto'];

    $dir = date('m-Y');

    if (is_dir('./Imagens/' . $dir)) {
        // echo "O diretório já existe.";

        if (!file_exists('./Imagens/' . $dir . '/' . $name_foto)) {
            define('UPLOAD_DIR', 'Imagens/' . $dir . '/' . $name_foto);
            $image_parts = explode(";base64,", $foto);
            $image_base64 = base64_decode($image_parts[1]);
            $file = UPLOAD_DIR;
            file_put_contents($file, $image_base64);
            echo 'Enviado';
        } else {

            echo 'Foto já existe';
        }
    } else {
        mkdir('./Imagens/' . $dir, 0777, true);
        define('UPLOAD_DIR', 'Imagens/' . $dir . '/' . $name_foto);
        $image_parts = explode(";base64,", $foto);
        $image_base64 = base64_decode($image_parts[1]);
        $file = UPLOAD_DIR;
        file_put_contents($file, $image_base64);
        echo 'dir';
    }
});
$app->run();
