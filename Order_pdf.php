<?php
include('vendor/autoload.php');
require('Connection.inc.php');
require('Function.inc.php');

if(!$_SESSION['ADMIN_LOGIN']){

	if(!isset($_SESSION['USER_LOGIN'])){

		die();
	}	

}




$html ='';
$order_id = get_safe_value($con,$_GET['order_id']);

$coupon_details = mysqli_fetch_assoc(mysqli_query($con,"SELECT coupon_value FROM `order` WHERE id = '$order_id'"));

$coupon_value = $coupon_details['coupon_value'];


$css = file_get_contents('css/bootstrap.min.css');
$css .= file_get_contents('style.css');

$html .='<div class="wishlist-table table-responsive">
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
      <tbody>';

      	if(isset($_SESSION['ADMIN_LOGIN'])){

	        $sql = mysqli_query($con,"SELECT distinct(`order_details`.id),`order_details`.*,product.name,product.image FROM  `order_details`,product, `order` WHERE `order_details`.order_id = '$order_id' and  `order_details`.product_id = product.id ");
      	}else{

      		$uid = $_SESSION['USER_ID'];
       	    $sql = mysqli_query($con,"SELECT distinct(`order_details`.id),`order_details`.*,product.name,product.image FROM  `order_details`,product, `order` WHERE `order_details`.order_id = '$order_id' and `order`.user_id = '$uid' and `order_details`.product_id = product.id ");
      	}

        $total_price = 0;

        if(mysqli_num_rows($sql)==0){

        	die();
        }

        while($row = mysqli_fetch_assoc($sql)){

            $total_price = $total_price+($row['qty']*$row['price']);
            $pp = $row['qty']*$row['price'];
                                                
        

      $html .='<tr>
            <td class="product-add-to-cart"><a href="#">'.$row['name'].'</a></td>
            <td class="product-price"><span class="amount">'.$row['qty'].'</span></td>
            <td class="product-name"><img src=" '.PRODUCT_IMAGE_SITE_PATH.$row['image'] .'" style="height: 400px; width: 350px;"></a></td>
            <td class="product-stock-status"><span class="wishlist-in-stock">'.$row['price'].'</span></td>
            <td class="product-stock-status"><span class="wishlist-in-stock">'.$pp.'</span></td>
         </tr> ';

     

   } 
   if($coupon_value != ''){ 

   	$main_price = $total_price - $coupon_value;
	
$html .='<tr>
   			<td colspan="3"></td>
   			<td class="product-name"> CPOUPON VALUE </td>
   			<td class="product-name"> '.$coupon_value.' </td>
			</tr>
			<tr>
   			<td colspan="3"></td>
   			<td class="product-name"> TOTAL PRICE </td>
   			<td class="product-name"> '.$main_price .'</td>
		</tr>';

   }else{
  
$html .='<tr>
   			<td colspan="3"></td>
   			<td class="product-name"> TOTAL PRICE </td>
   			<td class="product-name"> '.$total_price.' </td>
		</tr>';

 }

      $html .='</tbody>
      				<tfoot>
         			<tr>
           
         			</tr>
      			</tfoot>
   			</table>
		</div>';

$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$mpdf->Output('Invoice.pdf','D');

?>