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

      $update = "UPDATE coupon_master SET status='$status' WHERE id='$id'";
       mysqli_query($con,$update);
   }

   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $delete = "DELETE FROM coupon_master WHERE id='$id'";
       mysqli_query($con,$delete);
   }
}

$sql = "SELECT * FROM coupon_master order by id desc";


$res = mysqli_query($con,$sql);
?>

            <div class="content pb-0">
               <div class="orders">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="box-title"> Coupon </h4>
                              <h4 class="box-link"><a href="add_Coupon.php"> Add Coupon </a></h4>
                           </div>
                           <div class="card-body--">
                              <div class="table-stats order-table ov-h">
                                 <table class="table ">
                                    <thead>
                                       <tr>
                                          <th class="serial">#</th>
                                          <th class="avatar">ID</th>
                                          <th>Coupon CODE</th>
                                          <th> Coupon Value </th>
                                          <th> Coupon Type </th>
                                          <th> Min Value </th>
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
                                          <td> <?php echo $row['coupon_code'] ?> </td>
                                          <td> <?php echo $row['coupon_value'] ?> </td>
                                          <td> <?php echo $row['coupon_type'] ?> </td>
                                          <td> <?php echo $row['cart_min_value'] ?> </td>
                                          <td>
                                             <?php

                                                if($row['status']==1){
 
                                                   echo "<a href='?type=status&operation=deactive&id=".$row['id']."'><button  class='btn btn-success' > Active </button></a>&nbsp;";
                                                }else{

                                                   echo "<a href='?type=status&operation=active&id=".$row['id']."'><button class='' > Deactive </button></a> &nbsp;";
                                                }
                                                   echo "&nbsp;<a href='add_Coupon.php?id=".$row['id']."'><button class='btn btn-primary'> Edite </button></a> &nbsp;";

                                                   echo "<a href='?type=delete&id=".$row['id']."'><button class='btn btn-danger'> Delete </button></a> &nbsp;";
                                             ?>
                                          </td>
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