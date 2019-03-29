<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

//kk-->
$attributes = $product->get_attributes();

$kk_status = "kk_status1";
$real_ost = $product->stock_quantity - 1000000;
if($real_ost<=0){
	$kk_status = "kk_status2";
}
foreach ( $attributes as $attribute ) {
	if($attribute['data']['name']=="Под заказ"){
		if($attribute['data']['value']=="Да") $kk_status = "kk_status3";
	}
}
switch($kk_status):
	case "kk_status1":
		$kk_data = "В наличии";
		break;
	case "kk_status2":
		$kk_data = "Ожидает поступления. Добавьте этот товар в корзину,чтобы его ускорить";
		break;	
	case "kk_status3":
		$kk_data = "Товары под заказ";
		break;
	default:
		$kk_data = "В наличии";
endswitch;
//<--kk

if ( is_user_logged_in() ){ 

}else{
	$categ = $product->get_categories(); 
	if($categ=='<a href="http://business.universam-online.ru/категория/%d1%81%d0%b8%d0%b3%d0%b0%d1%80%d0%b5%d1%82%d1%8b/" rel="tag">Сигареты</a>'):
?>	
<li <?php post_class(); ?>>
	<h2 class="woocommerce-loop-product__title" style="color: red;">Товар доступлен только для зарегестрированных пользователей</h2>
</li>
<?php	
	return;
	endif;
	if($categ=='<a href="http://business.universam-online.ru/категория/%d0%bd%d0%b0%d0%bf%d0%b8%d1%82%d0%ba%d0%b8/%d0%bf%d0%b8%d0%b2%d0%be/" rel="tag">Пиво</a>'):
?>	
<li <?php post_class(); ?>>
	<h2 class="woocommerce-loop-product__title" style="color: red;">Товар доступлен только для зарегестрированных пользователей</h2>
</li>
<?php	
	return;
	endif;
	if($categ=='<a href="http://business.universam-online.ru/категория/%d0%bd%d0%b0%d0%bf%d0%b8%d1%82%d0%ba%d0%b8/%d0%bf%d0%b8%d0%b2%d0%be-2/" rel="tag">Пиво +</a>'):
?>	
<li <?php post_class(); ?>>
	<h2 class="woocommerce-loop-product__title" style="color: red;">Товар доступлен только для зарегестрированных пользователей</h2>
</li>	
<?php	
	return;
	endif;	
	if(trim($categ)==''):
?>	
<li <?php post_class(); ?>>
	<h2 class="woocommerce-loop-product__title" style="color: red;">Товар доступлен только для зарегестрированных пользователей</h2>
</li>
<?php	
	return;
	endif;
	//echo $categ.'|';
}
?>
<li <?php post_class(); ?> id="<?php echo $kk_status;?>">
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
?>	 
	</a>
	<div data-tooltip="<?php echo $kk_data; ?>" class="paid" style="margin-top: 10px;height:30px;margin-bottom:10px;"> 
<?php
	//do_action( 'woocommerce_after_shop_loop_item' );
?>
		<div class="qty_menu_main" style="margin-right:4px;width: 78px;margin-left:9px;float:left;">
			<div style="color:grey; border-radius: 5px 5px; display: inline-block;width: 22px;border: 1px solid #000;cursor: pointer;text-align: center;" class="left_count" onclick="func_minus_basket($(this));">-</div>
			<div class="qty_menu" style="display: inline-block;text-align:center;"><input style="height: 27px;width: 25px;text-align:center;" type="text" step="1" min="1" max="1000006" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric" disabled=""></div>
			<div style="color:grey; border-radius: 5px 5px; display: inline-block;width: 22px;border: 1px solid #000;cursor: pointer;text-align: center;" class="right_count" onclick="func_plus_basket($(this));">+</div>
		</div>
		<div class="in_bascet <?php echo $kk_status;?>" style="width: 50px; text-align:center;float:left;height:30px;">
			<form class="cart" method="post" enctype="multipart/form-data">
				<div class="quantity" style="float: none !important;display: inline-block;">
					<input type="text" style="display: none;" class="input-text qty text" step="1" min="1" max="1000000" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric">
				</div>
				<input type="hidden" name="add-to-cart" value="<?php echo $product->id;?>">
				<button type="submit" class="single_add_to_cart_button button alt" style="margin: 0 !important; background-position: left; color: #000; padding-left: 24px;  font-size: 10px;"></button>
			</form>
		</div>
	</div>
</li>
