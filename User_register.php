<?php
require('Connection.inc.php');
require('Function.inc.php');

$name = get_safe_value($con,$_POST['name']);
$email = get_safe_value($con,$_POST['email']);
$mobile = get_safe_value($con,$_POST['mobile']);
$added_on = date('Y-m-d h:i:s');
$password= get_safe_value($con,$_POST['password']);


$check_user =mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE email='$email'"));

if($check_user>0){

	echo "Present";
}else{

	mysqli_query($con,"INSERT INTO users(name,email,mobile,added_on,password) VALUES('$name','$email','$mobile','$added_on','$password')");

	echo "Insert";
}

?>