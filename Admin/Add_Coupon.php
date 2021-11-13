<?php 
require('top.inc.php');

$coupon_code = '';
$coupon_value = '';
$coupon_type = '';
$cart_min_value = '';

$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){ 

   $image_required='';

   $id = get_safe_value($con,$_GET['id']);
  
   $sql = mysqli_query($con,"SELECT * FROM coupon_master WHERE id = '$id' "); 
   $check = mysqli_num_rows($sql);
   if($check>0){
      $row = mysqli_fetch_assoc($sql);

      $coupon_code = $row['coupon_code'];
      $coupon_value = $row['coupon_value'];
      $coupon_type = $row['coupon_type'];
      $cart_min_value = $row['cart_min_value'];

   }else{

       header('location:Coupon.php');
       die();
   }

}

if(isset($_POST['submit'])){

   $coupon_code = get_safe_value($con,$_POST['coupon_code']);
   $coupon_value = get_safe_value($con,$_POST['coupon_value']); //eneter ccategories by user 
   $coupon_type = get_safe_value($con,$_POST['coupon_type']);
   $cart_min_value = get_safe_value($con,$_POST['cart_min_value']);
   
   $sql = mysqli_query($con,"SELECT * FROM coupon_master WHERE coupon_code = '$coupon_code' "); // check coupon code already exist or not
   $check = mysqli_num_rows($sql);
   if($check>0){

       if(isset($_GET['id']) && $_GET['id'] !=''){ 

         $getData= mysqli_fetch_assoc($sql); 
         if($id == $getData['id']){  

         }else{

             $msg = "Coupon Code allready Exist"; //if you enter same coupon code available in database so it's show this message
         }

       }else{

            $msg = "Coupon Code allready Exist";
       }

   }


   if($msg==''){ 


       if(isset($_GET['id']) && $_GET['id'] !=''){

            $update_sql = mysqli_query($con,"UPDATE coupon_master SET coupon_code = '$coupon_code', coupon_value = '$coupon_value', coupon_type = '$coupon_type', cart_min_value = '$cart_min_value' WHERE id = '$id'"); 
       }else{

         $update_sql = mysqli_query($con,"INSERT INTO coupon_master(coupon_code,coupon_value,coupon_type,cart_min_value,status) VALUES('$coupon_code' , '$coupon_value' , '$coupon_type' , '$cart_min_value',1)");
      }
         header('location:Coupon.php');
       die();
   }
}


?>
<div class="content pb-0">
      <div class="animated fadeIn">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header"><strong> Coupon </strong><small> Form</small></div>
                    <form method="POST" enctype="multipart/form-data">  
                        <div class="card-body card-block">
                           
                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Coupon Code </label>
                              <input type="text" name="coupon_code" placeholder="Enter Coupon name" class="form-control" required value="<?php echo $coupon_code ?>">
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Coupon Value </label>
                              <input type="text" name="coupon_value" placeholder="Enter Coupon Value" class="form-control" required value="<?php echo $coupon_value ?>">
                           </div>
                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Coupon Type </label>
                              <select class=" form-control" name="coupon_type" required>
                                 <option value=""> Select Option</option>
                                 <?php
                                 if($coupon_type == 'Percentage'){

                                 echo '<option value="Percentage" selected> Percentage </option>
                                       <option value="Rupees"> Rupees </option>';

                                 }else if ($coupon_type == 'Rupees'){

                                 echo '<option value="Percentage"> Percentage </option>
                                       <option value="Rupees" selected> Rupees </option>';

                                 }else{

                                 echo '<option value="Percentage"> Percentage </option>
                                       <option value="Rupees"> Rupees </option>';

                                 }

                                 ?>
                              </select>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Cart Minimum Value </label>
                              <input type="text" name="cart_min_value" placeholder="Enter Cart Minimum Value" class="form-control" required value="<?php echo $cart_min_value ?>">
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
