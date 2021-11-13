<?php 
require('top.inc.php');
$categories = '';
$msg = '';
$sub_categories = '';

if(isset($_GET['id']) && $_GET['id'] !=''){ 


   $id = get_safe_value($con,$_GET['id']);

   $sql = mysqli_query($con,"SELECT * FROM sub_categories WHERE id = '$id' "); 
   $check = mysqli_num_rows($sql);
   if($check>0){
      $row = mysqli_fetch_assoc($sql);
      $sub_categories = $row['sub_categories'];
      $categories = $row['categories_id'];

   }else{

       header('location:sub_categories.php');
       die();
   }

}

if(isset($_POST['submit'])){

   $categories = get_safe_value($con,$_POST['categories_id']);
   $sub_categories = get_safe_value($con,$_POST['sub_categories']); 

   $sql = mysqli_query($con,"SELECT * FROM sub_categories WHERE categories_id = '$categories' and sub_categories = '$sub_categories' "); 
   $check = mysqli_num_rows($sql);

   if($check>0){

       if(isset($_GET['id']) && $_GET['id'] !=''){ 

         $getData= mysqli_fetch_assoc($sql); 
         if($id == $getData['id']){ 

         }else{

             $msg = "Sub Categories allready Exist"; 
         }

       }else{

            $msg = "Sub Categories allready Exist";
       }

   }

   if($msg==''){  

       if(isset($_GET['id']) && $_GET['id'] !=''){

         mysqli_query($con,"UPDATE sub_categories SET categories_id = '$categories',sub_categories='$sub_categories' WHERE id = '$id'");
      }else{

         $sub =  mysqli_query($con,"INSERT INTO sub_categories(categories_id,sub_categories,status) VALUES('$categories','$sub_categories','1')"); 
      }
       header('location:sub_categories.php');
       die();
   }
}
 

?>
<div class="content pb-0">
      <div class="animated fadeIn">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header"><strong>Sub  Categories </strong><small> Form</small></div>
                    <form method="POST">  
                        <div class="card-body card-block">
                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Categories</label>
                                 <select name="categories_id" class="form-control" required>
                                    <option value=""> Select Categories</option>
                                    <?php 
                                       $res = mysqli_query($con,"SELECT * FROM categories WHERE status = '1' ");
                                       while($row=mysqli_fetch_assoc($res)){
                                          if($row['id']==$categories){
                                             echo "<option value=".$row['id']." selected>". $row['Categories']."</option>";
                                          }else{
                                             echo "<option value=".$row['id'].">". $row['Categories']."</option>";
                                          }
                                       }
                                    ?>
                                 </select>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Sub Categories </label>
                              <input type="text" name="sub_categories" placeholder="Enter Sub Categories" class="form-control" required value="<?php echo $sub_categories ?>">
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