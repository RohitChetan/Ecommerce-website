<?php 
require('top.inc.php');
$sub_categories = '';
$color = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){ 


   $id = get_safe_value($con,$_GET['id']);

   $sql = mysqli_query($con,"SELECT * FROM color WHERE id = '$id' "); 
   $check = mysqli_num_rows($sql);
   if($check>0){
      $row = mysqli_fetch_assoc($sql);
      $sub_categories = $row['Sub_category_id'];
      $color = $row['color'];

   }else{

       header('location:Color.php');
       die();
   }

}

if(isset($_POST['submit'])){

   $sub_categories = get_safe_value($con,$_POST['sub_categories']); 
   $color = get_safe_value($con,$_POST['color']);

   $sql = mysqli_query($con,"SELECT * FROM color WHERE Sub_category_id = '$sub_categories' and color = '$color' "); 
   $check = mysqli_num_rows($sql);

   if($check>0){

       if(isset($_GET['id']) && $_GET['id'] !=''){ 

         $getData= mysqli_fetch_assoc($sql); 
         if($id == $getData['id']){ 

         }else{

             $msg ="Color id allready Exist"; 
         }

       }else{

            $msg = "Color is allready Exist";
       }

   }

   if($msg==''){  

       if(isset($_GET['id']) && $_GET['id'] !=''){

         mysqli_query($con,"UPDATE color SET Sub_category_id = '$sub_categories',color = '$color' WHERE id = '$id'");
      }else{

         $sub =  mysqli_query($con,"INSERT INTO color(Sub_category_id,color,status) VALUES('$sub_categories','$color','1')"); 
      }
       header('location:Color.php');
       die();
   }
}
 

?>
<div class="content pb-0">
      <div class="animated fadeIn">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
  *                <div class="card-header"><strong>Sub  Categories </strong><small> Form</small></div>
                    <form method="POST">  
                        <div class="card-body card-block">
                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Categories</label>
                                 <select name="sub_categories" class="form-control" required>
                                    <option value=""> Select Categories</option>
                                    <?php 
                                       $res = mysqli_query($con,"SELECT * FROM sub_categories WHERE status = '1' ");
                                       while($row=mysqli_fetch_assoc($res)){
                                          if($row['id']==$sub_categories){
                                             echo "<option value=".$row['id']." selected>". $row['sub_categories']."</option>";
                                          }else{
                                             echo "<option value=".$row['id'].">". $row['sub_categories']."</option>";
                                          }
                                       }
                                    ?>
                                 </select>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> COLOR </label>
                              <input type="text" name="color" placeholder="Enter COLOR" class="form-control" required value="<?php echo $color ?>">
                           </div>

                           <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" name="submit">
                              <span id="payment-button-amount">Submit</span>
                           </button>
                           <div class="Errormsg"> <?php echo $msg  ?></div>
                        </div>
                    </form>
                  </div>
               </div>
            </div> 
         </div>
      </div>
</div>


           
<?php

require('footer.inc.php');
?>