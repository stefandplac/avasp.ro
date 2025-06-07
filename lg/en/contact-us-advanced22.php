<?php
session_start();

include("php/simple-php-captcha/simple-php-captcha.php");
include("php/php-mailer/PHPMailerAutoload.php");

// Step 1 - Enter your email address below.
$to = 'office@avasp.ro';

if(isset($_POST['emailSent'])) {

	$subject = $_POST['subject'];

	// Step 2 - If you don't want a "captcha" verification, remove that IF.
	if (strtolower($_POST["captcha"]) == strtolower($_SESSION['captcha']['code'])) {

		$name = $_POST['name'];
		$email = $_POST['email'];

		// Step 3 - Configure the fields list that you want to receive on the email.
		$fields = array(
			0 => array(
				'text' => 'Name',
				'val' => $_POST['name']
			),
			1 => array(
				'text' => 'Email address',
				'val' => $_POST['email']
			),
			2 => array(
				'text' => 'Message',
				'val' => $_POST['message']
			),
			3 => array(
				'text' => 'Checkboxes',
				'val' => implode($_POST['checkboxes'], ", ")
			),
			4 => array(
				'text' => 'Radios',
				'val' => $_POST['radios']
			)
		);

		$message = "";

		foreach($fields as $field) {
			$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
		}

		$mail = new PHPMailer;

		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->SMTPDebug = 0;                                 // Debug Mode

		// Step 4 - If you don't receive the email, try to configure the parameters below:

		//$mail->Host = 'mail.yourserver.com';				  // Specify main and backup server
		//$mail->SMTPAuth = true;                             // Enable SMTP authentication
		//$mail->Username = 'username';             		  // SMTP username
		//$mail->Password = 'secret';                         // SMTP password
		//$mail->SMTPSecure = 'tls';                          // Enable encryption, 'ssl' also accepted

		$mail->From = $email;
		$mail->FromName = $_POST['name'];
		$mail->AddAddress($to);
		$mail->AddAddress($email);
		$mail->AddReplyTo($email, $name);

		$mail->IsHTML(true);

		$mail->CharSet = 'UTF-8';

		$mail->Subject = $subject;
		$mail->Body    = $message;
		

		// Step 5 - If you don't want to attach any files, remove that code below
		if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
			$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
		}

		if($mail->Send()) {
			$arrResult = array('response'=> 'success');
		} else {
			$arrResult = array('response'=> 'error', 'error'=> $mail->ErrorInfo);
		}

	} else {

		$arrResult['response'] = 'captchaError';

	}

}
?>
<!DOCTYPE html>
<!-- devcode: !production --><html><!-- endcode --><!-- devcode: production --><html><!-- endcode -->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>Avasp.ro</title>	

		

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">
		<link rel="stylesheet" href="css/theme-animate.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.js"></script>

		<!--[if IE]>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="vendor/respond/respond.js"></script>
			<script src="vendor/excanvas/excanvas.js"></script>
		<![endif]-->

	</head>
	<body>

		<div class="body">
			
			<div role="main" class="main">	

				
				<div class="container">

						<form class="well form-horizontal" id="contactFormAdvanced" action="contact-us-advanced.php#contact-sent" method="POST" enctype="multipart/form-data">
						<fieldset>
						<legend>Contact Us Today</legend>
 						
		
								
									<div class="form-group">
										<label class="col-md-4 control-label">Nume </label>
										<div class="col-md-4" inputGroupContainer">
										    <div class="input-group">
										         <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										         <input type="text" value="" placeholder="Nume complet" maxlength="100" class="form-control" name="name" id="name" required>
											</div>
										</div>	
									</div>
										
									<div class="form-group">
                                        <label class="col-md-4 control-label">E-mail</label>
                                        <div class="col-md-4 inputGroupContainer">
                                              <div class="input-group">
                                                   <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                   <input type="email" value="" placeholder="Email" maxlength="100" class="form-control" name="email" id="email" required>
										      </div>
										</div>
									</div>
									<div class="form-group">
                                        <label class="col-md-4 control-label">Telefon #</label>
                                        <div class="col-md-4 inputGroupContainer">
                                              <div class="input-group">
                                                   <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                                   <input type="text" value="" placeholder="Telefon" maxlength="25" class="form-control" name="telefon" id="telefon" required>
										      </div>
										</div>
									</div>
								
								<!--
									<div class="form-group">
										<div class="col-md-12">
											<label>Servicii juridice solicitate</label>
											<select data-msg-required="Please enter the subject." class="form-control" name="subject" id="subject" required>
												<option value="">...</option>
												<option value="Option 1">model cerere + explicatii aferente</option>
												<option value="Option 2">asistenta juridica privind o procedura judiciara [redactarea cererii in baza documentelor furnizate de catre client]</option>
												<option value="Option 3">reprezentare juridica intr-o cauza judiciara/jurisdisctionala</option>
												</select>
										</div>
									</div>
								-->
								<!--
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Checkboxes</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="checkbox-group" data-msg-required="Please select at least one option.">
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox1" value="option1"> 1
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox2" value="option2"> 2
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox3" value="option3"> 3
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox4" value="option4"> 4
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox5" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Radios</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="radio-group" data-msg-required="Please select one option.">
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio1" value="option1"> 1
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio2" value="option2"> 2
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio3" value="option3"> 3
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio4" value="option4"> 4
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio5" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								-->
								<div class="form-group">
                                        <label class="col-md-4 control-label">Adresa</label>
                                        <div class="col-md-4 inputGroupContainer">
                                              <div class="input-group">
                                                   <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                   <input type="text" value="" placeholder="Adresa" maxlength="25" class="form-control" name="address" id="address" required>
										      </div>
										</div>
									</div>
								
								<div class="form-group">
                                        <label class="col-md-4 control-label">Oras</label>
                                        <div class="col-md-4 inputGroupContainer">
                                              <div class="input-group">
                                                   <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                   <input type="text" value="" placeholder="Oras" maxlength="30" class="form-control" name="city" id="city" required>
										      </div>
										</div>
									</div>
									<div class="form-group">
									       <label class="col-md-4 control-label">Judet</label>
										         <div class="col-md-4 selectContainer">
												 <div class="input-group">
												       <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
													   <select name="state" class="form-control selectpicker">
													        <option value=" ">Selecteaza judetul</option>
															<option>	Alba</option>
                                                            <option>Arad</option>
                                                            <option>Arges</option>
                                                            <option>Bacau</option>
                                                            <option>Bihor</option>
                                                            <option>Bistrita Nasaud</option>
                                                            <option>Botosani</option>
                                                            <option>Braila</option>
                                                            <option>Brasov</option>
                                                            <option>Bucuresti</option>
                                                            <option>Buzau</option>
                                                            <option>Calarasi</option>
                                                            <option>Caras Severin</option>
                                                            <option>Cluj</option>
                                                            <option>Constanta</option>
                                                            <option>Covasna</option>
                                                            <option>Dambovita</option>
                                                            <option>Dolj</option>
                                                            <option>Galati</option>
                                                            <option>Giurgiu</option>
                                                            <option>Gorj</option>
                                                            <option>Harghita</option>
                                                            <option>Hunedoara</option>
                                                            <option>Ialomita</option>
                                                            <option>Iasi</option>
                                                            <option>Ilfov</option>
                                                            <option>Maramures</option>
                                                            <option>Mehedinti</option>
                                                            <option>Mures</option>
                                                            <option>Neamt</option>
                                                            <option>Olt</option>
                                                            <option>Prahova</option>
                                                            <option>Salaj</option>
                                                            <option>Satu Mare</option>
                                                            <option>Sibiu</option>
                                                            <option>Suceava</option>
                                                            <option>Teleorman</option>
                                                            <option>Timis</option>
                                                            <option>Tulcea</option>
                                                            <option>Valcea</option>
                                                            <option>Vaslui</option>
                                                            <option>Vrancea</option>
      
                                                        </select>
												    </div>
											</div>		
									</div>
									<div class="form-group">
                                        <label class="col-md-4 control-label">Subiect</label>
                                        <div class="col-md-4 inputGroupContainer">
                                              <div class="input-group">
                                                   <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                   <input type="text" value="" placeholder="subiect"  maxlength="100" class="form-control" name="subject" id="subject" required>
										      </div>
										</div>
									</div>
									<div class="form-group">
                                          <label class="col-md-4 control-label">Descrierea situatiei </label>
                                          <div class="col-md-4 inputGroupContainer">
                                               <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        	                                        <textarea placeholder="descrierea situatiei " rows="10" class="form-control" name="message" id="message" required></textarea>
                                               </div>
                                           </div>
                                    </div>
								
								   
								
									<div class="form-group">
											<label class="col-md-4 control-label">Attachment</label>
											<div class="col-md-4 inputGroupContainer">
											       <div class="input-group">
											              <input type="file" name="attachment" id="attachment">
										           </div>
											</div>
									</div>
								
								
								
									<div class="form-group">
										<label class="col-md-4 control-label"></label>
										<div class="col-md-4 inputGroupContainer">
										   <div class="input-group">
											<div class="captcha form-control">
												<div class="captcha-image">
													<img id="captcha-image" src="php/simple-php-captcha/simple-php-captcha.php//porto/4.9.2/php/simple-php-captcha/simple-php-captcha.php?_CAPTCHA&amp;t=0.35385500+1479280712" alt="CAPTCHA code">												</div>
												<div class="captcha-refresh">
													<a href="#" id="refreshCaptcha"><i class="fa fa-refresh"></i></a>
												</div>
											</div>
										   
										
											<input type="text" value="" maxlength="6" data-msg-captcha="Wrong verification code." data-msg-required="Please enter the verification code." placeholder="Type the verification code." class="form-control input-lg captcha-input" name="captcha" id="captcha" required>
										
									   </div>
										</div>
									</div>
								   
								
									<div class="col-md-12">
										<hr>
									</div>
								   <!-- Success message -->
                                   <div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.
								   </div>
								
								    <div class="form-group">
									     <label class="col-md-4 control-label"></label>
									     <div class="col-md-4">
										      <input type="submit" id="contactFormSubmit" value="Send Message" class="btn btn-primary btn-lg pull-right" data-loading-text="Loading...">
									    </div>
									</div>
								
							</fieldset>
							</form>
						
						
				</div>

			</div>

			
		</div>

		<!-- Vendor -->
		<!--[if lt IE 9]>
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="vendor/jquery/jquery.js"></script>
		<!--<![endif]-->
		<script src="vendor/jquery.appear/jquery.appear.js"></script>
		<script src="vendor/jquery.easing/jquery.easing.js"></script>
		<script src="vendor/jquery-cookie/jquery-cookie.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.js"></script>
		<script src="vendor/common/common.js"></script>
		<script src="vendor/jquery.validation/jquery.validation.js"></script>
		<script src="vendor/jquery.stellar/jquery.stellar.js"></script>
		<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
		<script src="vendor/jquery.gmap/jquery.gmap.js"></script>
		<script src="vendor/jquery.lazyload/jquery.lazyload.js"></script>
		<script src="vendor/isotope/jquery.isotope.js"></script>
		<script src="vendor/owl.carousel/owl.carousel.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="vendor/vide/vide.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Specific Page Vendor and Views -->
		<script src="js/views/view.contact.js"></script>
		
		<!-- Theme Custom -->
		<script src="js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>
         <!--Form Validator-->
        <script src="js/form_validator.js"></script>	   

	</body>
</html>
