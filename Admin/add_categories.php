<?php 
require('top.inc.php');
$categories = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){ //$_get['id'] is get fromm url 


   $id = get_safe_value($con,$_GET['id']);
   //get_safe_value is function it's define a real_escape_string 

   $sql = mysqli_query($con,"SELECT * FROM categories WHERE id = '$id' "); // check url mathi maleli id tabel ma exist kare chhe ke nai
   $check = mysqli_num_rows($sql);
   if($check>0){
      $row = mysqli_fetch_assoc($sql);
      $categories = $row['Categories']; //fetch categories if id exist 
   }else{

       header('location:categories.php');
       die();
   }

}

if(isset($_POST['submit'])){

   $categories = get_safe_value($con,$_POST['Categories']); //eneter ccategories by user 

   $sql = mysqli_query($con,"SELECT * FROM categories WHERE Categories = '$categories' "); // fetch data with categories exist or not
   $check = mysqli_num_rows($sql);
   if($check>0){

       if(isset($_GET['id']) && $_GET['id'] !=''){ //fetch id using line 29

         $getData= mysqli_fetch_assoc($sql); 
         if($id == $getData['id']){ //get id from categories tabel using 29 query 


         }else{

             $msg = "Categories allready Exist"; //if enter same categories is allready exist in tabel so its show this message
         }

       }else{

            $msg = "Categories allready Exist";
       }

   }

   if($msg==''){ // jo message empty malse insert time and update banne time to 

       if(isset($_GET['id']) && $_GET['id'] !=''){ // check karse ke id url thi get thay chhe to line 55 par jase

          mysqli_query($con,"UPDATE categories SET Categories = '$categories' WHERE id = '$id'"); // jo id url thi get thay chhe to data update karvana  nai to line 59

      }else{

          mysqli_query($con,"INSERT INTO categories(Categories,status) VALUES('$categories','1')"); // nai to data insert karvana url mathi id get na thay to 
      }
       header('location:categories.php');
       die();
   }
}


?>
<div class="content pb-0">
      <div class="animated fadeIn">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header"><strong> Categories </strong><small> Form</small></div>
                    <form method="POST">  
                        <div class="card-body card-block">
                           <div class="form-group">
                              <label for="categories" class=" form-control-label">Categories</label>
                              <input type="text" name="Categories" placeholder="Enter Categories name" class="form-control" required value="<?php echo $categories ?>">
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