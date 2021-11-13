<?php
require('Connection.inc.php');
require('Cart.inc.php');
require('Function.inc.php');

$pid = get_safe_value($con,$_POST['pid']);
$qty= get_safe_value($con,$_POST['qty']);
$type= get_safe_value($con,$_POST['type']);


$checkProductAvaibilityByProductID = checkProductAvaibilityByProductID($con,$pid);
$checkProductQTY  = checkProductQTYByProductID($con,$pid);

$pendingQTY = $checkProductQTY - $checkProductAvaibilityByProductID;

if($qty > $pendingQTY){

	echo "not available";
	die();
}

$obj=new Add_To_Cart();

if($type == 'add'){

	$obj->addProduct($pid,$qty);
} 

if($type == 'remove'){

	$obj->removeProduct($pid,$qty);
} 

if($type == 'update'){

	$obj->updateProduct($pid,$qty);
} 

if($type == 'empty'){

	$obj->addProduct($pid,$qty);
} 


echo $obj->TotalProduct();

?>