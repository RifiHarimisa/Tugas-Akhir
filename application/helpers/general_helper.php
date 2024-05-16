<?php

function dd($data){
	var_dump($data); 
	die;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// function render($view, $data = []){
// 	$CI = &get_instance();
// 	$data['content'] = $view;
// 	$CI->load->view('layouts/base_admin', $data);
// }

function render($view, $data = []){
	$CI = &get_instance();
	$data['content'] = $view;
	if ($CI->session->userdata('role') == 'Admin')
	{
		$CI->load->view('layouts/base_admin', $data);
	}
	else if($CI->session->userdata('role') == 'User')
	{
		$CI->load->view('layouts/base_user', $data);
	}
	else if($CI->session->userdata('role') == 'Divisi' OR $CI->session->userdata('role') == 'Perusahaan')
	{
		$CI->load->view('layouts/base_divisi', $data);
	}
}


function asset($files='')
{
	return base_url().'mods/'.$files;
}

function mark_down($title = false,$link = false)
{
	if ($title != false or $link != false)
	{

		$my_html = "[".$title."](".$link.")";
		// $my_html = MarkdownExtra::defaultTransform('['.$title.']('.$link.')');
		return $my_html;
	}
}


function sendMessage($isi_email=false,$penerima = false)
{
	if ($isi_email != false and $penerima != false)
	{
		

		$mail = new PHPMailer(true);
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'mail.e-loker.my.id';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'admin@e-loker.my.id';                     //SMTP username
		$mail->Password   = 'Google@12345';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		$view = '
			<!doctype html>
				<html lang="en">
				  <head>
				    <meta name="viewport" content="width=device-width, initial-scale=1.0">
				    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				    <title>Simple Transactional Email</title>
				    <style media="all" type="text/css">
				    /* -------------------------------------
				    GLOBAL RESETS
				------------------------------------- */
				    
				    body {
				      font-family: Helvetica, sans-serif;
				      -webkit-font-smoothing: antialiased;
				      font-size: 16px;
				      line-height: 1.3;
				      -ms-text-size-adjust: 100%;
				      -webkit-text-size-adjust: 100%;
				    }
				    
				    table {
				      border-collapse: separate;
				      mso-table-lspace: 0pt;
				      mso-table-rspace: 0pt;
				      width: 100%;
				    }
				    
				    table td {
				      font-family: Helvetica, sans-serif;
				      font-size: 16px;
				      vertical-align: top;
				    }
				    /* -------------------------------------
				    BODY & CONTAINER
				------------------------------------- */
				    
				    body {
				      background-color: #f4f5f6;
				      margin: 0;
				      padding: 0;
				    }
				    
				    .body {
				      background-color: #f4f5f6;
				      width: 100%;
				    }
				    
				    .container {
				      margin: 0 auto !important;
				      max-width: 600px;
				      padding: 0;
				      padding-top: 24px;
				      width: 600px;
				    }
				    
				    .content {
				      box-sizing: border-box;
				      display: block;
				      margin: 0 auto;
				      max-width: 600px;
				      padding: 0;
				    }
				    /* -------------------------------------
				    HEADER, FOOTER, MAIN
				------------------------------------- */
				    
				    .main {
				      background: #ffffff;
				      border: 1px solid #eaebed;
				      border-radius: 16px;
				      width: 100%;
				    }
				    
				    .wrapper {
				      box-sizing: border-box;
				      padding: 24px;
				    }
				    
				    .footer {
				      clear: both;
				      padding-top: 24px;
				      text-align: center;
				      width: 100%;
				    }
				    
				    .footer td,
				    .footer p,
				    .footer span,
				    .footer a {
				      color: #9a9ea6;
				      font-size: 16px;
				      text-align: center;
				    }
				    /* -------------------------------------
				    TYPOGRAPHY
				------------------------------------- */
				    
				    p {
				      font-family: Helvetica, sans-serif;
				      font-size: 16px;
				      font-weight: normal;
				      margin: 0;
				      margin-bottom: 16px;
				    }
				    
				    a {
				      color: #0867ec;
				      text-decoration: underline;
				    }
				    /* -------------------------------------
				    BUTTONS
				------------------------------------- */
				    
				    .btn {
				      box-sizing: border-box;
				      min-width: 100% !important;
				      width: 100%;
				    }
				    
				    .btn > tbody > tr > td {
				      padding-bottom: 16px;
				    }
				    
				    .btn table {
				      width: auto;
				    }
				    
				    .btn table td {
				      background-color: #ffffff;
				      border-radius: 4px;
				      text-align: center;
				    }
				    
				    .btn a {
				      background-color: #ffffff;
				      border: solid 2px #0867ec;
				      border-radius: 4px;
				      box-sizing: border-box;
				      color: #0867ec;
				      cursor: pointer;
				      display: inline-block;
				      font-size: 16px;
				      font-weight: bold;
				      margin: 0;
				      padding: 12px 24px;
				      text-decoration: none;
				      text-transform: capitalize;
				    }
				    
				    .btn-primary table td {
				      background-color: #0867ec;
				    }
				    
				    .btn-primary a {
				      background-color: #0867ec;
				      border-color: #0867ec;
				      color: #ffffff;
				    }
				    
				    @media all {
				      .btn-primary table td:hover {
				        background-color: #ec0867 !important;
				      }
				      .btn-primary a:hover {
				        background-color: #ec0867 !important;
				        border-color: #ec0867 !important;
				      }
				    }
				    
				    /* -------------------------------------
				    OTHER STYLES THAT MIGHT BE USEFUL
				------------------------------------- */
				    
				    .last {
				      margin-bottom: 0;
				    }
				    
				    .first {
				      margin-top: 0;
				    }
				    
				    .align-center {
				      text-align: center;
				    }
				    
				    .align-right {
				      text-align: right;
				    }
				    
				    .align-left {
				      text-align: left;
				    }
				    
				    .text-link {
				      color: #0867ec !important;
				      text-decoration: underline !important;
				    }
				    
				    .clear {
				      clear: both;
				    }
				    
				    .mt0 {
				      margin-top: 0;
				    }
				    
				    .mb0 {
				      margin-bottom: 0;
				    }
				    
				    .preheader {
				      color: transparent;
				      display: none;
				      height: 0;
				      max-height: 0;
				      max-width: 0;
				      opacity: 0;
				      overflow: hidden;
				      mso-hide: all;
				      visibility: hidden;
				      width: 0;
				    }
				    
				    .powered-by a {
				      text-decoration: none;
				    }
				    
				    /* -------------------------------------
				    RESPONSIVE AND MOBILE FRIENDLY STYLES
				------------------------------------- */
				    
				    @media only screen and (max-width: 640px) {
				      .main p,
				      .main td,
				      .main span {
				        font-size: 16px !important;
				      }
				      .wrapper {
				        padding: 8px !important;
				      }
				      .content {
				        padding: 0 !important;
				      }
				      .container {
				        padding: 0 !important;
				        padding-top: 8px !important;
				        width: 100% !important;
				      }
				      .main {
				        border-left-width: 0 !important;
				        border-radius: 0 !important;
				        border-right-width: 0 !important;
				      }
				      .btn table {
				        max-width: 100% !important;
				        width: 100% !important;
				      }
				      .btn a {
				        font-size: 16px !important;
				        max-width: 100% !important;
				        width: 100% !important;
				      }
				    }
				    /* -------------------------------------
				    PRESERVE THESE STYLES IN THE HEAD
				------------------------------------- */
				    
				    @media all {
				      .ExternalClass {
				        width: 100%;
				      }
				      .ExternalClass,
				      .ExternalClass p,
				      .ExternalClass span,
				      .ExternalClass font,
				      .ExternalClass td,
				      .ExternalClass div {
				        line-height: 100%;
				      }
				      .apple-link a {
				        color: inherit !important;
				        font-family: inherit !important;
				        font-size: inherit !important;
				        font-weight: inherit !important;
				        line-height: inherit !important;
				        text-decoration: none !important;
				      }
				      #MessageViewBody a {
				        color: inherit;
				        text-decoration: none;
				        font-size: inherit;
				        font-family: inherit;
				        font-weight: inherit;
				        line-height: inherit;
				      }
				    }
				    </style>
				  </head>
				  <body>
				    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
				      <tr>
				        <td>&nbsp;</td>
				        <td class="container">
				          <div class="content">

				            <!-- START CENTERED WHITE CONTAINER -->
				            <span class="preheader"></span>
				            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">

				              <!-- START MAIN CONTENT AREA -->
				              <tr>
				                <td class="wrapper">
				                  <p><img src="'.asset('vendors/images/deskapp-logo.png').'" alt="" style="width:25%;"></p>
				                  <p style="color:black;">'.$isi_email.'</p>
				                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
				                    
				                  </table>
				                 
				                </td>
				              </tr>

				              <!-- END MAIN CONTENT AREA -->
				              </table>

				            <!-- START FOOTER -->
				            <div class="footer">
				              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
				                <tr>
				                  <td class="content-block">
				                    <span class="apple-link">SMKN 1 TONDANO</span>
				                    
				                  </td>
				                </tr>
				                <tr>
				                  <td class="content-block powered-by">
				                    Powered by <a href="'.site_url().'">Saw Loker @'.date('Y').'</a>
				                  </td>
				                </tr>
				              </table>
				            </div>

				            <!-- END FOOTER -->
				            
				<!-- END CENTERED WHITE CONTAINER --></div>
				        </td>
				        <td>&nbsp;</td>
				      </tr>
				    </table>
				  </body>
				</html>

		';

		//Recipients
		$mail->setFrom($mail->Username, 'Admin Saw Loker');
		$mail->addAddress($penerima);     //Add a recipient
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Info Saw Loker';
		$mail->Body    = $view;
		if ($mail->send())
		{
			return true;
		}
		else
		{
			return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}

function img_64($links='')
{
	if ($links != '')
	{
		$path = $links;
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}
	else
	{
		return false;
	}
}

// function sendMessage($message=false,$chat_id = false)
// {
// 	if ($message != false and $chat_id != false)
// 	{
// 		$CI =& get_instance();

// 		$bot_token = $CI->config->item('telegram_bot_token');
// 		$chat_id = $chat_id; // ID chat atau nomor telepon tujuan pesan Anda

// 		$telegram_api_url = "https://api.telegram.org/bot$bot_token/sendMessage";

// 		$data = array(
// 			'chat_id' => $chat_id,
// 			'text' => $message,
// 			'parse_mode' => 'markdown',
// 		);

// 		$options = array(
// 			'http' => array(
// 				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
// 				'method'  => 'GET',
// 				'content' => http_build_query($data),
// 			),
// 		);

// 		$context  = stream_context_create($options);
// 		$result = @file_get_contents($telegram_api_url, false, $context);
// 		if ($result == '')
// 		{
// 			return false;
// 		}
// 		else
// 		{
// 			return true;
// 		}
// 		// return json_decode($result,true)['ok'];
// 	}
// 	else
// 	{
// 		return false;
// 		// http_response_code(404);
// 	}
// }


function foto_upload64($files=false,$ref='')
{
	$CI =& get_instance();
	if ($files != false )
	{
		$gambar = "";
		$kdfile = $ref;
		$tanggal = date('dmY');
		$username = $CI->session->userdata('id_user');
		if (!file_exists('mods/vendors/user')) {
			mkdir('mods/vendors/user', 0777, true);
		}

		$config = array(
			'upload_path' => './mods/vendors/user/', 
			'file_name' => 'Foto'.'-'.strtoupper($kdfile).'-'.$tanggal.'-'.date('his').'-'.$username.'-'.rand(1,10000000).'.jpg',
		);

		$output_file = $config['upload_path'].''.$config['file_name'];
		$data = explode( ',', $files );
		// var_dump($data);
		if ($data[0] != '')
		{
			$ifp = fopen( $output_file, 'wb' ); 
			// we could add validation here with ensuring count( $data ) > 1
			fwrite($ifp, base64_decode($data[ 1 ]));
			// clean up the file resource
			fclose( $ifp ); 

			return $config['file_name']; 
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function generatePassword($length = 8) {
    // Daftar karakter yang dapat digunakan dalam username
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $password = '';

    // Menggunakan loop untuk membangun username
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $password .= $characters[$randomIndex];
    }

    return $password;
}

function gen_otp($length = 4) {
    // Daftar karakter yang dapat digunakan dalam otp
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $otp = '';
    // Menggunakan loop untuk membangun otp
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $otp .= $characters[$randomIndex];
    }

    return $otp;
}

function format_nomor($number = false)
{
	if ($number != false)
	{
		return str_replace(',', '.', number_format($number));
	}
	else
	{
		return 0;
	}
}