<?php 
require('top.inc.php');
$order_id = $_GET['order_id'];


$coupon_details = mysqli_fetch_assoc(mysqli_query($con,"SELECT coupon_value FROM `order` WHERE id = '$order_id'"));

$coupon_value = $coupon_details['coupon_value'];


if(isset($_POST['update_order_status'])){

   $update_order_status = $_POST['update_order_status'];
   $update_sql = '';


    if($update_order_status==3){

      $length = $_POST['length'];
      $breath = $_POST['breath'];
      $height = $_POST['height'];
      $weight = $_POST['weight'];

      $update_sql = ",length='$length', breath='$breath', height='$height', weight='$weight'";
   }


   if($update_order_status==5){

      mysqli_query($con,"UPDATE `order` SET order_status = '$update_order_status',payment_status='success' WHERE id = '$order_id' ");

   }else{

      mysqli_query($con,"UPDATE `order` SET order_status = '$update_order_status'
         $update_sql WHERE id = '$order_id' "); 

   }


    if($update_order_status==3){

      $token = valid_ShipRocketToken($con);
      Place_ShipRocket_Order($con,$token,$order_id);
    }

    if($update_order_status==4){

      $ship_order = mysqli_fetch_assoc(mysqli_query($con,"SELECT ship_order_id FROM `order` WHERE id = '$order_id' "));

      if($ship_order['ship_order_id']>0){

         $token = valid_ShipRocketToken($con);
         Cancel_Shiprocket_Order($token,$ship_order['ship_order_id']);
      }

   }
   
  
}

?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title"> ORDER DETAILS </h4>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table ">
                        <thead>
                           <tr>
                              <th class="product-name"><span class="nobr"> PRODUCT NAME  </span></th>
                              <th class="product-price"><span class="nobr"> IMAGE </span></th>
                              <th class="product-name"><span class="nobr"> QTY </span></th>
                              <th class="product-stock-stauts"><span class="nobr"> PRICE  </span></th>
                              <th class="product-stock-stauts"><span class="nobr"> TOTAL PRICE </span></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              
                           $sql = mysqli_query($con,"SELECT distinct(order_details.id),order_details.*,product.name,product.image,`order`.address,`order`.city,`order`.pincode, `order`.order_status FROM order_details,product,`order` WHERE order_details.order_id = '$order_id' and order_details.product_id = product.id and `order`.id = '$order_id' Group By order_details.id");



                              //$sql = mysqli_query($con,"SELECT distinct(`order_details`.id),`order_details`.*,product.name,product.image, `order`.address, `order`.city, `order`.pincode , `order`.order_status FROM  `order_details`,product, `order` WHERE `order_details`.order_id = '$order_id'  and `order_details`.product_id = product.id ");
                             
                              //prx($sql);

                              $total_price = 0;
                              
                              while($row = mysqli_fetch_assoc($sql)){
               
                               $address = $row['address'];
                               $city = $row['city'];
                               $pincode = $row['pincode'];
                               $order_status = $row['order_status'];
                               $total_price += ($row['qty']*$row['price']);

                               
                              ?>
                              <tr>
                                 <td class="product-add-to-cart"><a href="#"><?php echo $row['name']; ?></a></td>
                                 <td class="product-name"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']; ?> "></a></td>
                                 <td class="product-price"><span class="amount"><?php echo $row['qty'] ?></span></td>
                                 <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['price']; ?></span></td>
                                 <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['qty']*$row['price']; ?></span></td>
                              </tr>


                             <?php
                                 } 
                                 if($coupon_value != ''){ 
                             ?>
                              <tr>                                 
                                 <td colspan="3"></td>
                                 <td class="product-name"> CPOUPON Discount </td>
                                 <td class="product-name"> <?php echo $coupon_value ?> </td>
                             </tr>
                             <tr>
                                 <td colspan="3"></td>
                                 <td class="product-name"> TOTAL PRICE </td>
                                 <td class="product-name"> <?php echo $total_price-$coupon_value; ?> </td>
                             </tr>

                             <?php
                                 }else{
                             ?>
                             <tr>
                                 <td colspan="3"></td>
                                 <td class="product-name"> TOTAL PRICE </td>
                                 <td class="product-name"> <?php echo $total_price ?> </td>
                             </tr>

                         <?php } ?>
                        
                        </tbody>
                     </table>
                     <div class="address__details">
                        <strong>&nbsp; ADDRESS :- </strong>
                        <?php echo $address ?>,<?php echo $city ?>,<?php echo $pincode ?> <br/><br/>
                        <strong> &nbsp; ORDER STATUS :- </strong>
                        <?php $order_status_arr = mysqli_fetch_assoc(mysqli_query($con,"SELECT order_status.name,order_status.id as order_status from order_status,`order` where `order`.id = '$order_id' and `order`.order_status = order_status.id"));

                        echo $order_status_arr['name'];

                        ?>
                        <br/>
                        <div class="address__details">
                           <form method="POST">
                              <select class=" form-control" name="update_order_status" id="update_order_status" onchange="select_status()">
                                 <option> Select STATUS </option>
                                 <?php
                                    $res = mysqli_query($con,"SELECT * FROM order_status");
                                    while($row=mysqli_fetch_assoc($res)){
                                    
                                    
                                    echo "<option selected value=".$row['id'].">".$row['name']."</option>";                            

                                    }
                                    ?>
                              </select>
                              <br/>
                              <div id="Shipped_box" style="display: none;">
                                 <table>
                                    <tr>
                                       <td> <input type="text" class="form-control" name="length" placeholder="Enter Currier length"> </td>
                                       <td><input type="text" class="form-control" name="breath" placeholder="Enter Currier Breath"> </td>
                                       <td><input type="text" class="form-control" name="height" placeholder="Enter Currier Height"> </td>
                                       <td><input type="text" class="form-control" name="weight" placeholder="Enter Currier Weight"> </td>
                                    </tr>
                                 </table>
                              </div>
                              <input type="submit" name="submit" class="form-control btn btn-success"/>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   
function select_status(){

   var update_order_status = jQuery('#update_order_status').val();

   if(update_order_status == 3){

      jQuery('#Shipped_box').show();
   }else{
      jQuery('#Shipped_box').hide();
   }
}

</script>


<?php

require('footer.inc.php');
?>












