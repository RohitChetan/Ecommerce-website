<?php 
require('top.inc.php');
//require('Brand.php');
?>

<div class="body__overlay"></div>
              
        <!-- Start Slider Area -->
        <div class="slider__container slider--one bg__cat--3">
            <div class="slide__container slider__activation__wrap owl-carousel">
                <!-- Start Single Slide -->
                <div class="single__slide animation__style01 slider__fixed--height ">
                    <div class="container">
                        <div class="row align-items__center carousel slide" id="myCarousel" data-ride="carousel">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>Shopping Worlds</h2>
                                        <h1>Your Choices</h1>
                                        <div class="cr__btn">
                                            <a href="cart.php">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5 carousel-inner">
                                <div class="slide__thumb item active">
                                    <img src="images/slider/fornt-img/slider-1.jpg" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Slide -->
                <!-- Start Single Slide -->
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>collection 2018</h2>
                                        <h1>NICE CHAIR</h1>
                                        <div class="cr__btn">
                                            <a href="cart.html">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="images/slider/fornt-img/slider-2.jpg" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Slide -->
            </div>
        </div>
        <!-- Start Slider Area -->
        <!-- Brand Start -->
        
        <!-- Brand End -->      
        <!-- Start Category Area -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="images/bg/4.png" alt="Los Angeles">
    </div>

    <div class="item">
      <img src="images/bg/5.png" alt="Chicago">
    </div>

    <div class="item">
      <img src="images/bg/Cart_image.png" alt="New York">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<section class="htc__category__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">New Arrivals</h2>
                            <p>But I must explain to you how all this mistaken idea</p>
                        </div>
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix mt--30">
                            <!-- Start Single Category -->
                            <?php

                            $get_product = get_product($con,8);

                            foreach ($get_product as $list) {
                            ?>
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12" style="height: 550px; ">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id'] ?>">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image'] ?>" style="height: 250px;" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
                                        <ul class="product__action">
                                            <li><a href="javascript:void(0)" onclick="Wishlist_Manage('<?php echo $list['id'] ?>','add')"><i class="icon-heart icons"></i></a></li>

                                            <li><a href="javascript:void(0)" onclick="Manage_cart('<?php echo $get_product['0']['id'] ?>','add')"><i class="icon-handbag icons"></i></a></li>

                                            <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.html" style="padding-top: 5px;"><?php echo $list['name'] ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize"><?php echo $list['mrp'] ?></li>
                                            <li><?php echo $list['price'] ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
                            <?php
                              }
                           ?>
                        </div>
                    </div>

                <ul id="rcbrand2">
                    <li><img src="images/wordpress.png" /></li>
                    <li><img src="images/html5.png" /></li>
                    <li><img src="images/css3.png" /></li>
                    <li><img src="images/windows.png" /></li>
                    <li><img src="images/jquery.png" /></li>
                    <li><img src="images/js.png" /></li>
                </ul>
                </div>
            </div>
</section>
        <!-- End Category Area -->

<!-- Brand Logo Slider -->


<!-- brand Logo Slider End here -->

        <!-- Start Product Area -->
<section class="ftr__product__area ptb--100" >
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line" style="margin-top: -150px;">Best Seller</h2>
                            <p>But I must explain to you how all this mistaken idea</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="product__list clearfix mt--30">
                            <!-- Start Single Category -->
                            <?php

                            $get_product = get_product($con,4,'','','','','YES');

                            foreach ($get_product as $list) {
                            ?>
                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12" style="height:500px;">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id'] ?>">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image'] ?>" class="product_image" alt="product images" style="height: 300px;">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
                                        <ul class="product__action">
                                            <li><a href="javascript:void(0)" onclick="Wishlist_Manage('<?php echo $list['id'] ?>','add')"><i class="icon-heart icons"></i></a></li>

                                            <li><a href="javascript:void(0)" onclick="Manage_cart('<?php echo $get_product['0']['id'] ?>','add')"><i class="icon-handbag icons"></i></a></li>

                                            <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.html"><?php echo $list['name'] ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize"><?php echo $list['mrp'] ?></li>
                                            <li><?php echo $list['price'] ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
                            <?php
                              }
                           ?>
                        </div>
                    </div>
            </div>
</section>
        <!-- End Product Area -->


<?php
require('footer.inc.php');
?>
<div style="display: none;">
<?php
require('Brand.php');
?>
</div>