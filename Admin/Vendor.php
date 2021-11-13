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

      $update = "UPDATE vendor_registration SET status='$status' WHERE id='$id'";
       mysqli_query($con,$update);
   }

   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $delete = "DELETE FROM vendor_registration WHERE id='$id'";
       mysqli_query($con,$delete);
   }
}

$sql = "SELECT * FROM vendor_registration order by id desc";
$res = mysqli_query($con,$sql);
?>

            <div class="content pb-0">
               <div class="orders">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="box-title"><strong> VENDOR  DATA </strong></h4>
                              
                           </div>
                           <div class="card-body--">
                              <div class="table-stats order-table ov-h">
                                 <table class="table ">
                                    <thead>
                                       <tr>
                                          <th class="serial">#</th>
                                          <th class="avatar">ID</th>
                                          <th>VENDOR NAME</th>
                                          <th> EMAIL </th>
                                          <th> MOBILE</th>
                                          <th> GENDER </th>
                                          <th>STATUS</th>
                                          <th> ACTIONS </th>
                                       </tr>
                       -             </thead>
                                    <tbody>
                                       <?php
                                          $i=1;
                                           while ($row=mysqli_fetch_assoc($res)) {
                                       ?>
                                       <tr>
                                          <td class="serial"> <?php echo $i++ ?> </td>
                                          <td> <?php echo $row['id'] ?></td>
                                          <td> <?php echo $row['name'] ?> </td>
                                          <td> <?php echo $row['email'] ?> </td>
                                          <td> <?php echo $row['mobile'] ?> </td>
                                          <td> <?php echo $row['gender'] ?> </td>
                                          <td> <?php echo $row['status'] ?> </td>
                                          <td>
                                             <?php

                                                if($row['status']==1){

                                                   echo "<a href='?type=status&operation=deactive&id=".$row['id']."'><button class='btn btn-success' > Active </button></a>&nbsp;";
                                                }else{

                                                   echo "<a href='?type=status&operation=active&id=".$row['id']."'><button class='' > Deactive </button></a> &nbsp;";
                                                }
                                                   echo "<a href='?type=delete&id=".$row['id']."'><button class='btn btn-danger'> Delete </button></a> &nbsp;";

                                                   echo "&nbsp;<a href='add_categories.php?id=".$row['id']."'><button class='btn btn-primary'> Edite </button></a> &nbsp;";
                                             

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