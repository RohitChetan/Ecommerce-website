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

function get_product($con, $limit='',$cat_id='',$product_id='',$search_str='',$sort_order='',$is_best_seller='',$sub_categories='') {

	$sql = "SELECT product.*,categories.Categories FROM product,categories WHERE product.status = 1";

	if($cat_id != ''){
		$sql.=" and product.categories_id = $cat_id";
	}
	if($product_id != ''){
		$sql.=" and product.id = $product_id";
	}

	if($sub_categories != ''){
		$sql.=" and product.sub_categories_id = $sub_categories";
	}

	if($is_best_seller != ''){
		$sql.=" and product.best_seller=1";
	}

	$sql.=" and product.categories_id = categories.id";

	if($search_str != ''){
		$sql.=" and (product.name like '%$search_str%' or product.long_desc like '%$search_str%' )";
	}

	if($sort_order != ''){

		$sql.=$sort_order;
	}else{
		$sql.=" order by product.id desc";
	}
	if($limit!=''){
		$sql.=" LIMIT $limit";
	}
	// echo $sql;
	$res = mysqli_query($con,$sql);
	$data = array();
	while($row=mysqli_fetch_assoc($res)){
		$data[] = $row;
	}

	return $data;
}

function get_safe_value($con,$str) {

	if($str != ''){

		$str = trim($str);
		return mysqli_real_escape_string($con,$str);
	}
}

function Wishlist_add($con,$uid,$pid){

	$added_on = date('Y-m-d h:i:s');
	mysqli_query($con,"INSERT INTO Wishlist(user_id,product_id,added_on) VALUES('$uid','$pid','$added_on')");
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





function SentInvoice($con,$order_id){


$coupon_details = mysqli_fetch_assoc(mysqli_query($con,"SELECT coupon_value FROM `order` WHERE id = '$order_id'"));

$coupon_value = $coupon_details['coupon_value'];




$sql = mysqli_query($con,"SELECT distinct(`order_details`.id),`order_details`.*,product.name,product.image FROM  `order_details`,product, `order` WHERE `order_details`.order_id = '$order_id' and  `order_details`.product_id = product.id ");



$user_order = mysqli_fetch_assoc(mysqli_query($con,"SELECT  `order`.*,users.name,users.email FROM `order`,users WHERE users.id = `order`.user_id and `order`.id = '$order_id'"));

//prx($user_order);


$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">Order # '.$user_order['ship_order_id'].'</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                    <strong>Billed To:</strong><br>
                       '.$user_order['name'].'<br>
                        '.$user_order['address'].'<br>
                        '.$user_order['city'].'<br>
                        '.$user_order['pincode'].'<br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                    <strong>Shipped To:</strong><br>
                       '.$user_order['name'].'<br>
                        '.$user_order['address'].'<br>
                        '.$user_order['city'].'<br>
                        '.$user_order['pincode'].'<br>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                       '.$user_order['payement_type'].'<br>
                        '.$user_order['email'].'
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        '.$user_order['added_on'].'<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>Item</strong></td>
                                    <td class="text-center"><strong>Price</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"><strong>Totals</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                            ';
                                 $total_price = 0;

                                    if(mysqli_num_rows($sql)==0){

                                        die();
                                    }

                                    while($row = mysqli_fetch_assoc($sql)){

                                        $total_price = $total_price+($row['qty']*$row['price']);
                                        $pp = $row['qty']*$row['price'];

                               $html.=' <tr>
                                    <td>'.$row['name'].'</td>
                                    <td class="text-center">'.$row['price'].'</td>
                                    <td class="text-center">'.$row['qty'].'</td>
                                    <td class="text-right">'.$pp.'</td>
                                </tr>';

                               } 
                               if($coupon_value != ''){ 

                                $main_price = $total_price - $coupon_value; 
                                
                               $html.=' <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                    <td class="thick-line text-right">'.$pp.'</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Coupon Discount </strong></td>
                                    <td class="no-line text-right">'.$coupon_value.'</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Total</strong></td>
                                    <td class="no-line text-right">'.$main_price.'</td>
                                </tr>';

                                }else{

                                $html.=' <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center"><strong>Total</strong></td>
                                    <td class="thick-line text-right">'.$pp.'</td>
                                </tr>';

                                }

                          $html.='  </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> ';


	require 'PHPMailer-master/PHPMailerAutoload.php';
	$mail = new PHPMailer();
	$mail->SMTPDebug = 1;
	$mail->isSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		);
	$mail->SMTPAuth = TRUE;
	$mail->Username = "soniya2032003@gmail.com";
	$mail->Password = "Sonu123@@";
	$mail->SMTPSecure = "tls";
	$mail->Port = 587;
	$mail->From = "soniya2032003@gmail.com";
	$mail->FromName = "ADMIN";
	$mail->addAddress($user_order['email']);
	$mail->isHTML(TRUE);
	$mail->Subject = "Invoice Details";
	$mail->Body = $html;
	//$mail->AltBody = "This is the plain text version of the email content";
	if($mail->send())
	{ 

        //echo "Mail send";		

	}else{

		// error code here echo "done";
	}



}


?>