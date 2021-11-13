<?php
require('Connection.inc.php');
require('Function.inc.php');

$type = get_safe_value($con,$_POST['type']);
if($type == 'email'){

	$email = get_safe_value($con,$_POST['email']);
	$sql = mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
	$check_user = mysqli_num_rows($sql);

	if($check_user>0){

		echo "Email Already Present";
		die();
	}else{

	$otp = rand(1111,9999);
	$_SESSION['EMAIL_OTP'] = $otp ;
	$html = "$otp is your OTP ";
	require 'PHPMailer-master/PHPMailerAutoload.php';

			$mail = new PHPMailer();
			$mail->SMTPDebug = 1;
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
				);
			$mail->SMTPAuth = TRUE;
			$mail->Username = "soniya2032003@gmail.com";
			$mail->Password = "Sonu123@@";
			$mail->SMTPSecure = "tls";
			$mail->Port = 587;
			$mail->From = "soniya2032003@gmail.com";
			$mail->FromName = "ADMIN";
			$mail->addAddress($email);
			$mail->isHTML(TRUE);
			$mail->Subject = "NEW OTP";
			$mail->Body = $html;
			//$mail->AltBody = "This is the plain text version of the email content";
			if($mail->send())
			{
				echo "Done";
			}else{

				// error code here echo "done";
			}
	}
}				




?>