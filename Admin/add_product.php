<?php 
require('top.inc.php');


$categories_id = '';
$color_id = '';
$sub_categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$long_desc = ''; 
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$best_seller = '';
$Product_Image = '';
$multi_ImageArr = [];

$msg = '';
$errimg='';
$image_required = 'required';

if(isset($_GET['pid']) && $_GET['pid']>0){

    $pid = get_safe_value($con,$_GET['pid']);
    $data = mysqli_query($con,"SELECT Product_Images FROM products_images WHERE id='$pid'");

    if(mysqli_num_rows($data)>0){

      $row = mysqli_fetch_assoc($data);

      $del_image = $row['Product_Images'];

      unlink(PRODUCT_MULTIIMAGE_SERVER_PATH.$del_image);

    }

    mysqli_query($con,"DELETE FROM products_images WHERE id = '$pid'");
}


if(isset($_GET['id']) && $_GET['id'] !=''){ 

   $image_required='';

   $id = get_safe_value($con,$_GET['id']);
  
   //$sql = mysqli_query($con,"SELECT product.*,Product_Images.color_id FROM product,Product_Images WHERE products_images.product_id = '$id' and id = '$id' "); 

   $sql = mysqli_query($con,"SELECT product.*,products_images.color_id FROM product,products_images WHERE product.id = products_images.product_id");

   

   $check = mysqli_num_rows($sql);
   if($check>0){
      $row = mysqli_fetch_assoc($sql);

      $categories_id = $row['categories_id'];
      $color_id = $row['color_id'];
      $categories_id = $row['sub_categories_id'];
      $name = $row['name'];
      $mrp = $row['mrp'];
      $price = $row['price'];
      $qty = $row['qty'];
      $short_desc = $row['short_desc'];
      $long_desc = $row['long_desc'];
      $meta_title = $row['meta_title'];
      $meta_desc = $row['meta_desc'];
      $meta_keyword = $row['meta_keyword'];
      $best_seller = $row['best_seller'];
      $image = $row['image'];

      $product_muliple_images = mysqli_query($con,"SELECT id,Product_Images FROM products_images WHERE product_id = '$id'");

      if(mysqli_num_rows($product_muliple_images) > 0){

         $a=0;
         while($row_product_multi_Image = mysqli_fetch_assoc($product_muliple_images)){

            $multi_ImageArr[$a]['id'] = $row_product_multi_Image['id'];
            $multi_ImageArr[$a]['Product_images'] = $row_product_multi_Image['Product_Images'];
              
             $a++;
         }
      }

   }else{

       header('location:Product.php');
       die();
   }

}

/*pr($multi_ImageArr);
*/

if(isset($_POST['submit'])){

  /*pr($_FILES);
   prx($_POST);
*/

   $categories_id = get_safe_value($con,$_POST['categories_id']);
   $color_id = get_safe_value($con,$_POST['color_id']);
   $sub_categories_id = get_safe_value($con,$_POST['sub_categories_id']); //eneter ccategories by user 
   $name = get_safe_value($con,$_POST['name']);
   $mrp = get_safe_value($con,$_POST['mrp']);
   $price = get_safe_value($con,$_POST['price']);
   $qty = get_safe_value($con,$_POST['qty']);
   $short_desc = get_safe_value($con,$_POST['short_desc']);
   $long_desc = get_safe_value($con,$_POST['long_desc']);
   $meta_title = get_safe_value($con,$_POST['meta_title']);
   $meta_desc = get_safe_value($con,$_POST['meta_desc']);
   $meta_keyword = get_safe_value($con,$_POST['meta_keyword']);
   $best_seller = get_safe_value($con,$_POST['best_seller']);

   //$Multi = get_safe_value($con,$_POST['Multi_id']);   



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


if(isset($_FILES['image'])){
   if($_FILES['image']['type'] !='' && ($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg')){

   $msg= "Please select Only PNG,JPG and JPEG formate ";

   }

}


if(isset($_FILES['Product_image'])){

   foreach ($_FILES['Product_image']['type'] as $key => $value) {
      
      if($_FILES['Product_image']['type'][$key] != ''){
         if($_FILES['Product_image']['type'][$key] != '' && ($_FILES['Product_image']['type'][$key] != 'image/jpeg' && $_FILES['Product_image']['type'][$key] != 'image/png' && $_FILES['Product_image']['type'][$key] != 'image/jpg')){

            $msg = " Please Select Products  Multiple Images Only PNG,JPG, and JPEG formate";

         }
      }
   }
}


   if($msg==''){ 


       if(isset($_GET['id']) && $_GET['id'] !=''){

         if($_FILES['image']['name'] !=''){

            $image = rand(11111,99999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image);

            $update_sql = mysqli_query($con,"UPDATE product SET categories_id = '$categories_id', sub_categories_id = '$sub_categories_id',name = '$name',mrp = '$mrp',price = '$price',qty = '$qty',image = '$image',best_seller = '$best_seller' ,short_desc = '$short_desc',long_desc = '$long_desc',meta_title = '$meta_title',meta_desc = '$meta_desc',meta_keyword = '$meta_keyword' WHERE id = '$id'"); 
         }else{

            $update_sql = mysqli_query($con,"UPDATE product SET categories_id = '$categories_id', sub_categories_id = '$sub_categories_id' ,name = '$name',mrp = '$mrp',price = '$price',qty = '$qty',best_seller = '$best_seller',short_desc = '$short_desc',long_desc = '$long_desc',meta_title = '$meta_title',meta_desc = '$meta_desc',meta_keyword = '$meta_keyword' WHERE id = '$id'");
         }
      }else{

         $image = rand(11111,99999).'_'.$_FILES['image']['name'];
         move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image);


         /*echo "INSERT INTO product(categories_id,sub_categories_id, name,mrp,price,qty,image,short_desc,long_desc,meta_title,meta_desc,meta_keyword,status,best_seller) VALUES('$categories_id', '$sub_categories_id', '$name','$mrp','$price','$qty','$image','$short_desc','$long_desc','$meta_title','$meta_desc','$meta_keyword','1','$best_seller')";*/

         mysqli_query($con,"INSERT INTO product(categories_id,sub_categories_id, name,mrp,price,qty,image,short_desc,long_desc,meta_title,meta_desc,meta_keyword,status,best_seller) VALUES('$categories_id', '$sub_categories_id', '$name','$mrp','$price','$qty','$image','$short_desc','$long_desc','$meta_title','$meta_desc','$meta_keyword','1','$best_seller')"); 

          
          
          $id = mysqli_insert_id($con);
      }

/*  Multiple Product Images insert code here*/

  if(isset($_GET['id']) && $_GET['id'] !=''){

      foreach ($_FILES['Product_image']['name'] as $key => $value) {

         if($_FILES['Product_image']['name'][$key] != ''){

            if(isset($_POST['Multi_id'][$key])){

               $Product_Image = rand(11111,99999).'_'.$_FILES['Product_image']['name'][$key];
               move_uploaded_file($_FILES['Product_image']['tmp_name'][$key], PRODUCT_MULTIIMAGE_SERVER_PATH.$Product_Image);

               mysqli_query($con,"UPDATE products_images SET Product_Images = '$Product_Image' WHERE id='".$_POST['Multi_id'][$key]."'");
               
            }else{

               $Product_Image = rand(111,999).'_'.$_FILES['Product_image']['name'][$key];
               move_uploaded_file($_FILES['Product_image']['tmp_name'][$key], PRODUCT_MULTIIMAGE_SERVER_PATH.$Product_Image);

               mysqli_query($con,"INSERT INTO products_images(Product_id,Product_Images,color_id) VALUES('$id','$Product_Image','$color_id')");
            }

         }

      }

   }else{

      if(isset($_FILES['Product_image']['name'])){

         foreach ($_FILES['Product_image']['name'] as $key => $value) {

            $Product_Image = rand(111,999).'_'.$_FILES['Product_image']['name'][$key];
            move_uploaded_file($_FILES['Product_image']['tmp_name'][$key], PRODUCT_MULTIIMAGE_SERVER_PATH.$Product_Image);

            mysqli_query($con,"INSERT INTO products_images(Product_id,Product_Images,color_id) VALUES('$id','$Product_Image','$color_id')");
            
         } 
      }      
   }
/* Multiple Product Images Code End here */

      ?>
      <script>
         window.location.href = 'product.php';
      </script>         
       <?php
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
                              <label for="categories" class=" form-control-label">Product Name </label>
                              <input type="text" name="name" placeholder="Enter Product name" class="form-control" required value="<?php echo $name ?>">
                           </div>

                           <div class="form-group">
                              <div class="row">
                                 <div class="col-lg-6">
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

                                 <div class="col-lg-6">
                                    <label for="categories" class=" form-control-label"> Sub Categories</label>
                                    <select class=" form-control" name="sub_categories_id" id="sub_categories_id">
                                       <option value=""> Select Sub Categories </option>
                                 
                                       </select>
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="row">
                                 <div class="col-lg-3"> 
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

                                 <div class="col-lg-3"> 
                                    <label for="categories" class=" form-control-label"> MRP </label>
                                       <input type="text" name="mrp" placeholder="Enter Product MRP" class="form-control" required value="<?php echo $mrp ?>">
                                 </div>

                                 <div class="col-lg-3"> 
                                    <label for="categories" class=" form-control-label"> Price </label>
                                       <input type="text" name="price" placeholder="Enter Categories name" class="form-control" required value="<?php echo $price ?>">
                                 </div>

                                 <div class="col-lg-3">
                                    <label for="categories" class=" form-control-label"> QTY</label>
                                       <input type="text" name="qty" placeholder="Enter Categories name" class="form-control" required value="<?php echo $qty ?>">
                                 </div>

                              </div>

                           </div>

                           <div class="form-group">
                              <div class="row">
                                 <div class="col-lg-6">
                                    <label for="categories" class=" form-control-label"> Color </label>
                                       <select class=" form-control" name="color_id" id="categories_id" onclick="get_sub_cat('')">
                                       <option> Select COLOR</option>
                                          <?php

                                             $res = mysqli_query($con,"SELECT id,color from color order by color desc");
                                             while($row=mysqli_fetch_assoc($res)){
                                                if($row['id']== $color_id){
                                                   echo "<option selected value=".$row['id'].">".$row['color']."</option>";
                                                }else{
                                                   echo "<option value=".$row['id'].">".$row['color']."</option>";
                                                }
                                             }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              
                           </div>

                           <div class="form-group">
                              <div class="row" id="image_box">
                                 <div class="col-lg-8"> 
                                    <label for="categories" class=" form-control-label"> IMAGE </label>
                                       <input type="file" name="image" placeholder="Enter Product Image" class="form-control"  value="<?php echo $image_required ?>">
                                       <?php 

                                       if($image != ''){

                                          echo "<Image src='".PRODUCT_IMAGE_SITE_PATH.$image."'width='100px' height='50px' />";
                                       }
                                       ?>
                                 </div>
                                 <div class="col-lg-3">
                                    <label for="categories" class=" form-control-label"> </label>
                                    <button  type="button" class="btn btn-lg btn-info btn-block" onclick="Add_Image()">
                                       <span id="payment-button-amount">Add Image</span>
                                    </button>
                                 </div>
                               <?php 

                                 if(isset($multi_ImageArr[0])){

                                    foreach ($multi_ImageArr as $list) {
                                       
                                       echo '<div class="col-lg-4" id="add_image_box'.$list['id'].'"> <label for="categories" class=" form-control-label"> IMAGE </label><input type="file" name="Product_image[]" placeholder="Enter Product Image" class="form-control"> <a href="add_product.php?id='.$id.'&pid='.$list['id'].'" ><button  type="button" class="btn btn-lg btn-info btn-block" onclick="Remove_Image("'.$list['id'].'")"> <span id="payment-button-amount">Remove</span></button></a><Image src="'.PRODUCT_MULTIIMAGE_SITE_PATH.$list['Product_images'].'" width="100px" height="50px" />';

                                       echo '<input type="hidden" name="Multi_id[]" value="'.$list['id'].'" style="display:none;" > </div>';
                                                                                             
                                    }
                                 }

                              ?>
                              </div>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Short Description</label>
                              <textarea name="short_desc" placeholder="Enter Short Description" class="form-control"  value="<?php echo $short_desc ?>"> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Description </label>
                              <textarea name="long_desc" placeholder="Enter Description" class="form-control"  value="<?php echo $long_desc ?>"> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Meta Title </label>
                              <textarea name="meta_title" placeholder="Enter Meta Title" class="form-control"  value="<?php echo $meta_title ?>"> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Meta Description </label>
                              <textarea name="meta_desc" placeholder="Enter Meta Description" class="form-control"  value="<?php echo $meta_desc ?>"> </textarea>
                           </div>

                            <div class="form-group">
                              <label for="categories" class=" form-control-label"> Meta Keywords </label>
                              <textarea name="meta_keyword" placeholder="Enter Meta Keyword" class="form-control" value="<?php echo $meta_keyword ?>"> </textarea>
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

   var total = 1;
   function Add_Image(){

      total++;
      var html ='<div class="col-lg-4" id="add_image_box'+total+'"> <label for="categories" class=" form-control-label"> IMAGE </label><input type="file" name="Product_image[]" placeholder="Enter Product Image" class="form-control"> <button  type="button" class="btn btn-lg btn-info btn-block" onclick="Remove_Image('+total+')"> <span id="payment-button-amount">Remove Image</span></button></div>';

      var html = '<div class="variation"><label for="attribute"> Color </label><input type="text" name="color" placeholder="Enter Color" class="form-control"><label for="attribute"> Size </label><input type="text" name="size" placeholder="Enter Color" class="form-control"></div>';

      jQuery('#image_box').append(html);
   }


   function Remove_Image(id){

        jQuery('#add_image_box'+id).remove();
      
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