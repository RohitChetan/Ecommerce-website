<?php
require('top.inc.php');
?>

<!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/my_Order_Image.png) no-repeat scroll center center / cover ;">
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
                                                <th class="product-thumbnail">ORDER ID </th>
                                                <th class="product-name"><span class="nobr">ORDER DATE </span></th>
                                                <th class="product-price"><span class="nobr"> ADDRESS </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> PAYMENT TYPE </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> PAYMENT STATUS </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> ORDER STATUS </span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

                                            $uid = $_SESSION['USER_ID'];
                                            $sql = mysqli_query($con,"SELECT `order`.*,order_status.name as order_status_str FROM `order`,order_status WHERE `order`.user_id='$uid' and order_status.id = `order`.order_status ");


                                            while($row = mysqli_fetch_assoc($sql)){

                                            ?>
                                            <tr>
                                                <td class="product-add-to-cart"><a href='my_order _details.php?order_id=<?php echo $row['id'] ?>'> <?php echo $row['id'] ?></a><br/>
                                                    <a  class="pdfbtn" href='Order_pdf.php?order_id=<?php echo $row['id'] ?>'> PDF </a>
                                                </td>
                                                <td class="product-name"><a href="#"><?php echo $row['added_on'] ?></a></td>
                                                <td class="product-price"><span class="amount"><?php echo $row['address'] ?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['payement_type'] ?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['payemnt_status'] ?></span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['order_status_str'] ?></span></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
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