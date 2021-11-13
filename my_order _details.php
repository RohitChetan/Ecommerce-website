<?php
require('top.inc.php');

$order_id = get_safe_value($con,$_GET['order_id']);

$coupon_details = mysqli_fetch_assoc(mysqli_query($con,"SELECT coupon_value FROM `order` WHERE id = '$order_id'"));

$coupon_value = $coupon_details['coupon_value'];

?>

<!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.png) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Thank You</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->

        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-name"><span class="nobr"> PRODUCT NAME  </span></th>
                                                <th class="product-name"><span class="nobr"> QTY </span></th>
                                                <th class="product-price"><span class="nobr"> IMAGE </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> PRICE  </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> TOTAL PRICE </span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

                                            $uid = $_SESSION['USER_ID'];
                                            $sql = mysqli_query($con,"SELECT distinct(`order_details`.id),`order_details`.*,product.name,product.image FROM  `order_details`,product, `order` WHERE `order_details`.order_id = '$order_id' and `order`.user_id = '$uid' and `order_details`.product_id = product.id ");

                                            $total_price = 0;

                                            while($row = mysqli_fetch_assoc($sql)){

                                                $total_price = $total_price+($row['qty']*$row['price']);
                                                
                                            ?>
                                            <tr>
                                                <td class="product-add-to-cart"><a href="#"><?php echo $row['name'] ?></a></td>
                                                <td class="product-price"><span class="amount"><?php echo $row['qty'] ?></span></td>
                                                <td class="product-name"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image'] ?>" style="height: 400px; width: 350px;"></a></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['price'] ?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['qty']*$row['price'] ?></span></td>

                                            </tr>
                                            <?php
                                                } 
                                                if($coupon_value != ''){ 
                                            ?>
                                                
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="product-name"> CPOUPON VALUE </td>
                                                <td class="product-name"> <?php echo $coupon_value ?> </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="product-name"> TOTAL PRICE </td>
                                                <td class="product-name"> <?php echo $total_price-$coupon_value; ?> </td>
                                            </tr>

                                            <?php
                                                }else{
                                            ?>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="product-name"> TOTAL PRICE </td>
                                                <td class="product-name"> <?php echo $total_price ?> </td>
                                            </tr>

                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="wishlist-share">
                                                        <h4 class="wishlist-share-title">Share on:</h4>
                                                        <div class="social-icon">
                                                            <ul>
                                                                <li><a href="www.facebook.com"><i class="icon-social-facebook"></i></a></li>
                                                                <li><a href="www.instagram.com"><i class="icon-social-instagram"></i></a></li>
                                                                <li><a href="https://www.tumblr.com"><i class="zmdi zmdi-tumblr"></i></a></li>
                                                                <li><a href="https://in.pinterest.com"><i class="zmdi zmdi-pinterest"></i></a></li>
                                                                <li><a href="https://in.linkedin.com"><i class="zmdi zmdi-linkedin"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php 
require('footer.inc.php');
?>