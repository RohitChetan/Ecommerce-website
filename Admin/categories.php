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

      $update = "UPDATE categories SET status='$status' WHERE id='$id'";
       mysqli_query($con,$update);
   }

   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $delete = "DELETE FROM categories WHERE id='$id'";
       mysqli_query($con,$delete);
   }
}

$sql = "SELECT * FROM categories order by Categories desc";
$res = mysqli_query($con,$sql);
?>

            <div class="content pb-0">
               <div class="orders">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="box-title"> Categories </h4>
                              <h4 class="box-link"><a href="add_categories.php"> Add Categories </a></h4>
                           </div>
                           <div class="card-body--">
                              <div class="table-stats order-table ov-h">
                                 <table class="table ">
                                    <thead>
                                       <tr>
                                          <th class="serial">#</th>
                                          <th class="avatar">ID</th>
                                          <th>CATEGORIES</th>
                                          <th>STATUS</th>
                                          <th> ACTIONS </th>
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