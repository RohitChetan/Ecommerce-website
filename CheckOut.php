<?php 
require('top.inc.php');
//prx($_SESSION);

if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){ ?>

    <script>
        
        window.location.href='index.php';
    </script>
<?php
}


$cart_total = 0;
foreach ($_SESSION['cart'] as $key => $value) {

    $ProductArr = get_product($con,'','',$key);
    $price = $ProductArr[0]['price'];
    $qty = $value['qty'];
    $cart_total = $cart_total+($price*$qty);

}


if(isset($_POST['submit'])){

    $address = get_safe_value($con,$_POST['address']);    
    $city = get_safe_value($con,$_POST['city']);
    $pincode = get_safe_value($con,$_POST['pincode']);
    $state = get_safe_value($con,$_POST['State']);
    $payment_type = get_safe_value($con,$_POST['payment_type']);
    $user_id = $_SESSION['USER_ID'];
    $total_price = $cart_total;
    $payment_status = 'pending';
    if($payment_type=='COD'){

        $payment_status = 'Success';
    }

    $order_status = 1 ;
    $added_on = date('Y-m-d h:i:s');

    if(isset($_SESSION['COUPON_ID'])){

        $coupon_id = $_SESSION['COUPON_ID'];
        $coupon_value = $_SESSION['COUPON_VALUE'];
        $coupon_code = $_SESSION['COUPON_CODE'];
        $total_price = $total_price - $coupon_value;

        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_VALUE']);
        unset($_SESSION['COUPON_CODE']);

    }else{

        $coupon_id = '';
        $final_price = '';
        $coupon_value = '';
        $coupon_code = '';
       
    }

   mysqli_query($con,"INSERT INTO `order`(user_id ,address, city , state ,  pincode , payement_type , total_price , payemnt_status, order_status,added_on,coupon_id,coupon_code,coupon_value) VALUES('$user_id' ,'$address' , '$city' , '$state' , '$pincode' , '$payment_type' , '$total_price' , '$payment_status', '$order_status' , '$added_on' , '$coupon_id' , '$coupon_code' , '$coupon_value')");

    
    $order_id = mysqli_insert_id($con);

    foreach ($_SESSION['cart'] as $key => $value) {

        $ProductArr = get_product($con,'','',$key);
        $price = $ProductArr[0]['price'];
        $qty = $value['qty'];

        mysqli_query($con,"INSERT INTO `order_details`(order_id ,product_id,qty,price) VALUES('$order_id' ,'$key' , '$qty' , '$price')");
    }

     unset($_SESSION['cart']);

     if($payment_type=='instamjo'){
        
    
        $userArr=mysqli_fetch_assoc(mysqli_query($con,"select * from users where id='$user_id'"));
        
        //$posted['txnid']=$txnid;
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:test_a2debc70bdb376abc2058731e1d",
                  "X-Auth-Token:test_b08f3822296d673e9e46246f1fe"
              ));

        $payload = Array(
            'purpose' => 'Testing',
            'amount' => $total_price,
            'phone' => $userArr['mobile'],
            'buyer_name' => $userArr['name'],
            'redirect_url' => 'http://localhost:8080/Ecommerce/payment_complete.php',
            'send_email' => false,
            'send_sms' => false,
            'email' => $userArr['email'],
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        
        $response = json_decode($response);

        $_SESSION['TID'] = $response->payment_request->id;

        mysqli_query($con,"UPDATE `order` set txtid = '".$response->payment_request->id."' WHERE id = '".$order_id."'");

        ?>

        <script>
            window.location.href='<?php echo $response->payment_request->longurl ?>';
        </script>
        <?php
        
        die();

    }else{  


     }

        ?>
        <script>
        
           window.location.href='Thank_You.php';
        </script>
<?php
}

?>
 
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    <?php 

                                        $arrcordion_class = 'accordion__title';
                                        if(!isset($_SESSION['USER_LOGIN'])){

                                            $arrcordion_class = 'accordion__hide';
                                    ?>
                                    <div class="accordion__title">
                                        Checkout Method
                                    </div>
                                    <div class="accordion__body">
                                        <div class="accordion__body__form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                        <form id="login-form"  method="post">
                                                            <h5 class="checkout-method__title">Login</h5>
                                                            <div class="single-input">
                                                                <input type="email" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">

                                                                 <span class="login_error" id="login_email_error" style="color: red;"></span>
                                                            </div>
                                                            <div class="single-input">
                                                                <input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
                                                                <span class="login_error" id="login_pass_error" style="color: red;"></span>
                                                            </div>
                                                            <p class="require">* Required fields</p>
                                                            <div class="dark-btn">
                                                                <button type="submit" name="login" onclick="User_Login()" class="fv-btn">Login</button>
                                                            </div>
                                                        </form>
                                                        <div class="form-output login_error_message">
                                                            <p class="form-messege"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                         <form id="register-form" action="" method="post">
                                                            <h5 class="checkout-method__title">Register</h5>
                                                            <div class="single-input">
                                                                <input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
                                                                <span class="field_error" id="name_error" style="color: red;"></span>
                                                            </div>
                                                            <div class="single-input">
                                                                <input type="text" name="email" id="email" placeholder="Your Email*" style="width:100%">
                                                                <span class="field_error" id="email_error" style="color: red;" ></span>
                                                            </div>
                                                            
                                                            <div class="single-input">
                                                                <input type="text" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%">
                                                                <span class="field_error" id="mobile_error" style="color: red;"></span>
                                                            </div>

                                                            <div class="single-input">
                                                                <input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
                                                                <span class="field_error" id="pass_error" style="color: red;" ></span>
                                                            </div>
                                                            <div class="dark-btn">
                                                                 <button type="button" onclick="User_register()" class="fv-btn">Register</button>
                                                            </div>
                                                        </form>
                                                        <div class="form-output register_error_message">
                                                            <p class="form-messege"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="<?php echo $arrcordion_class ?>">
                                        Address Information
                                    </div>
                                    <form method="post">
                                        <div class="accordion__body">
                                            <div class="bilinfo">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="single-input">
                                                                <input type="text" name="address" placeholder="Street Address" required >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="single-input">
                                                                <input type="text" id="pincode" name="pincode" placeholder="Post code/ zip" required><span>
                                                                <button type="button" onclick="Pincode()" class="btn btn-success"> Get Data </button></span>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="single-input">
                                                                <input type="text" name="city" placeholder="City" id="city" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="single-input">
                                                                <input type="text" name="State" placeholder="State" id="state" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo $arrcordion_class ?>">
                                            payment information
                                        </div>
                                        <div class="accordion__body">
                                            <div class="paymentinfo">
                                                <div class="single-method">
                                                   COD  <input type="radio" name="payment_type" value="COD" required />
                                                   &nbsp;&nbsp;INSTAMOJO <input type="radio" name="payment_type" value="instamjo" required />
                                                </div>
                                                <div class="single-method">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                         <input type="submit" name="submit" class="fv-btn">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                <?php

                                    $cart_total = 0;
                                    foreach ($_SESSION['cart'] as $key => $value) {

                                     $ProductArr = get_product($con,'','',$key);
                                     $pname = $ProductArr[0]['name'];
                                     $mrp = $ProductArr[0]['mrp'];
                                     $price = $ProductArr[0]['price'];
                                     $image = $ProductArr[0]['image'];
                                     $qty = $value['qty'];
                                     $cart_total = $cart_total+($price*$qty);

                                ?>
                                <div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image ?>" alt="ordered item">
                                    </div>
                                    <div class="single-item__content">
                                        <a href="#"><?php echo $pname ?></a>
                                        <span class="price"><?php echo $price*$qty ?></span>
                                    </div>
                                    <div class="single-item__remove">
                                        <a href="javascript:void(0)" onclick="Manage_cart('<?php echo $key ?>','remove')"><i class="zmdi zmdi-delete"></i></a>
                                    </div>
                                </div>

                                <?php } ?>
                            </div>
                            <div class="order-details__count">
                                <!--<div class="order-details__count__single">
                                    <h5>sub total</h5>
                                    <span class="price"></span>
                                </div> -->
                            <!--    <div class="order-details__count__single">
                                    <h5>Tax</h5>
                                    <span class="price">$9.00</span>
                                </div>  -->

                            </div>

                            <div class="ordre-details__total" id="coupon_box" style="display:none;">
                                <h5> Coupon Value</h5> 
                                <span class="price" id="coupon_price"></span>
                            </div>
                             <div class="ordre-details__total">
                                <h5>Order total</h5> 
                                <span class="price" id="price_total"><?php echo $cart_total ?></span>
                            </div>
                            <div class="ordre-details__total">
                                <input type="text" name="" class="form-control" id="coupon_code" />&nbsp;
                                <input type="button" name="submit" class="btn btn-success" value="Apply Coupon" onclick="Set_coupon()">
                            </div>
                            <div class="ordre-details__total" id="coupon_error">
                                <h5 id="coupon_error_head"></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
    
function Set_coupon(){

    var coupon_code = jQuery('#coupon_code').val();
    
    if(coupon_code != ''){

        jQuery.ajax({

            url : 'Set_Coupon.php',
            type : 'POST',
            data : 'Coupon_str='+coupon_code,
            success : function(result){

                var data = jQuery.parseJSON(result);
                if(data.is_error=='yes'){
                    jQuery('#coupon_box').hide();
                    jQuery('#coupon_error_head').html(data.dd).css({"color":"red"});
                    jQuery('#final').hide();
                }

                if(data.is_error=='no'){

                    jQuery('#coupon_box').show();
                    jQuery('#coupon_price').html(data.dd);
                    jQuery('#price_total').html(data.result);
                }
            }
        });
    }
}


function Pincode(){

    var pincode = jQuery('#pincode').val();

    if(pincode==''){


    }else{

        jQuery.ajax({

            url : 'Get_Pincode_Data.php',
            type : 'POST',
            data : 'pincode='+pincode,
            success : function(data){

                var GetData= $.parseJSON(data);

                jQuery('#city').val(GetData.City);
                jQuery('#state').val(GetData.State);
                

            }
        })
    }
}

</script>

<?php

if(isset($_SESSION['COUPON_ID'])){
unset($_SESSION['COUPON_ID']);
unset($_SESSION['COUPON_VALUE']);
unset($_SESSION['COUPON_CODE']);
}

require('footer.inc.php');
?>








