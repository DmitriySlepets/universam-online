<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div class="sp_price">
	<div style="width: 100%;display: block;line-height: normal;"><?php echo $product->get_price_html(); ?></div>
	<?php
		//Получим цвет кнопки - начало
		$have_pod_zakak = false;
		$kk_attributes = $product->get_attributes();
		$color_tovar = "green";
		$class_basket = "kk_status1";
		$name_tooltip = "В наличии";
		foreach ( $kk_attributes as $kk_attribute ) {
			if($kk_attribute['data']['name']=="Под заказ"){
				if($kk_attribute['data']['value']=="Да") $have_pod_zakak = true;
			}
		}//foreach ( $kk_attributes as $kk_attribute ) 
		if($have_pod_zakak==true){
			$color_tovar = "red";
			$class_basket = "kk_status3";
			$name_tooltip = "Товары под заказ";
		}else{
			$real_ost = $product->stock_quantity - 1000000;
			if($real_ost<=0){
				$color_tovar = "grey";
				$class_basket = "kk_status2";
				$name_tooltip = "Ожидается поступление";
			}
		}//if($have_pod_zakak==true)	
		//Получим цвет кнопки - конец	
	?>
	<div class="qty_menu_main" style="clear:both;">
		<div class="qty_menu_left" onclick="func_minus_basket($(this));">-</div>
		<div class="qty_menu"><input style="height: 27px;width: 25px;text-align:center;" type="text" step="1" min="1" max="1000006" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric" disabled=""></div>
		<div class="qty_menu_right" onclick="func_plus_basket($(this));">+</div>
	</div>
		<div class="in_bascet <?php echo $class_basket;?>" style="clear:both;" data-tooltip="<?php echo $name_tooltip; ?>">
		<form class="cart" method="post" enctype="multipart/form-data"><div class="quantity" style="float: none !important;display: inline-block;"><input type="text" style="display: none;" class="input-text qty text" step="1" min="1" max="1000000" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric"></div><input type="hidden" name="add-to-cart" value="<?php echo $product->get_id();?>"><button type="submit" class="single_add_to_cart_button button alt" style="margin-top: -9px !important;margin-right: 2px;background-position: left;color: #000;font-size: 10px;"></button></form>
		</div>
</div>
