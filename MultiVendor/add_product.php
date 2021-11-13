<?php
require('top.inc.php');

if(!isset($_SESSION['VENDOR_LOGIN'])){ ?>
    <script>
        window.location.href='Vendor_login.php';
    </script>
<?php
}

$categories_id = '';
$sub_categories_id = '';
$name = '';
$mrp = '';
$price = '';
//$final_price = '';
$qty = '';
$image = '';
$short_desc = '';
$long_desc = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$best_seller = '';

$msg = '';
$errimg='';
$image_required = 'required';

if(isset($_GET['id']) && $_GET['id'] !=''){ 

   $image_required='';

   $id = get_safe_value($con,$_GET['id']);
  
   $sql = mysqli_query($con,"SELECT * FROM product WHERE id = '$id'  and product.added_by = '".$_SESSION['VENDOR_ID']."'"); 
   $check = mysqli_num_rows($sql);
   if($check>0){
      $row = mysqli_fetch_assoc($sql);

      $categories_id = $row['categories_id'];
      $categories_id = $row['sub_categories_id'];
      $name = $row['name'];
      $mrp = $row['mrp'];
      $price = $row['vendor_price'];
     // $final_price = $price+($price*15/100);
      $qty = $row['qty'];
      $short_desc = $row['short_desc'];
      $long_desc = $row['long_desc'];
      $meta_title = $row['meta_title'];
      $meta_desc = $row['meta_desc'];
      $meta_keyword = $row['meta_keyword'];
      $best_seller = $row['best_seller'];

   }else{

       header('location:Product.php');
       die();
   }

}

if(isset($_POST['submit'])){


   $categories_id = get_safe_value($con,$_POST['categories_id']);
   $sub_categories_id = get_safe_value($con,$_POST['sub_categories_id']); //eneter ccategories by user 
   $name = get_safe_value($con,$_POST['name']);
   $mrp = get_safe_value($con,$_POST['mrp']);
   $price = get_safe_value($con,$_POST['price']);
//   $final_price = get_safe_value($con,$_POST['final_price']);
   $qty = get_safe_value($con,$_POST['qty']);
   $short_desc = get_safe_value($con,$_POST['short_desc']);
   $long_desc = get_safe_value($con,$_POST['long_desc']);
   $meta_title = get_safe_value($con,$_POST['meta_title']);
   $meta_desc = get_safe_value($con,$_POST['meta_desc']);
   $meta_keyword = get_safe_value($con,$_POST['meta_keyword']);
   $best_seller = get_safe_value($con,$_POST['best_seller']);




   $sql = mysqli_query($con,"SELECT * FROM product WHERE name = '$name' "); // fetch data with categories exist or not
   $check = mysqli_num_rows($sql);
   if($check>0){

       if(isset($_GET['id']) && $_GET['id'] !=''){ //fetch id using line 29

         $getData= mysqli_fetch_assoc($sql); 
         if($id == $getData['id']){ //get id from categories tabel using 29 query 


         }else{

             $msg = "Product allready Exist"; //if enter same categories is allready exist in tabel so its show this message
         }

       }else{

            $msg = "Product allready Exist";
       }

   }


if($_FILES['image']['type'] !='' && ($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg')){

   $msg= "Please select Only PNG,JPG and JPEG formate ";
}

   if($msg==''){ 


       if(isset($_GET['id']) && $_GET['id'] !=''){

         if($_FILES['image']['name'] !=''){

            $image = rand(11111,99999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image);

            $update_sql = mysqli_query($con,"UPDATE product SET categories_id = '$categories_id', sub_categories_id = '$sub_categories_id',name = '$name',mrp = '$mrp',vendor_price = '$price', qty = '$qty',image = '$image',best_seller = '$best_seller' ,short_desc = '$short_desc',long_desc = '$long_desc',meta_title = '$meta_title',meta_desc = '$meta_desc',meta_keyword = '$meta_keyword' added_by='".$_SESSION['VENDOR_ID']."' WHERE id = '$id'"); 
         }else{

            $update_sql = mysqli_query($con,"UPDATE product SET categories_id = '$categories_id', sub_categories_id = '$sub_categories_id' ,name = '$name',mrp = '$mrp',vendor_price = '$price', qty = '$qty',best_seller = '$best_seller',short_desc = '$short_desc',long_desc = '$long_desc',meta_title = '$meta_title',meta_desc = '$meta_desc',meta_keyword = '$meta_keyword' , added_by='".$_SESSION['VENDOR_ID']."' WHERE id = '$id'");
         }
      }else{

         $image = rand(11111,99999).'_'.$_FILES['image']['name'];
         move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image);

             echo "INSERT INTO product(categories_id,sub_categories_id, name,mrp,vendor_price, qty,image,short_desc,long_desc,meta_title,meta_desc,meta_keyword,status,best_seller) VALUES('$categories_id', '$sub_categories_id', '$name','$mrp','$price',$qty','$image','$short_desc','$long_desc','$meta_title','$meta_desc','$meta_keyword','1','$best_seller')"; 

             die();

            mysqli_query($con,"INSERT INTO product(categories_id,sub_categories_id, name,mrp,vendor_price, qty,image,short_desc,long_desc,meta_title,meta_desc,meta_keyword,status,best_seller,added_by) VALUES('$categories_id', '$sub_categories_id', '$name','$mrp','$price',$qty','$image','$short_desc','$long_desc','$meta_title','$meta_desc','$meta_keyword','1','$best_seller','".$_SESSION['VENDOR_ID']."')"); 
      }
         header('location:product.php');
       die();
   }
}


?>
<div class="content pb-0">
      <div class="animated fadeIn">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header"><strong> Product </strong><small> Form</small></div>
                    <form method="POST" enctype="multipart/form-data">  
                        <div class="card-body card-block">
                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Categories</label>
                              <select class=" form-control" name="categories_id" id="categories_id" onclick="get_sub_cat('')">
                                 <option> Select Categories</option>
                                 <?php

                                    $res = mysqli_query($con,"SELECT id,Categories from categories order by Categories desc");
                                    while($row=mysqli_fetch_assoc($res)){
                                       if($row['id']== $categories_id){
                                          echo "<option selected value=".$row['id'].">".$row['Categories']."</option>";
                                       }else{
                                          echo "<option value=".$row['id'].">".$row['Categories']."</option>";
                                       }
                                    }
                                 ?>
                              </select>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Sub Categories</label>
                              <select class=" form-control" name="sub_categories_id" id="sub_categories_id">
                                 <option value=""> Select Sub Categories </option>
                              
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Product Name </label>
                              <input type="text" name="name" placeholder="Enter Product name" class="form-control" required value="<?php echo $name ?>">
                           </div>
                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Best Seller </label>
                              <select class=" form-control" name="best_seller" required>
                                 <option value=""> Select Option</option>
                                 <?php
                                 if($best_seller == 1){

                                 echo '<option value="1" selected> YES </option>
                                       <option value="0"> NO </option>';

                                 }else if ($best_seller == 0){

                                 echo '<option value="1"> YES </option>
                                       <option value="0" selected> NO </option>';

                                 }else{

                                 echo '<option value="1"> YES </option>
                                       <option value="0"> NO </option>';

                                 }

                                 ?>
                              </select>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> MRP </label>
                              <input type="text" name="mrp" placeholder="Enter Product MRP" class="form-control" required value="<?php echo $mrp ?>">
                           </div>
                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Price </label>
                              <input type="text" name="price" placeholder="Enter Categories name" class="form-control" required value="<?php echo $price ?>">
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> QTY</label>
                              <input type="text" name="qty" placeholder="Enter Categories name" class="form-control" required value="<?php echo $qty ?>">
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> IMAGE </label>
                              <input type="file" name="image" placeholder="Enter Product Image" class="form-control"  value="<?php echo $image_required ?>">
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Short Description</label>
                              <textarea name="short_desc" placeholder="Enter Short Description" class="form-control"  value="<?php echo $short_desc ?>"> <?php echo $short_desc ?> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Description </label>
                              <textarea name="long_desc" class="form-control"  value="<?php echo $long_desc ?>"><?php echo $long_desc ?> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Meta Title </label>
                              <textarea name="meta_title" placeholder="Enter Meta Title" class="form-control"  value="<?php echo $meta_title ?>"> <?php echo $meta_title ?> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Meta Description </label>
                              <textarea name="meta_desc" placeholder="Enter Meta Description" class="form-control"  value="<?php echo $meta_desc ?>"> <?php echo $meta_desc ?> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Meta Keywords </label>
                              <textarea name="meta_keyword" placeholder="Enter Meta Keyword" class="form-control" value="<?php echo $meta_keyword ?>"> <?php echo $meta_keyword ?> </textarea>
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
<script>
   
   function get_sub_cat(sub_cat_id){
      var categories_id = jQuery('#categories_id').val();
      jQuery.ajax({
         url : 'get_sub_cat.php',
         type : 'POST',
         data : 'categories_id='+categories_id+'&sub_categories_id='+sub_cat_id,
         success : function(result){
            jQuery('#sub_categories_id').html(result);
         }
      });
   }
</script>

<?php
require('footer.inc.php');
?>
<script>
   <?php 
      if(isset($_GET['id'])){ ?>
         get_sub_cat('<?php echo $sub_categories_id ?>');
   <?php } ?>
</script>