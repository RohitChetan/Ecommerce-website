<?php 
require('Connection.inc.php');
require('Function.inc.php');

$uid = get_safe_value($con,$_POST['uid']);
$Uname = get_safe_value($con,$_POST['Uname']);
$Umobile = get_safe_value($con,$_POST['UMobile']);

$data = mysqli_query($con,"UPDATE users SET name = '$Uname',mobile = '$Umobile' WHERE id = '$uid'");

if($data){

    echo "Data Updated";
}else{

    echo "Data not Updated";
}
?>
