<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="related products">
		<?php
		global $product;
		$relatedProduct = $product->get_related();
		?>
		<div class="kk_title_banner">
			<h2 class="kk_title" style="margin-left: 0px;">Возможно, вас заинтересует</h2><img class="kk_all" style="margin-right: 0px;" src="/images/main/evslider_all_cart.png" /><img class="kk_next" src="/images/main/evslider_right_cart.png" /><img class="kk_pause" src="/images/main/evslider_pause_cart.png" /><img class="kk_prev" src="/images/main/evslider_left_cart.png" />	
		</div>
		<div id="fullwidth_slider4" class="everslider fullwidth-slider es-slides-ready">
			<ul class="es-slides">
			<?php if(sizeof($relatedProduct)>0): ?>
				<?php foreach($relatedProduct as $itemRelated): ?>
				<?php
				$tek_product = get_product($itemRelated);
				$thumb_id = get_post_thumbnail_id($itemRelated);
				//Получим цвет кнопки - начало
				$have_pod_zakak = false;
				$kk_attributes = $tek_product->get_attributes();
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
					$real_ost = $tek_product->stock_quantity - 1000000;
					if($real_ost<=0){
						$color_tovar = "grey";
						$class_basket = "kk_status2";
						$name_tooltip = "Ожидается поступление";
					}
				}//if($have_pod_zakak==true)						
				//Получим цвет кнопки - конец	
				?>
				<li>
					<div style="border:1px solid #007cc3;height: 100%;width: 100%;">
						<?php echo wp_get_attachment_image($thumb_id); ?>
						<div class="fullwidth-title" style="height:130px;">
							<a href="<?php echo get_permalink($itemRelated); ?>"><?php echo $tek_product->name; ?></a>
							<?php
								$price_related =  $tek_product->price;
							?>
							<div style="width:100%;height: 25px;">
								<span style = "display: inline-block !important;margin: 0px;margin-left: 10px;float: left;color:#000;"><?php echo $price_related; ?></span><span style = "display: inline-block !important;margin: 0px;margin-left: 10px;float: left;font-size:24px;color:#000;"> руб.</span>
							</div>
							<?php
							?>

							<div class="qty_menu_main" style="clear:both;">
								<div class="qty_menu_left" onclick="func_minus_basket($(this));">-</div>
								<div class="qty_menu"><input style="height: 27px;width: 25px;text-align:center;" type="text" step="1" min="1" max="1000006" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric" disabled=""></div>
								<div class="qty_menu_right" onclick="func_plus_basket($(this));">+</div>
							</div>
							<div class="in_bascet <?php echo $class_basket;?>" style="clear:both;" data-tooltip="<?php echo $name_tooltip; ?>">
								<form class="cart" method="post" enctype="multipart/form-data"><div class="quantity" style="float: none !important;display: inline-block;"><input type="text" style="display: none;" class="input-text qty text" step="1" min="1" max="1000000" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric"></div><input type="hidden" name="add-to-cart" value="<?php echo $tek_product->get_id();?>"><button type="submit" class="single_add_to_cart_button button alt" style="margin-top: -9px !important;margin-right: 2px; background-position: left; color: #000; padding-left: 24px;  font-size: 10px;"></button></form>
							</div>

							<?php
							?>
						</div>
					</div>
				</li>
				<?php endforeach; ?>
			<?php endif; ?>
			</ul>
		</div>	
</section>
<?php
	//получим каталог товара
	echo '<div style="display:none;" class="category_product">' . $product->get_categories() . '</div>';
?>
<script>
$(document).ready(function(){
	//клик по новым стрелкам баннеров
	$(".kk_prev").click(function(){
		$(".es-prev").click();	
	});
	$(".kk_next").click(function(){
		$(".es-next").click();	
	});
	//клик по заголовку
	$(".kk_title").click(function(){
		window.location.href=$('.category_product a').attr('href');
	});
	$(".kk_all").click(function(){
		window.location.href=$('.category_product a').attr('href');
	});
});
</script>