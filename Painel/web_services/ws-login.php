<?php

header('Content-type: text/html; charset=utf-8; application/json');
ini_set('default_charset', 'UTF-8');

session_start();
date_default_timezone_set('America/Sao_Paulo');

require './Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Post de Autenticação

$app->post('/authenticate(/)', function () use ($app) {
	$conn = include('../includes/conexao.php');

	$login = htmlspecialchars($_POST['userLogin'], ENT_HTML5, 'UTF-8');
	$senha =  htmlspecialchars($_POST['senhaLogin'], ENT_HTML5, 'UTF-8');

	$query = "SELECT * from users where ( emaiUser= '$login' or userLogin = '$login') and passwordUser = MD5('$senha') and `status` = '1'";
	// $query = "SELECT AES_DECRYPT(AES_DECRYPT(us.Login, '$senhaMaster'), SHA2(us.id2,512)) as login, AES_DECRYPT(AES_DECRYPT(hiSenha.senha, '$senhaMaster'), SHA2(hiSenha.id2,512)) as senha, AES_DECRYPT(AES_DECRYPT(us.perfil, '$senhaMaster'), SHA2(us.id2,512)) as perfil from usuario as us , historicoSenha as hiSenha";

	$result = mysqli_query($conn, $query);
	$resultSelect = mysqli_fetch_assoc($result);
	$row_cnt = $result->num_rows;

	if ($row_cnt > 0) {

		$_SESSION['nvAcesso'] = $resultSelect['nvUser'];
		$_SESSION['email'] = $resultSelect['emaiUser'];
		$_SESSION['nomeUsuario'] = $resultSelect['nameUser'];

		$_SESSION['token'] = MD5(MD5('abcoftalmo') . $resultSelect['emaiUser'] . date("dmy"));

		// echo "<script>window.location = './inicio.php'</script>";
		echo '1';
	} else {

		$selQtenta = "SELECT `qdTentativas` as qtTenta,`status`   FROM users  where emaiUser= '$login' or userLogin = '$login' ";



		$result = mysqli_query($conn, $selQtenta);
		$linhaResult = mysqli_fetch_assoc($result);

		if ($linhaResult['status'] == '2') {
			echo '6';
			return;
		}

		$qdTentativas = $linhaResult['qtTenta'] + 1;
		// echo  $qdTentativas;
		if ($qdTentativas >= 5) {
			echo "4";
			return;
		}
		$queryBlock = "UPDATE users set qdTentativas = $qdTentativas
		 where emaiUser= '$login' or userLogin = '$login'";
		$result = mysqli_query($conn, $queryBlock);
		echo "5";
	}
});

$app->post('/recoverPass(/)', function () use ($app) {


	date_default_timezone_set('America/Sao_Paulo');

	// conexao DB online
	$conn = include('../includes/conexao.php');

	date_default_timezone_set('America/Sao_Paulo');

	require_once('./PHPMailer/PHPMailer.php');
	require_once('./PHPMailer/SMTP.php');
	require_once('./PHPMailer/Exception.php');
	$mail = new PHPMailer(true);

	$email = $_POST['email'];

	$query = "SELECT * FROM users WHERE emaiUser = '$email'";
	$result = mysqli_query($conn, $query);
	$row_cnt = $result->num_rows;

	if ($row_cnt > 0) {
		//Essa função gera um valor de String aleatório do tamanho recebendo por parametros
		function randString($size)
		{
			//String com valor possíveis do resultado, os caracteres pode ser adicionado ou retirados conforme sua necessidade
			$basic = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXWYZ0123456789!@#&)([]}{';

			$return = "";

			for ($count = 0; $size > $count; $count++) {
				//Gera um caracter aleatorio
				$return .= $basic[rand(0, strlen($basic) - 1)];
			}

			return $return;
		}

		//Seta o valor da variavel $codigo como uma String randônica com 8 caracteres
		$codigo = randString(15);

		// Função que envia o email
		try {

			// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->isSMTP();
			$mail->Mailer = "smtp";
			$mail->Host = 'abcoftalmo.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'no-reply@abcoftalmo.com';
			$mail->Password = 'hJEVXW1wf@,;';
			$mail->Port = 465;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

			$mail->CharSet = 'UTF-8';
			$mail->setFrom('no-reply@abcoftalmo.com');
			$mail->addAddress($email);
			// $mail->addAddress('raonivp@yahoo.com.br');

			$mail->isHTML(true);
			$mail->Subject = 'Nova senha - Painel ABC Oftalmo';
			$mail->Body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;font-family:lato, helvetica neue, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
					 <head> 
					  <meta charset="UTF-8"> 
					  <meta content="width=device-width, initial-scale=1" name="viewport"> 
					  <meta name="x-apple-disable-message-reformatting"> 
					  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
					  <meta content="telephone=no" name="format-detection"> 
					  <title>Novo modelo de e-mail 2021-02-02</title> 
					  <!--[if (mso 16)]>
						<style type="text/css">
						a {text-decoration: none;}
						</style>
						<![endif]--> 
					  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
					  <!--[if gte mso 9]>
					<xml>
						<o:OfficeDocumentSettings>
						<o:AllowPNG></o:AllowPNG>
						<o:PixelsPerInch>96</o:PixelsPerInch>
						</o:OfficeDocumentSettings>
					</xml>
					<![endif]--> 
					  <!--[if !mso]><!-- --> 
					  <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet"> 
					  <!--<![endif]--> 
					  <style type="text/css">
					#outlook a {
						padding:0;
					}
					.ExternalClass {
						width:100%;
					}
					.ExternalClass,
					.ExternalClass p,
					.ExternalClass span,
					.ExternalClass font,
					.ExternalClass td,
					.ExternalClass div {
						line-height:100%;
					}
					.es-button {
						mso-style-priority:100!important;
						text-decoration:none!important;
					}
					a[x-apple-data-detectors] {
						color:inherit!important;
						text-decoration:none!important;
						font-size:inherit!important;
						font-family:inherit!important;
						font-weight:inherit!important;
						line-height:inherit!important;
					}
					.es-desk-hidden {
						display:none;
						float:left;
						overflow:hidden;
						width:0;
						max-height:0;
						line-height:0;
						mso-hide:all;
					}
					@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } a.es-button, button.es-button { font-size:20px!important; display:block!important; border-width:15px 25px 15px 25px!important } }
					</style> 
					 </head> 
					 <body style="width:100%;font-family:lato, helvetica neue, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"> 
					  <div class="es-wrapper-color" style="background-color:#F4F4F4"> 
					   <!--[if gte mso 9]>
								<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
									<v:fill type="tile" color="#f4f4f4"></v:fill>
								</v:background>
							<![endif]--> 
					   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top"> 
						 <tr class="gmail-fix" height="0" style="border-collapse:collapse"> 
						  <td style="padding:0;Margin:0"> 
						   <table cellspacing="0" cellpadding="0" border="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:600px"> 
							 <tr style="border-collapse:collapse"> 
							  <td cellpadding="0" cellspacing="0" border="0" style="padding:0;Margin:0;line-height:1px;min-width:600px" height="0"><img src="https://esputnik.com/repository/applications/images/blank.gif" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;max-height:0px;min-height:0px;min-width:600px;width:600px" alt width="600" height="1"></td> 
							 </tr> 
						   </table></td> 
						 </tr> 
						 <tr style="border-collapse:collapse"> 
						  <td valign="top" style="padding:0;Margin:0"> 
						   <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:#7C72DC;background-repeat:repeat;background-position:center top"> 
							 <tr style="border-collapse:collapse"> 
							  <td style="padding:0;Margin:0;background-color:#233666" bgcolor="#233666" align="center"> 
							   <table class="es-header-body" cellspacing="0" cellpadding="0" align="center" bgcolor="#233666" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#233666;width:600px"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:580px"> 
									   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
										 <tr style="border-collapse:collapse"> 
										  <td align="center" style="padding:0;Margin:0;padding-left:10px;padding-right:10px;font-size:0px"><img src="https://abcoftalmo.com/Painel/imagens/Logo.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" class="adapt-img" width="400"></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table> 
						   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
							 <tr style="border-collapse:collapse"> 
							  <td style="padding:0;Margin:0;background-color:#233666" bgcolor="#233666" align="center"> 
							   <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="padding:0;Margin:0"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
									   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#FFFFFF;border-radius:4px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation"> 
										 <tr style="border-collapse:collapse"> 
										  <td align="center" style="Margin:0;padding-bottom:5px;padding-left:30px;padding-right:30px;padding-top:35px"><h1 style="Margin:0;line-height:58px;mso-line-height-rule:exactly;font-family:lato, helvetica neue, helvetica, arial, sans-serif;font-size:48px;font-style:normal;font-weight:normal;color:#111111">Painel ABC Oftalmo</h1></td> 
										 </tr> 
										 <tr style="border-collapse:collapse"> 
										  <td bgcolor="#ffffff" align="center" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px;font-size:0"> 
										   <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
											 <tr style="border-collapse:collapse"> 
											  <td style="padding:0;Margin:0;border-bottom:1px solid #FFFFFF;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td> 
											 </tr> 
										   </table></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table> 
						   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
							 <tr style="border-collapse:collapse"> 
							  <td align="center" style="padding:0;Margin:0"> 
							   <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="padding:0;Margin:0"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
									   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation"> 
										 <tr style="border-collapse:collapse"> 
										  <td class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-bottom:15px;padding-top:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:lato, helvetica neue, helvetica, arial, sans-serif;line-height:27px;color:#666666">Atenção.<br><br>Sua senha foi redefinida, abaixo está sua nova senha:</p></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="padding:0;Margin:0;padding-bottom:20px;padding-left:30px;padding-right:30px"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:540px"> 
									   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
										 <tr style="border-collapse:collapse"> 
										  <td align="center" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:40px;padding-bottom:40px">
										  <span class="es-button-border" style="border-style:solid;border-color:#233666;background:#233666;border-width:1px;display:inline-block;border-radius:2px;width:auto">
										  <a  class="es-button" target="_blank" style="mso-style-priority:100 !important;;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;font-size:20px;color:#FFFFFF;border-style:solid;border-color:#233666;border-width:15px 25px 15px 25px;display:inline-block;background:#233666;border-radius:2px;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center">
										 <span style="color: white">
										  ' . $codigo . '
										  </span>
										  </a>
										  </span></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table> 
						   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
							 <tr style="border-collapse:collapse"> 
							  <td align="center" style="padding:0;Margin:0"> 
							   <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="padding:0;Margin:0"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
									   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:4px" width="100%" cellspacing="0" cellpadding="0" role="presentation"> 
										 <tr style="border-collapse:collapse"> 
										  <td class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-bottom:15px;padding-top:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:lato, helvetica neue, helvetica, arial, sans-serif;line-height:27px;color:#666666">Atenciosamente.<br><br>Equipe ABC Oftalmo!</p></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table> 
						   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
							 <tr style="border-collapse:collapse"> 
							  <td align="center" style="padding:0;Margin:0"> 
							   <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="padding:0;Margin:0"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
									   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
										 <tr style="border-collapse:collapse"> 
										  <td align="center" style="Margin:0;padding-top:10px;padding-bottom:20px;padding-left:20px;padding-right:20px;font-size:0"> 
										   <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
											 <tr style="border-collapse:collapse"> 
											  <td style="padding:0;Margin:0;border-bottom:1px solid #F4F4F4;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td> 
											 </tr> 
										   </table></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table> 
						   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
							 <tr style="border-collapse:collapse"> 
							  <td align="center" style="padding:0;Margin:0"> 
							   <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#C6C2ED;width:600px" cellspacing="0" cellpadding="0" bgcolor="#c6c2ed" align="center"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="padding:0;Margin:0"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
									   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:4px" width="100%" cellspacing="0" cellpadding="0"> 
										 <tr style="border-collapse:collapse"> 
										  <td align="center" style="padding:0;Margin:0;display:none"></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table> 
						   <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"> 
							 <tr style="border-collapse:collapse"> 
							  <td align="center" style="padding:0;Margin:0"> 
							   <table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="Margin:0;padding-top:30px;padding-bottom:30px;padding-left:30px;padding-right:30px"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:540px"> 
									   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
										 <tr style="border-collapse:collapse"> 
										  <td align="center" style="padding:0;Margin:0;display:none"></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table> 
						   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
							 <tr style="border-collapse:collapse"> 
							  <td align="center" style="padding:0;Margin:0"> 
							   <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center"> 
								 <tr style="border-collapse:collapse"> 
								  <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px"> 
								   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
									 <tr style="border-collapse:collapse"> 
									  <td valign="top" align="center" style="padding:0;Margin:0;width:560px"> 
									   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
										 <tr style="border-collapse:collapse"> 
										  <td align="center" style="padding:0;Margin:0;display:none"></td> 
										 </tr> 
									   </table></td> 
									 </tr> 
								   </table></td> 
								 </tr> 
							   </table></td> 
							 </tr> 
						   </table></td> 
						 </tr> 
					   </table> 
					  </div>  
					 </body>
					</html>';
			$mail->AltBody = 'Código para alteração de senha ' . $codigo . '.';

			if ($mail->send()) {


				$query = "UPDATE `users` SET `passwordUser`= md5('$codigo') WHERE emaiUser = '$email'";
				$result = mysqli_query($conn, $query);

				// echo $query;
				echo 'Email enviado com sucesso';
			} else {
				echo 'Email nao enviado';
			}
		} catch (Exception $e) {
			echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
		}
	} else {
		echo 'Email não existe';
	}
});



$app->run();
