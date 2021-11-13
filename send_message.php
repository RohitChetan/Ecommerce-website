<?php
require('Connection.inc.php');
require('Function.inc.php');

$name = get_safe_value($con,$_POST['name']);
$email = get_safe_value($con,$_POST['email']);
$mobile = get_safe_value($con,$_POST['mobile']);
$subject = get_safe_value($con,$_POST['subject']);
$message = get_safe_value($con,$_POST['message']);
$added_on = date('Y-m-d h:i:s');


$sql = mysqli_query($con,"INSERT INTO contact_us(name,email,mobile,subject,comment,added_on) VALUES('$name','$email','$mobile','$subject','$message','$added_on')");

if($sql){

	echo "MESSAGE SEND ";
}else{

	echo "MESSAGE NOT SEND";
}

?>