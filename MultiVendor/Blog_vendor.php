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

      $update = "UPDATE blogpost SET status='$status' WHERE id='$id' and blogpost.added_by = '".$_SESSION['VENDOR_ID']."'";
       mysqli_query($con,$update);
   }

   if($type=='delete'){

      $id = get_safe_value($con,$_GET['id']);
      $delete = "DELETE FROM blogpost WHERE id='$id' blogpost.added_by = '".$_SESSION['VENDOR_ID']."'";
       mysqli_query($con,$delete);
   }
}

$total = mysqli_query($con,"SELECT  * FROM  blogpost WHERE added_by ='".$_SESSION['VENDOR_ID']."' order by id desc");


?>

            <div class="content pb-0">
               <div class="orders">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="box-title"> Product </h4>
                              <h4 class="box-link"><a href="add_blogpost.php"> Add BLOGPOST </a></h4>
                           </div>
                           <div class="card-body--">
                              <div class="table-stats order-table ov-h">
                                 <table class="table ">
                                    <thead>
                                       <tr>
                                          <th class="serial">#</th>
                                          <th class="avatar">ID</th>
                                          <th>Title</th>
                                          <th> Blog </th>
                                          <th> keyword </th>
                                          <th> label </th>
                                          <th> Image </th>
                                          <th> Post date</th>
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
                                          <td> <?php echo $row['Blog_Title'] ?> </td>
                                          <td> <?php echo $row['Blog_text'] ?> </td>
                                          <td> <?php echo $row['blog_keywords '] ?> </td>
                                          <td> <?php echo $row['label'] ?> </td>
                                          <td> <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image'] ?>"></td>
                                          <td> <?php echo $row['post_date'] ?> <br/> </td>
                                          <td>
                                             <?php

                                                if($row['status']==1){

                                                   echo "<a><button  class='btn btn-success' > Active </button></a>&nbsp;";
                                                }else{

                                                   echo "<a><button class='' > Deactive </button></a> &nbsp;";
                                                }
                                                   echo "&nbsp;<a href='add_blogpost.php?id=".$row['id']."'><button class='btn btn-primary'> Edite </button></a> &nbsp;";

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