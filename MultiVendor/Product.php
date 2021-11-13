<?php 
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type'] !=''){

   $type = get_safe_value($con,$_GET['type']);

   if($type=='status'){

      $operation = get_safe_value($con,$_GET['operation']);
      $id = get_safe_value($con,$_GET['id']);

      if($operation=='active'){

         $status = '1';
      }else{

         $status = '0';
      }

      $update = "UPDATE product SET status='$status' WHERE id='$id' and product.added_by = '".$_SESSION['VENDOR_ID']."'";
       mysqli_query($con,$update);
   }

   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $delete = "DELETE FROM product WHERE id='$id' product.added_by = '".$_SESSION['VENDOR_ID']."'";
       mysqli_query($con,$delete);
   }
}

$total = mysqli_query($con,"SELECT  product.*,categories.Categories FROM product,categories where product.categories_id = categories.id  and  product.added_by ='".$_SESSION['VENDOR_ID']."' order by product.id desc");


?>

            <div class="content pb-0">
               <div class="orders">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="box-title"> Product </h4>
                              <h4 class="box-link"><a href="add_product.php"> Add Product </a></h4>
                           </div>
                           <div class="card-body--">
                              <div class="table-stats order-table ov-h">
                                 <table class="table ">
                                    <thead>
                                       <tr>
                                          <th class="serial">#</th>
                                          <th class="avatar">ID</th>
                                          <th>Categories</th>
                                          <th> NAME </th>
                                          <th> MRP </th>
                                          <th> PRICE </th>
                                          <th> Quantity </th>
                                          <th> Image </th>
                                          <th> </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                          $i=1;
                                           while ($row=mysqli_fetch_assoc($total)) {
                                       ?>
                                       <tr>
                                          <td class="serial"> <?php echo $i++ ?> </td>
                                          <td> <?php echo $row['id'] ?></td>
                                          <td> <?php echo $row['Categories'] ?> </td>
                                          <td> <?php echo $row['name'] ?> </td>
                                          <td> <?php echo $row['mrp'] ?> </td>
                                          <td> <?php echo $row['vendor_price'] ?> </td>
                                          <td> <?php echo $row['qty'] ?> <br/> 
                                              <?php
                                                 $pending = checkProductAvaibilityByProductID($con,$row['id']);
                                                 $pQty = $row['qty']-$pending;
                                              ?>
                                              Pending Quantity :- <?php echo $pQty ?>
                                          </td>
                                          <td> <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image'] ?>"></td>
                                          <td>
                                             <?php

                                                if($row['status']==1){

                                                   echo "<a><button  class='btn btn-success' > Active </button></a>&nbsp;";
                                                }else{

                                                   echo "<a><button class='' > Deactive </button></a> &nbsp;";
                                                }
                                                   echo "&nbsp;<a href='add_product.php?id=".$row['id']."'><button class='btn btn-primary'> Edite </button></a> &nbsp;";

                                                   echo "<a href='?type=delete&id=".$row['id']."'><button class='btn btn-danger'> Delete </button></a> &nbsp;";
                                             ?>
                                          </td>
                                       </tr>
                                       <?php
                                           }
                                       ?>
                                       <tr></tr>
                                    </tbody>
                                 </table>
                                 <div class="clearfix">
                                   
                                 </div>
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