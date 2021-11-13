<?php
require('Connection.inc.php');
require('Function.inc.php');

$email = get_safe_value($con,$_POST['email']);
$password= get_safe_value($con,$_POST['password']);


$sql = mysqli_query($con,"SELECT * FROM users WHERE email='$email' and password = '$password'");
$check_user = mysqli_num_rows($sql);

if($check_user>0){

	$row=mysqli_fetch_assoc($sql);

	$_SESSION['USER_LOGIN']='yes';
	$_SESSION['USER_ID'] = $row['id'];
	$_SESSION['USER_NAME'] = $row['name'];

	if(isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID'] != ''){

		Wishlist_add($con,$_SESSION['USER_ID'],$_SESSION['WISHLIST_ID']);
		unset($_SESSION['WISHLIST_ID']);
	}

	echo "Insert";
	
}else{


	echo "Try";
}

?>