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


function valid_ShipRocketToken($con){

  date_default_timezone_set('Asia/Calcutta');
  $row = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM shiprocket_token"));
  $added_on = strtotime($row['added_on']);
  $current_time = strtotime(date('Y-m-d h:i:s'));
  $def_time = $current_time-$added_on;
  
  if($def_time>86400){

    $token = Generate_ShipRocket_Token($con);
  }else{

    $token=$row['token'];
  }

  return $token;
}

function Generate_ShipRocket_Token($con){

date_default_timezone_set('Asia/Calcutta');
$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"email\": \"thunderstrome65@gmail.com\",\n
    \"password\": \"Chetu123@@__\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  $token = $SR_login_Response_out->{'token'};
  $added_on = date('Y-m-d h:i:s');

  mysqli_query($con,"UPDATE shiprocket_token SET token = '$token', added_on = '$added_on'");

  return $token;


}

function Place_ShipRocket_Order($con,$token,$order_id){

$row_order = mysqli_fetch_assoc(mysqli_query($con,"SELECT `order`.*,users.name,users.email,users.mobile FROM `order`,users WHERE `order`.id = '$order_id' and `order`.user_id = users.id"));

  $order_date = $row_order['added_on'];
  $name = $row_order['name'];
  $email = $row_order['email'];
  $mobile = $row_order['mobile'];
  $address = $row_order['address'];
  $city = $row_order['city'];
  $pincode = $row_order['pincode'];
  $payment_type = $row_order['payement_type'];
  if($payment_type=='PayU'){

     $payment_type='Prepaid';
  }else{

    $payment_type='COD';
  }

  $total_price = $row_order['total_price'];
  $length = $row_order['length'];
  $breath = $row_order['breath'];
  $height = $row_order['height'];
  $weight = $row_order['weight'];

  
  $res= mysqli_query($con,"SELECT order_details.*,product.name FROM order_details,product WHERE product.id = order_details.product_id and order_details.order_id = '$order_id'");
  $html ='';

  while($row=mysqli_fetch_assoc($res)){

    $html .=' {
              "name": "'.$row['name'].'",
              "sku": "'.$row['product_id'].'",
              "units": '.$row['qty'].',
              "selling_price": "'.$row['price'].'",
              "discount": "",
              "tax": "",
              "hsn": 441122
          }';

  }

  $html = rtrim($html,",");
  

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>'{"order_id": "'.$order_id.'",
  "order_date": "'.$order_date.'",
  "pickup_location": "Mahelav",
  "billing_customer_name": "'.$name.'",
  "billing_last_name": "",
  "billing_address": "'.$address.'",
  "billing_address_2": "",
  "billing_city": "'.$city.'",
  "billing_pincode": "'.$pincode.'",
  "billing_state": "Gujarat",
  "billing_country": "India",
  "billing_email": "'.$email.'",
  "billing_phone": "'.$mobile.'",
  "shipping_is_billing": true,
  "shipping_customer_name": "",
  "shipping_last_name": "",
  "shipping_address": "",
  "shipping_address_2": "",
  "shipping_city": "",
  "shipping_pincode": "",
  "shipping_country": "",
  "shipping_state": "",
  "shipping_email": "",
  "shipping_phone": "",
  "order_items": [
    
      '.$html.'
  ],
  "payment_method": "'.$payment_type.'",
  "shipping_charges": 0,
  "giftwrap_charges": 0,
  "transaction_charges": 0,
  "total_discount": 0,
  "sub_total": '.$total_price.',
  "length": '.$length.',
  "breadth": '.$breath.',
  "height": '.$height.',
  "weight": '.$weight.'
  }',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
     "Authorization: Bearer $token"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  
  
  $ship_order_id = $SR_login_Response_out->order_id;
  $ship_shipment_id = $SR_login_Response_out->shipment_id;

  mysqli_query($con,"UPDATE `order` SET ship_order_id='$ship_order_id',ship_shipment_id='$ship_shipment_id' WHERE id = '$order_id'");


}


function Cancel_Shiprocket_Order($token,$ship_order_id){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"ids\": [".$ship_order_id."]\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);

curl_close($curl);

}


?>