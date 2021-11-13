<?php
require('Connection.inc.php');
require('Function.inc.php');

$msg = '';

if(isset($_POST['submit'])){

    $username = get_safe_value($con,$_POST['uname']);
    $password =  get_safe_value($con,$_POST['pass']);

    $sql = "SELECT * FROM vendor_registration WHERE name = '$username' and password = '$password'";
    $res = mysqli_query($con,$sql);
    $count = mysqli_num_rows($res);

   if($count>0){
      $row = mysqli_fetch_assoc($res);
      $vendor_status = $row['status'];
    if($vendor_status == 1){  

         $_SESSION['VENDOR_LOGIN']='yes';
         $_SESSION['VENDOR_ROLE']= 'VENDOR';
         $_SESSION['VENDOR_ID']= $row['id'];
         $_SESSION['VENDOR_USERNAME'] = $username;


               header('location:../MultiVendor/Product.php');

       }else{

         $msg = "<strong> Your Account is Deactivted </strong>";
       }
   }else{

         $msg = "Please Enter Valid Login Details";
   }
}
?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form method="POST">
                     <div class="form-group">
                        <label>Email address</label>
                        <input type="text" class="form-control" placeholder="Enter Name" name="uname" required>
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="pass" required>
                     </div>
                     <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
					</form>
                  <br/>
                <div class="Errormsg"> <?php echo $msg  ?></div>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>