<?php
require('Connection.inc.php');
require('Function.inc.php');

$type = get_safe_value($con,$_POST['type']);
$otp = get_safe_value($con,$_POST['otp']);

if($type == 'email'){

	if($otp == $_SESSION['EMAIL_OTP']){

		echo "done";
	}else{

		echo "no";
	}
}

?>