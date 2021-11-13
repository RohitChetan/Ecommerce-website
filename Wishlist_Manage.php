<?php
require('Connection.inc.php');
require('Cart.inc.php');
require('Function.inc.php');

$pid = get_safe_value($con,$_POST['pid']);
$type= get_safe_value($con,$_POST['type']);

if(isset($_SESSION['USER_LOGIN'])){

	$uid = $_SESSION['USER_ID'];
	//$added_on = date('Y-m-d h:i:s');
	if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM Wishlist WHERE product_id = '$pid' and user_id = '$uid'"))>0){

		//echo "Already Added ";

	}else{

		//mysqli_query($con,"INSERT INTO Wishlist(user_id,product_id,added_on) VALUES('$uid','$pid','$added_on')");

		Wishlist_add($con,$uid,$pid);

	}

		echo $total_record = mysqli_num_rows(mysqli_query($con,"SELECT * FROM wishlist WHERE user_id = '$uid' "));
}else{

	$_SESSION['WISHLIST_ID'] = $pid ;
	echo "Not Login";
}

?>