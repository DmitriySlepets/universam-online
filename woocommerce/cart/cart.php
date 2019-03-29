<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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
 * @version 3.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); 
unset($_SESSION['bonus']);
unset($_SESSION['purse']);
?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>
			
			<?php
			//кк-->
			$massiv_null = array();
			$massiv_null2 = array();
			
			echo 	'<tr class="woocommerce-cart-form__cart-item cart_item">'.
					'<td class="product-remove"></td>'.
					'<td class="product-thumbnail"></td>'.
					'<td class="product-name" data-title="Товар" style="color: green; font-weight: bold; font-size: 22px;" >В наличии:</td>'.
					'<td class="product-price" data-title="Цена"></td>'.
					'<td class="product-quantity" data-title="Количество"></td>'.
					'<td class="product-subtotal" data-title="Итого"></td>'.
					'</tr>';
			//<--кк			
			?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				
				//кк-->
				$have_pod_zakak = false;
				$kk_attributes = $_product->get_attributes();
				foreach ( $kk_attributes as $kk_attribute ) {
					if($kk_attribute['data']['name']=="Под заказ"){
						if($kk_attribute['data']['value']=="Да") $have_pod_zakak = true;
					}
				}
				if($have_pod_zakak==true){
					$massiv_null2[] = $cart_item_key;;
					continue;
				}			
				
				$real_ost = $_product->stock_quantity - 1000000;
				if($real_ost<=0){
					$massiv_null[] = $cart_item_key;
					continue;
				}
				//<--кк
				
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td>

						<td class="product-thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $product_permalink ) {
									echo $thumbnail;
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
								}
							?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<?php
								if ( ! $product_permalink ) {
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
								} else {
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a style="color: green;" href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
								}

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
								}
							?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
							<div class="minus_basket_torg" onclick="func_minus_basket_torg($(this));">-</div>
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0',
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
							<div class="plus_basket_torg" onclick="func_plus_basket_torg($(this));">+</div>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}//foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) 
			?>
			
			<?php 
			//кк-->
			if(count($massiv_null)>0){
				echo 	'<tr class="woocommerce-cart-form__cart-item cart_item">'.
						'<td class="product-remove"></td>'.
						'<td class="product-thumbnail"></td>'.
						'<td class="product-name" data-title="Товар" style="color: grey; font-weight: bold; font-size: 22px;" >Ожидает поступления:</td>'.
						'<td class="product-price" data-title="Цена"></td>'.
						'<td class="product-quantity" data-title="Количество"></td>'.
						'<td class="product-subtotal" data-title="Итого"></td>'.
						'</tr>';

				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					
					if(in_array($cart_item_key, $massiv_null)){
						//
					}else{
						continue;
					}//if(array_search($cart_item_key, $massiv_null))
					
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

							<td class="product-remove">
								<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
										__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
								?>
							</td>

							<td class="product-thumbnail">
								<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo $thumbnail;
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
									}
								?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
								<?php
									if ( ! $product_permalink ) {
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
									} else {
										echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a style="color: grey;" href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
									}

									// Meta data
									echo WC()->cart->get_item_data( $cart_item );

									// Backorder notification
									if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
										echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
									}
								?>
							</td>

							<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
							</td>

							<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
							</td>

							<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
	
							</td>
						</tr>
						<?php
					}
				}//foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) 	
			}
			if(count($massiv_null2)>0){
				echo 	'<tr class="woocommerce-cart-form__cart-item cart_item">'.
						'<td class="product-remove"></td>'.
						'<td class="product-thumbnail"></td>'.
						'<td class="product-name" data-title="Товар" style="color: red; font-weight: bold; font-size: 22px;" >Под заказ:</td>'.
						'<td class="product-price" data-title="Цена"></td>'.
						'<td class="product-quantity" data-title="Количество"></td>'.
						'<td class="product-subtotal" data-title="Итого"></td>'.
						'</tr>';
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					
					if(in_array($cart_item_key, $massiv_null2)){
						//
					}else{
						continue;
					}//if(array_search($cart_item_key, $massiv_null))
					
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

							<td class="product-remove">
								<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
										__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
								?>
							</td>

							<td class="product-thumbnail">
								<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo $thumbnail;
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
									}
								?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
								<?php
									if ( ! $product_permalink ) {
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
									} else {
										echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a style="color: red;" href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
									}

									// Meta data
									echo WC()->cart->get_item_data( $cart_item );

									// Backorder notification
									if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
										echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
									}
								?>
							</td>

							<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
							</td>

							<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">

							</td>

							<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">

							</td>
						</tr>
						<?php
					}
				}//foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) 		
			}
			//<--кк
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<input type="submit" class="button" style="display: none;" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" />

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<div class="cart-collaterals">
	<?php do_action( 'woocommerce_cart_collaterals' ); ?>
</div>
<script type="text/javascript">
	//клик по + и -(корзина)
	function func_plus_basket_torg(elem){
		var parent_tr = elem.parent().parent();
    	var tek_el = parent_tr.children(".product-quantity").children(".quantity").children();
		tek_el.focus();
		var result = +tek_el.val()+1;
		tek_el.val(result);
		$(".actions .button").prop('disabled', false);	
		$(".actions .button").click();
		$('.input-text.qty.text').attr("type","text");
	}

	function func_minus_basket_torg(elem){
		var parent_tr = elem.parent().parent();
    	var tek_el = parent_tr.children(".product-quantity").children(".quantity").children();
		tek_el.focus();
		var result = +tek_el.val()-1;
		if (result>=1){
			tek_el.val(result);
			$(".actions .button").prop('disabled', false);	
			$(".actions .button").click();
			$('.input-text.qty.text').attr("type","text");
		}
	}
	$('.input-text.qty.text').attr("type","text");
	setInterval(function(){
		$('.input-text.qty.text').attr("type","text"); 
	}, 500);
</script>
<style type="text/css">
	.woocommerce-shipping-calculator{
		display: none;
	}
	table.cart td, table.cart th {
		vertical-align: middle !important;
		padding:0px !important;
	}
</style>
<?php do_action( 'woocommerce_after_cart' ); ?>
