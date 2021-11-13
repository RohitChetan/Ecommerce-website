<?php 
require('Connection.inc.php');
require('Function.inc.php');



$id = get_safe_value($con,$_POST['id']);

$Updateprice = get_safe_value($con,$_POST['price']);

$check = mysqli_fetch_array(mysqli_query($con,"SELECT vendor_price,mrp FROM product WHERE id = '$id'"));

$vendor = $check['vendor_price'];
$mrp = $check['mrp'];


prx($_POST);

?>