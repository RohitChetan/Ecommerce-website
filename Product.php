<?php 
 
require('top.inc.php');
$product_id = mysqli_real_escape_string($con,$_GET['id']);

if($product_id>0){

    $get_product = get_product($con,'','',$product_id);
    
}else{ ?>

    <script>
        window.location.href='index.php';
    </script>

<?php

    die();
}



$product_muliple_images = mysqli_query($con,"SELECT id,Product_Images FROM products_images WHERE product_id = '$product_id'");

if(mysqli_num_rows($product_muliple_images) > 0){

 $a=0;
while($row_product_multi_Image = mysqli_fetch_assoc($product_muliple_images)){

    $multi_ImageArr[$a]['id'] = $row_product_multi_Image['id'];
    $multi_ImageArr[$a]['Product_images'] = $row_product_multi_Image['Product_Images'];
      
     $a++;
 }
}


?>
 
 <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/Product_image1.png) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <a class="breadcrumb-item" href="Categories.php?id=<?php echo $get_product['0']['categories_id'];?>"><?php echo $get_product['0']['Categories']; ?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active"><?php echo $get_product['0']['name'];?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image'] ?>" alt="full-image">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-10" >
                                        <?php 

                                         if(isset($multi_ImageArr[0])){

                                            foreach ($multi_ImageArr as $list) {
                                                
                                                echo '<div class="col-lg-5">';
                                                echo '<Image src="'.PRODUCT_MULTIIMAGE_SITE_PATH.$list['Product_images'].'" width="100px" height="100px"  style="margin-top:50px;"/>';
                                                echo '</div>';
                                                                                                                                           
                                            }
                                        }

                                        ?>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $get_product['0']['name'] ?></h2>
                                <ul  class="pro__prize">
                                    <li class="old__prize"><?php echo $get_product['0']['mrp'];?></li>
                                    <li><?php echo $get_product['0']['price'];?></li>
                                </ul>
                                <p class="pro__info"><?php echo $get_product['0']['short_desc'];?></p>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
                                        <?php
                                            $checkProductAvaibilityByProductID = checkProductAvaibilityByProductID($con,$get_product['0']['id']);
                                            $pendingQTY = $get_product['0']['qty'] - $checkProductAvaibilityByProductID;

                                            $cart_show = 'yes';

                                            if($get_product['0']['qty'] > $checkProductAvaibilityByProductID){

                                                $stock = "In Stock";
                                            }else{
                                                $stock = "Not In Stock";
                                                $cart_show = '';
                                            }

                                        ?>
                                        <p><span>Availability:</span><?php echo $stock ?></p>
                                    </div>
                                    <div class="sin__desc">
                                        <?php if($cart_show != ''){ ?>
                                        <p><span> Qty:</span>
                                        <select id="Quantity">
                                            <?php 

                                                for ($i=1; $i < $pendingQTY ; $i++) { ?>
                                                    
                                                    <option><?php echo $i ?></option>   
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        </p>
                                        <?php } ?>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Categories : </span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $get_product['0']['Categories']; ?></a></li>
                                        </ul>
                                    </div>
                                        
                                    </div>
                                    <?php
                                    if($cart_show != ''){ ?>

                                        <a class="fr__btn" href="javascript:void(0)" onclick="Manage_cart('<?php echo $get_product['0']['id'] ?>','add')"> Add to Cart </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
        <!-- End Product Details Area -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                    <p><?php echo $get_product['0']['long_desc'];?></p>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php

require('footer.inc.php');

?>