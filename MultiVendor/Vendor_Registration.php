

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<style>

.form {

    height: auto;
    width: auto;

    margin-left: 450px;
    margin-top: 150px;


}

form div{

    display: block;
    margin-top: 25px;
    align-items: center;

}
</style>
<body>

    <div class="form">
        <form action="Vendor_Registration.php" method="POST">
            
            <div class="form-group">
                <label>UserName :- </label>
                <input type="text"  class=" form-control" name="uname">
            </div>

            <div>
                <label> Email-ID :- </label>
                <input type="text" name="email">
            </div>

            <div>
                <label> Mobile :- </label>
                <input type="text" name="mobile">
            </div>
            <div>
                <label> Gender :- </label>
                <select  name="gender">
                    <option vales=''> Select Gender </option>
                    <option value="Male"> Male </option>
                    <option value="FeMale"> female </option>
                    <option value="Other"> Other </option>
                </select>
            </div>

            <div>
                <label> Password :- </label>
                <input type="text" name="password">
            </div>

            <div>
                <input type="submit" name="submit" class="btn btn-success">
            </div>
        </form>
    </div>

</body>
</html>

<?php

require('Connection.inc.php');
require('Function.inc.php');


if(isset($_POST['submit'])){

$name = get_safe_value($con,$_POST['uname']);
$email = get_safe_value($con,$_POST['email']);
$mobile = get_safe_value($con,$_POST['mobile']);
$gender = get_safe_value($con,$_POST['gender']);
$added_on = date('Y-m-d h:i:s');
$password= get_safe_value($con,$_POST['password']);


//prx($_POST);


$check_user =mysqli_num_rows(mysqli_query($con,"SELECT * FROM vendor_registration WHERE email='$email'"));

if($check_user>0){

    echo " EmailAllready Present";
}else{

    $data = mysqli_query($con,"INSERT INTO vendor_registration(name,email,mobile,gender,password,status) VALUES('$name','$email','$mobile','$gender','$password','1')");

     prx($data);
}

}


?>