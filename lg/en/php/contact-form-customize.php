<?php
//this is php file e-mail action
session_cache_limiter('nocache');
header('Expires: '.gmdate('r',0));
//step 1 enter our e-mail address below
$to = 'andreiplacinta87@gmail.com';
//step 2 - eneable if the server requires SMTP authentification (true/false)
$enablePHPMailer = false;
$message_content = $_POST['description']; //we retrieve the content of description box from the form contact to engage judicial services
if(isset($_POST['email'])){
	$name = $_POST['first_name'] . $_POST['last_name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$services_required = $_POST['services_form'];
	$description = $_POST['description'];
	$mail_content = "Date contact client: ".
	                "Nume : ".$name."\n".
	                "Email : ".$email."\n".
					"Telefon : ".$phone."\n".
					"Adresa : ".$address."\n".
					"Localitate : ".$city."\n".
					"Judet : ".$state."\n".
					"Servicii juridice solicitate : ".$services_required."\n".
					"Situatia juridica in legatura cu care se face solicitarea : "."\n".$message_content."\n";

    if(!enablePHPMailer){
	       if(mail($email.";".$to.";", "Cerere consultanta juridica".$services_required, $mail_content, $to)){
		       $arrResult = array ('response'=>'success');
	       }else {
		       $arrResult = array('response'=>'error');
	       }
    } else {
		    include("php-mailer/PHPMailerAutoload.php");
			$mail = new PHPMailer;
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->From = $to;
			$mail->FromName =$name;
			$mail->AddAddress($email);
			$mail->AddAddress($to);
			$mail->IsHTML(true);
			$mail->CharSet = 'UTF-8';
			$mail->Subject= "Cerere consultanta juridica".$services_required;
			$mail->Body =$mail_content;
			if(!$mail->Send()){
				$arrResult = array('response'=>'error');
			}
			$arrResult = array ('response'=>'success');
	}
	echo json_encode($arrResult);
	
} else {
	$arrResult = array('response'=>'error');
	echo json_encode($arrResult);
}
?>