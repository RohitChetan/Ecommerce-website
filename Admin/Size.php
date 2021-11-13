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

      $operation = get_safe_value($con,$_GET['operation']);
      $id = get_safe_value($con,$_GET['id']);

      if($operation=='active'){

         $status = '1';
      }else{

         $status = '0';
      }
 
      $update = "UPDATE size_attr SET status='$status' WHERE id='$id'";
       mysqli_query($con,$update);
   }

   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $delete = "DELETE FROM size_attr WHERE id='$id'";
       mysqli_query($con,$delete);
   }
}

$total = mysqli_num_rows(mysqli_query($con,"SELECT size_attr.*,sub_categories.sub_categories FROM size_attr,sub_categories  WHERE size_attr.sub_cate_id = sub_categories.id order by id desc"));

$page = ceil($total/$per_page);

$sql = "SELECT size_attr.*,sub_categories.sub_categories FROM size_attr,sub_categories  WHERE size_attr.sub_cate_id = sub_categories.id order by id desc  LIMIT $start,$per_page";
$res = mysqli_query($con,$sql);
?>

            <div class="content pb-0">
               <div class="orders">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="box-title"> SIZE VARIATIONS </h4>
                              <h4 class="box-link"><a href="add_sub_categories.php"> Add SIZE </a></h4>
                           </div>
                           <div class="card-body--">
                              <div class="table-stats order-table ov-h">
                                 <table class="table ">
                                    <thead>
                                       <tr>
                                          <th class="serial">#</th>
                                          <th class="avatar">ID</th>
                                          <th>SUB CATEGORIES</th>
                                          <th> SIZE </th>
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
                                          <td> <?php echo $row['sub_categories'] ?> </td>
                                          <td> <?php echo $row['Size'] ?> </td>
                                          <td> <?php echo $row['status'] ?> </td>
                                          <td>
                                             <?php

                                                if($row['status']==1){

                                                   echo "<a href='?type=status&operation=deactive&id=".$row['id']."'><button class='btn btn-success' > Active </button></a>&nbsp;";
                                                }else{

                                                   echo "<a href='?type=status&operation=active&id=".$row['id']."'><button class='' > Deactive </button></a> &nbsp;";
                                                }
                                                   echo "<a href='?type=delete&id=".$row['id']."'><button class='btn btn-danger'> Delete </button></a> &nbsp;";

                                                   echo "&nbsp;<a href='add_sub_categories.php?id=".$row['id']."'><button class='btn btn-primary'> Edite </button></a> &nbsp;";
                                             

                                             ?>
                                          </td>
                                       </tr>
                                       <?php
                                           }
                                       ?>
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
                                          }else{

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