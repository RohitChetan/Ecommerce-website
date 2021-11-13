<?php 
require('Connection.inc.php');
require('Function.inc.php');

$coupon_str = get_safe_value($con,$_POST['Coupon_str']);


$res = mysqli_query($con,"SELECT * FROM coupon_master WHERE coupon_code = '$coupon_str' and status = 1");

$count = mysqli_num_rows($res);

$jsonArr = array();
$cart_total = 0;

    foreach ($_SESSION['cart'] as $key => $value) {

    	$ProductArr = get_product($con,'','',$key);
    	$price = $ProductArr[0]['price'];
   	    $qty = $value['qty'];
        $cart_total = $cart_total+($price*$qty);
    }

if($count>0){

	$coupon_details = mysqli_fetch_assoc($res);

	$coupon_id = $coupon_details['id'];
	$coupon_value = $coupon_details['coupon_value'];
	$coupon_type = $coupon_details['coupon_type'];
	$cart_min_value = $coupon_details['cart_min_value'];

    if($cart_min_value>$cart_total){
    		$jsonArr=array('is_error'=>'yes','result'=>$cart_total,'dd'=>'Cart Total Not Capabele For this Coupon');
   
    }else{
    		
    		if($coupon_type=='Rupees'){
 				$final_price = $cart_total - $coupon_value ;
    		}else{

    				$less = $cart_total*$coupon_value/100;
    			    $final_price = $cart_total - $less;

    		}

    			$dd = $cart_total - $final_price;
	
				$_SESSION['COUPON_ID'] = $coupon_id ; 
        		$_SESSION['COUPON_VALUE'] = $coupon_value;
        	    $_SESSION['COUPON_CODE'] = $coupon_str;
        	    $_SESSION['FINAL_PRICE'] = $dd;


    			$jsonArr=array('is_error'=>'no','result'=>$final_price,'dd'=>$dd);
    }

}else{

	$jsonArr=array('is_error'=>'yes','result'=>$cart_total,'dd'=>'Coupon Code Not Valid');
}

echo json_encode($jsonArr);
?>








