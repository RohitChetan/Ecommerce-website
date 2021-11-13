<?php 
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type'] !=''){

   $type = get_safe_value($con,$_GET['type']);
   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $delete = "DELETE FROM users WHERE id='$id'";
       mysqli_query($con,$delete);
   }
}

$sql = "SELECT * FROM users order by id desc";
$res = mysqli_query($con,$sql);
?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title"> ORDER DATA </h4>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table ">
                        <thead>
                           <tr>
                              <th class="product-thumbnail">ORDER ID </th>
                              <th class="product-name"><span class="nobr">ORDER DATE </span></th>
                              <th class="product-price"><span class="nobr"> ADDRESS </span></th>
                              <th class="product-stock-stauts"><span class="nobr"> PAYMENT TYPE </span></th>
                              <th class="product-stock-stauts"><span class="nobr"> PAYMENT STATUS </span></th>
                              <th class="product-stock-stauts"><span class="nobr"> ORDER STATUS </span></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                              //$sql = mysqli_query($con,"SELECT `order`.*,order_status.name as order_status_str FROM `order`,order_status WHERE  order_status.id = `order`.order_status  order by `order`.id desc");
                              
                              $sql =mysqli_query ($con,"SELECT order_details.qty,product.name,`order`.*,order_status.name order_status_str FROM product,order_details,`order`,order_status WHERE order_status.id = `order`.order_status and product.id = order_details.product_id and `order`.id = order_details.order_id and product.added_by = '".$_SESSION['VENDOR_ID']."' ");
                              
                              while($row = mysqli_fetch_assoc($sql)){
                                 
                           
                              ?>
                           <tr>
                              <td class="product-add-to-cart"><?php echo $row['id'] ?><br/>


                              </td>
                              <td class="product-name"><a href="#"><?php echo $row['added_on'] ?></a></td>
                              <td class="product-price"><span class="amount"><?php echo $row['address'] ?></span></td>
                              <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['payement_type'] ?></span></td>
                              <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['payemnt_status'] ?></span></td>
                              <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['order_status_str'] ?></span></td>  
                           </tr>
                           <?php
                              }
                              ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
           
<?php

require('footer.inc.php');
?>