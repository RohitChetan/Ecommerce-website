<?php 
require('Connection.inc.php');
require('Function.inc.php');

if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] ='yes'){
}else{
   header('location:login.php');
   die();
}

 $categories_id = get_safe_value($con,$_POST['categories_id']);
 $sub_cat_id = get_safe_value($con,$_POST['sub_categories_id']);
 $res = mysqli_query($con,"SELECT * FROM sub_categories WHERE categories_id = '$categories_id' and status = '1'");
 if(mysqli_num_rows($res)>0){
   $html ='';
   while($row=mysqli_fetch_assoc($res)){
      if($sub_cat_id == $row['id']){
         $html .= "<option value=".$row['id']." selected>".$row['sub_categories']."</option>";
   }else{

      $html .= "<option value=".$row['id'].">".$row['sub_categories']."</option>";
   }
   }
   echo $html;
 }else{

   echo "<option value=''> No Sub Categories Found</option>";
 }
?>