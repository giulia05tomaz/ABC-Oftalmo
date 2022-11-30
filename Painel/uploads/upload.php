<?php
// echo$_FILES['imagem']['name'];
$dir = date('m-Y');

if (is_dir('./imagens/' . $dir)) {
    // echo "O diretório já existe.";
    if (file_exists('./imagens/' . $dir . '/' . $_FILES['inpFile']['name'])) {
        echo 'existe';
    } else {
        move_uploaded_file($_FILES['inpFile']['tmp_name'], './Imagens/' . $dir . '/' . $_FILES['inpFile']['name']);
    }
} else {
    mkdir('./imagens/' . $dir . '/', 0777, true);
    move_uploaded_file($_FILES['inpFile']['tmp_name'], './Imagens/' . $dir . '/' . $_FILES['inpFile']['name']);
}


// $dir = date('m-Y') ;
// extract($_POST);
// $error=array();
// $extension=array("jpeg","jpg","png","gif");
 
// foreach($_FILES["example3"]["tmp_name"] as $key=>$tmp_name) {
//     $file_name=$_FILES["example3"]["name"][$key];
//     $file_tmp=$_FILES["example3"]["tmp_name"][$key];
//     $ext=pathinfo($file_name,PATHINFO_EXTENSION);
 
//     if(in_array($ext,$extension)) {
//         if(!file_exists("imagens/06-2020/".$file_name)) {
//             move_uploaded_file($file_tmp=$_FILES["example3"]["tmp_name"][$key],"imagens/06-2020/".$file_name);
//         }
//         else {
//             $filename=basename($file_name,$ext);
//             $newFileName=$filename.time().".".$ext;
//             move_uploaded_file($file_tmp=$_FILES["example3"]["tmp_name"][$key],"imagens/06-2020/".$newFileName);
//         }
//     }
//     else {
//         array_push($error,"$file_name, ");
//     }
// }