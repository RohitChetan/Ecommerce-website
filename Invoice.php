<?php
require('Connection.inc.php');
require('Function.inc.php');


$order_id = get_safe_value($con,$_GET['order_id']);

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


echo $html;
?>