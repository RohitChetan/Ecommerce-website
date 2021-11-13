<?php


function pr($arr){

	echo '<pre>';
	print_r($arr);

}

function prx($arr){

	echo '<pre>';
	print_r($arr);
 
	die();
}

function get_safe_value($con,$str) {

	if($str != ''){

		$str = trim($str);
		return mysqli_real_escape_string($con,$str);
	}
}

function checkProductAvaibilityByProductID($con,$pid){

	$sql = "SELECT sum(order_details.qty) as qty FROM order_details,`order` WHERE `order`.id = order_details.order_id and order_details.product_id = '$pid' and `order`.order_status!=4";

	$res = mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);

	return $row['qty'];
}


function checkProductQTYByProductID($con,$pid){

	$sql = "SELECT qty FROM product WHERE id = '$pid'";

	$res = mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);

	return $row['qty'];
}




?>