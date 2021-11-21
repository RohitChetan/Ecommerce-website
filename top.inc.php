<?php

require('Connection.inc.php');
require('Cart.inc.php');
require('Function.inc.php');

$Cate = mysqli_query($con,"SELECT * FROM categories WHERE status = 1  order by Categories asc");

$Cate_arr = array();

while($row=mysqli_fetch_assoc($Cate)){

    $Cate_arr[] = $row;

}

$obj=new Add_To_Cart(); //object no use karine Add_To_Cart() function call karavyu chhe 
$totalproduct= $obj->TotalProduct(); // TotalProduct() namnu function object no use kari ne totoalptoduct namna variable ma store karse.

if(isset($_SESSION['USER_LOGIN'])){

    $uid = $_SESSION['USER_ID'];
    if(isset($_GET['id'])){

        $wid = $_GET['id'];
        mysqli_query($con,"DELETE FROM wishlist WHERE id = '$wid' and user_id = '$uid'");

    }
    $wishlist_count = mysqli_num_rows(mysqli_query($con,"SELECT product.name,product.image,product.price,product.mrp,wishlist.id FROM product,wishlist WHERE wishlist.product_id = product.id and wishlist.user_id = '$uid' "));

}

$script_name = $_SERVER['SCRIPT_NAME'];
$script_name_arr = explode('/', $script_name);
$mypage = $script_name_arr[count($script_name_arr)-1];
$meta_title = 'ECOMMERCE DEMO WEBSITE';
$meta_desc = 'This is ECOMMERCE platform for shopping and selling for multivendor';
$meta_keyword = 'ECOMMERCE,Multivendor,Shopping website';

if($mypage == 'product.php'){
$product_id = get_safe_value($con,$_GET['id']);
$product_meta_res = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM product WHERE id = '$product_id'"));
$meta_title = $product_meta_res['meta_title'];
$meta_desc = $product_meta_res['meta_desc'];
$meta_keyword = $product_meta_res['meta_keyword'];
}
?>


<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $meta_title ?></title>
    <meta name="description" content="<?php echo $meta_desc ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo $meta_keyword ?>">
    
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Owl Carousel min css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">
    <script src="js/Code.js"></script>
    <script src="js/Main.js"></script>
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>

    .htc__shopping__cart a span.htc__wishlist {
    background: #c43b68;
    border-radius: 100%;
    color: #fff;
    font-size: 9px;
    height: 17px;
    line-height: 19px;
    position: absolute;
    right: 18px;
    text-align: center;
    top: -4px;
    width: 17px;
    }

    </style>
</head>

<body> 

    <div class="wrapper">
        <header id="htc__header" class="htc__header__area header--one">
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="index.php"><img src="images/bg/Shopping Worlds.png"  alt="logo images"></a>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                     <ul class="main__menu">
                                        <li class="drop"><a href="index.php">Home</a></li>
                                        <?php
                                            foreach($Cate_arr as $list){ ?>

                                            <li class="drop"><a href="categories.php?id=<?php echo $list['id'] ?>" class="drop"><?php echo  $list['Categories'] ?></a>
                                            
                                            <?php 
                                                $cat_id = $list['id'];
                                                $sub_cat_res=mysqli_query($con,"SELECT * FROM sub_categories WHERE status ='1' and categories_id = '$cat_id'");
                                                if(mysqli_num_rows($sub_cat_res)>0){
                                            ?>
                                            <ul class="dropdown">
                                                <?php while($sub_cat_row=mysqli_fetch_assoc($sub_cat_res)){
                                                    echo '<li><a href="Categories.php?id='.$list['id'].'&sub_categories='.$sub_cat_row['id'].'">'.$sub_cat_row['sub_categories'].'</a></li>';
                                                }?>
                                            </ul>
                                        <?php } ?>
                                        </li>
                                        <?php }  ?>
                                        
                                        <li><a href="Contact_US.php">contact</a></li>
                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                       <ul>
                                            <li><a href="index.php">Home</a></li>
                                            <?php

                                                 foreach($Cate_arr as $list){ ?>

                                                <li><a href="categories.php?id=<?php echo $list['id'] ?>"><?php echo  $list['Categories'] ?></a></li>

                                            <?php
                                                 }

                                            ?>                                        
                                            <li><a href="Contact_US.php">contact</a></li>
                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                <div class="header__right">
                                    <div class="header__search search search__open">
                                        <a href="#"><i class="icon-magnifier icons"></i></a>
                                    </div>
                                    <div class="header__account">
                                    <?php 
                                        if(isset($_SESSION['USER_LOGIN'])){ ?>

                                            <div class="navbar-nav ml-auto">
                                              <div class="nav-item dropdown">
                                                    <a href="#"  data-toggle="dropdown"><strong> Account </strong></a>
                                                    <div class="dropdown-menu">
                                                        <li>
                                                            <a href="my_order.php" class="dropdown-item"> My Order</a><br/>
                                                        </li>
                                                        <li>
                                                            <a href="Profile.php" class="dropdown-item"> Profile </a><br/>
                                                        </li>
                                                        <li>
                                                            <a href="LogOut.php" class="dropdown-item"> Log Out </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }else{

                                            echo '<a href="Login.php">Login/Register</i></a>';
                                        }
                                    ?>
                                    </div>
                                    <div class="htc__shopping__cart">
                                        <?php
                                        if(isset($_SESSION['USER_ID'])){ ?>
                                        <a href="Wishlist.php"><i class="icon-heart icons"></i></a>
                                        <a href="Wishlist.php"><span class="htc__wishlist" ><?php echo $wishlist_count;  ?></span></a>
                                        <?php } ?>
                                        <a class="cart__menu" href="#"><i class="icon-handbag icons"></i></a>
                                        <a href="cart.php"><span class="htc__qua" ><?php echo $totalproduct;  ?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
        </header>
         <div class="body__overlay"></div>
        <div class="offset__wrapper">
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="Search.php" method="get">
                                    <input placeholder="Search here... " type="text" name="str">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>