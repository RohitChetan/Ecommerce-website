<?php
session_start();
$con = mysqli_connect('localhost','root','',"Ecommerce");


define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/Ecommerce/');
define('SITE_PATH','http://localhost:8080/Ecommerce/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'Media/product/');

define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'Media/product/');

define('PRODUCT_MULTIIMAGE_SERVER_PATH',SERVER_PATH.'Media/Product_Multiple_images/');
define('PRODUCT_MULTIIMAGE_SITE_PATH',SITE_PATH.'Media/Product_Multiple_images/');


?>