<?php 
require('top.inc.php');

$per_page = 4;
$start = 0;
$current = 1;

if(isset($_GET['start'])){

     $start = $_GET['start'];
     $current = $start;
     $start --;
     $start = $start*$per_page;
}

if(isset($_GET['type']) && $_GET['type'] !=''){

   $type = get_safe_value($con,$_GET['type']);

   if($type=='status'){

      $operation = mysqli_real_escape_string($con,$_GET['operation']);
      $id = mysqli_real_escape_string($con,$_GET['id']);

      if($operation=='active'){

         $status = '1';
      }else{

         $status = '0';
      }

      $update = "UPDATE product SET status='$status' WHERE id='$id'";
       mysqli_query($con,$update);
   }

   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $check = mysqli_query($con,"SELECT image,Product_Images FROM product,products_images WHERE  product.id = '$id' and products_images.id = '$id'");

      $count = mysqli_num_rows($check);

      if($count > 0){

         $row = mysqli_fetch_assoc($check);

         $images = $row['image'];
         $product_Images = $row['Product_Images'];

            unlink(PRODUCT_MULTIIMAGE_SERVER_PATH.$product_Images);
            unlink(PRODUCT_IMAGE_SERVER_PATH.$images);

          $delete = "DELETE FROM product,products_images WHERE product.id='$id' and products_images.id = '$id'";  
          mysqli_query($con,$delete);
      }
      //$delete = "DELETE FROM product,products_images WHERE product.id='$id' and products_images.id = '$id'";
   }
}

$total = mysqli_num_rows(mysqli_query($con,"SELECT  product.*,categories.Categories FROM product,categories where product.categories_id = categories.id order by product.id desc"));

$page = ceil($total/$per_page);

$sql = "SELECT  product.*,categories.Categories FROM product,categories where product.categories_id = categories.id order by product.id desc LIMIT $start,$per_page";


$res = mysqli_query($con,$sql);
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
                                           while ($row=mysqli_fetch_assoc($res)) {
                                       ?>
                                       <tr>
                                          <td class="serial"> <?php echo $i++ ?> </td>
                                          <td> <?php echo $row['id'] ?></td>
                                          <td> <?php echo $row['Categories'] ?> </td>
                                          <td> <?php echo $row['name'] ?> </td>
                                          <td> <?php echo $row['mrp'] ?> <br/> 
                                             Vendor :- <?php echo $row['vendor_price'] ?> </td>

                                          <td> <?php echo $row['price'] ?> </td>
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

                                                   echo "<a href='?type=status&operation=deactive&id=".$row['id']."'><button  class='btn btn-success' > Active </button></a>&nbsp;";
                                                }else{

                                                   echo "<a href='?type=status&operation=active&id=".$row['id']."'><button class='' > Deactive </button></a> &nbsp;";
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
                                    <ul class="pagination" style="margin-left: 850px;">
                                          <?php
                                                if(mysqli_num_rows($res)>0){
                                                for ($i=1; $i <= $page ; $i++) { 
                                                 $class = '';
                                                if($current == $i){
                                                    $class = 'active';
                                                }
                                           ?>
                                           <li class="page-item <?php echo $class ?>"><a href="?start=<?php echo $i ?>" class="page-link"><?php echo $i;  ?></a></li> &nbsp;
                                          <?php
                                             }
                                          } else{

                                                echo " No records Found";
                                             }
                                           
                                          ?>
                                    </ul>
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