<?php 
require('top.inc.php');

$msg = '';

if(isset($_POST['submit'])){
    
    if(isset($_POST['copyright'])){
       $_SESSION['copyright'] = $_POST['copyright'];
       //print_r($_SESSION);
    }else{
        $tes = "Copyright © Nov-2021 ADMIN";
        $_SESSION['copyPre'] = $tes;

        print_r($_SESSION['copyPre']);
    }
}
?>

<div class="content pb-0">
      <div class="animated fadeIn">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header"><strong>Sub  Categories </strong><small> Form</small></div>
                    <form method="POST" action="CopyRight.php">  
                        <div class="card-body card-block">

                           <div class="form-group">
                              <label for="categories" class=" form-control-label"> Sub Categories </label>
                              <input type="text" name="copyright" placeholder="Enter Copyright Text" class="form-control"  value="">
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