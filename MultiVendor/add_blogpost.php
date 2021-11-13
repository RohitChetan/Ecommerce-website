<?php
require('top.inc.php');

if(!isset($_SESSION['VENDOR_LOGIN'])){ ?>
    <script>
        window.location.href='Vendor_login.php';
    </script>
<?php
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
                              <label for="categories" class=" form-control-label"> Blog Title </label>
                              <input type="text" name="title" placeholder="Enter Blog Title" class="form-control" id="title" required>
                              <div class="Errormsg"> </div>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Blog Post </label>
                              <textarea name="article" class="form-control" id="blog"id="title"> </textarea>
                              <div class="Errormsg"> </div>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Keywords </label>
                              <input type="text" name="keywords"id="keyword" placeholder="Enter Keywords of Blog" class="form-control" required >
                              <div class="Errormsg"> </div>
                           </div>
                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Label </label>
                              <input type="text" name="Label" id="label" placeholder="Enter Blog Label" class="form-control" required >
                              <div class="Errormsg"> </div>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Search Description </label>
                              <input type="text" name="description" id="desc" placeholder="Enter Search Description " class="form-control" required >
                              <div class="Errormsg"> </div>
                           </div>

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Blog IMAGE </label>
                              <input type="file" name="image" id="image" placeholder="Enter Image" class="form-control" >
                              <div class="Errormsg"> </div>
                           </div>

                           <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" name="submit" onclick="AddBlog()">
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
   
function AddBlog(){

   var title = jQuery('#title').val();
   var article = jQuery('#blog').val();
   var keyword = jQuery('#keyword').val();
   var label = jQuery('#label').val();
   var desc = jQuery('#desc').val();
   var image = jQuery('#image').val();


   if(title==''){
       alert('Please Enter Blog Title');
   }
   if(article==''){
      alert('Please Enter Blog Post');
   }
   if(keyword==''){
      alert('Please Enter Blog Keywords');
   }
   if(label==''){
      alert('Please Enter Blog Label');
   }
   if(desc==''){
      alert('Please Enter Blog Description');
   }
   if(image==''){
      alert('Please Enter Blog Image');
   }

   jQuery.ajax({

      url : 'insert_Blog.php',
      type : 'post',
      data : 'title='+title+'&article='+article+'&keyword='+keyword+'&label='+label+'&desc='+desc+'&image='+image,
      success : function(res){

         alert(res);
      }

   })
  
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