<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Заказ</a></li>
    <li><a href="#tabs-2">Доставка</a></li>
    <li><a href="#tabs-3">Оплата</a></li>
  </ul>
  <div id="tabs-1">
      <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
          <thead>
          <tr>
              <th class="product-remove">&nbsp;</th>
              <th class="product-thumbnail">&nbsp;</th>
              <th class="product-name" style="font-size: 22px;"><?php _e( 'Product', 'woocommerce' ); ?></th>
              <th class="product-price" style="font-size: 22px;"><?php _e( 'Price', 'woocommerce' ); ?></th>
              <th class="product-quantity" style="font-size: 22px;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
              <th class="product-subtotal" style="font-size: 22px;"><?php _e( 'Total', 'woocommerce' ); ?></th>
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
                          <div class="minus_basket_torg" id="<?php echo $product_id; ?>" onclick="func_minus_zakaz($(this));">-</div>
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
                          <div class="plus_basket_torg" id="<?php echo $product_id; ?>" onclick="func_plus_zakaz($(this));">+</div>
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

      <table class="shop_table" id="kk_order_review">
			<tfoot>
				<?php 
				//kk-->
				//calculate position true
				$total_true = 0;
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					
					$have_pod_zakak = false;
					$kk_attributes = $_product->get_attributes();
					foreach ( $kk_attributes as $kk_attribute ) {
						if($kk_attribute['data']['name']=="Под заказ"){
							if($kk_attribute['data']['value']=="Да") $have_pod_zakak = true;
						}
					}
					if($have_pod_zakak==true){
						continue;
					}			
						
					$real_ost = $_product->stock_quantity - 1000000;
					if($real_ost<=0){
						continue;
					}	
					$quantity_cart = $cart_item['quantity']; 
					$price_cart    = get_post_meta($cart_item['product_id'] , '_price', true);
					$total_true = $total_true + $quantity_cart*$price_cart;
				}
				//<--kk
				?>

				<tr class="cart-subtotal">
					<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
					<td>
						<?php 
							echo $total_true . ' руб.';
						?>
					</td>
				</tr>

				<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

			</tfoot>
      </table>

  </div>
  <div id="tabs-2">
	<table cellspacing="0" class="shop_table shop_table_responsive">
	<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
		<?php wc_cart_totals_shipping_html(); ?>
		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
	<?php endif; ?>
	</table>
	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
  </div>
  <div id="tabs-3">
	<?php global $user_ID; ?>
	<?php if (!$user_ID){?> 
		<a style="width: 100%; height: 40px; margin-bottom: 20px;background-color: #1e73be;border-color: #1e73be;color: #ffffff;display: block;text-align: center;line-height: 41px;" id="login-ajax" href="#">Вход/Регистрация</a>
	<?php }else{ ?>
        <table class="shop_table" id="kk_order_review">
            <tfoot>
            <?php
            //kk-->
            //calculate position true
            $total_true = 0;
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                $have_pod_zakak = false;
                $kk_attributes = $_product->get_attributes();
                foreach ( $kk_attributes as $kk_attribute ) {
                    if($kk_attribute['data']['name']=="Под заказ"){
                        if($kk_attribute['data']['value']=="Да") $have_pod_zakak = true;
                    }
                }
                if($have_pod_zakak==true){
                    continue;
                }

                $real_ost = $_product->stock_quantity - 1000000;
                if($real_ost<=0){
                    continue;
                }
                $quantity_cart = $cart_item['quantity'];
                $price_cart    = get_post_meta($cart_item['product_id'] , '_price', true);
                $total_true = $total_true + $quantity_cart*$price_cart;
            }

            $shipping_cart = str_replace("Бесплатно!","",WC()->cart->get_cart_shipping_total());
            if(strlen($shipping_cart)==0){
                $shipping_cart_float = 0;
            }else{
                $shipping_cart_float = 400;
            }

            //если первый раз открыли(то есть нет сессии, то со счета спишим 20%)
            if(empty($_SESSION['bonus'])){
            }//if(empty($_SESSION['bonus']))

            if(!empty($_SESSION['bonus']) && !empty($_SESSION['purse'])){
                $order_total_true = $total_true + $shipping_cart_float - $_SESSION['bonus'] - $_SESSION['purse'];
            }elseif(!empty($_SESSION['bonus'])){
                $order_total_true = $total_true + $shipping_cart_float - $_SESSION['bonus'];
            }elseif(!empty($_SESSION['purse'])){
                $order_total_true = $total_true + $shipping_cart_float - $_SESSION['purse'];
            }else{
                $order_total_true = $total_true + $shipping_cart_float;
            }
            //<--kk
            ?>

            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                    <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                    <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php
            $visible_shipping = false;
            ?>
            <?php if ($visible_shipping && WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

                <?php wc_cart_totals_shipping_html(); ?>

                <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

            <?php endif; ?>

            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                <tr class="fee">
                    <th><?php echo esc_html( $fee->name ); ?></th>
                    <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php
            $visible_tax = false;
            ?>
            <?php if ( $visible_tax && wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
                <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                        <tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                            <th><?php echo esc_html( $tax->label ); ?></th>
                            <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr class="tax-total">
                        <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                        <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

            <tr class="order-total">
                <th style="color:red;">Оплатить со счёта</th>
                <td><input type="number" class="input-text" name="bonus_input" id="kk_bonus_input" value="<?php echo $_SESSION['bonus']; ?>"></td>
            </tr>
            <tr>
                <th></th>
                <td style="text-align:left;"><small class="orddd_lite_field_note">(Не более 20% от суммы заказа)</small></td>
            </tr>
            <tr class="order-total">
                <th style="color:red;padding-top: 20px !important;">Оплатить из кошелька</th>
                <td style="padding-top: 20px !important;"><input type="number" class="input-text" name="purse_input" id="kk_purse_input" value="<?php echo $_SESSION['purse']; ?>"></td>
            </tr>

            <tr class="order-total">
                <th style="color:red;"></th>
                <td><input class="button kk_button_bonus" style="padding: .6180469716em;text-align: center;margin-top: 10px;margin-bottom: 10px;" value="Применить" /></td>
            </tr>

            <tr class="order-total">
                <th><?php _e( 'Total', 'woocommerce' ); ?></th>
                <td>
                    <?php
                    //wc_cart_totals_order_total_html();
                    echo $order_total_true . ' руб.';
                    ?>
                </td>
            </tr>


            <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

            </tfoot>
        </table>

		<div id="payment" class="woocommerce-checkout-payment">
			<?php if ( WC()->cart->needs_payment() ) : ?>
				<ul class="wc_payment_methods payment_methods methods">
					<?php
						if ( ! empty( $available_gateways ) ) {
							foreach ( $available_gateways as $gateway ) {
								wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
							}
						} else {
							echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : __( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>';
						}
					?>
				</ul>
			<?php endif; ?>
			<div class="form-row place-order">
				<noscript>
					<?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?>
					<br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>" />
				</noscript>

				<?php wc_get_template( 'checkout/terms.php' ); ?>

				<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

				<?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>

				<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

				<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
			</div>
		</div> 
	<?php } ?>
   </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#shipping_method li").click(function(){
			setTimeout(function(){
				document.location.href = document.location;
			},1000);
		});
		setTimeout(clear_br, 2000);
		$('.kk_button_bonus').click(function(){
			ajax_bonus();
		});
	});
	function ajax_bonus(){
		$.ajax({  
			url: "/kk_script/ajax_bonus.php",  
			type: "POST",
			data: 'number1=' + $('#kk_bonus_input').val() + '&number2=' + $('#kk_purse_input').val() + '&totalbacket=' + $('.cart-subtotal').html(),
			cache: false,  
			success: function(html){  
				alert(html);  
			}  
		});	
		window.location.href="http://universam-online.ru/zakaz/";		
	}
	function clear_br(){
		$('.product-name').each(function(i,elem) {
			var it_text = $(this).html().replace("<br>","");
			$(this).html(it_text);
		});	
		$('tr.shipping td').attr('colspan',4);
		$('#kk_order_review').removeAttr("style");
	}
	$('#billing_city').val('Москва и МО');
</script>
<script type="text/javascript">
    //клик по + и -(корзина)
    function func_plus_zakaz(elem){
        $.ajax({
            url: "/kk_script/ajax_update_basket.php",
            type: "POST",
            data: 'product_id=' + elem.attr("id") + '&type_operation=plus',
            cache: false,
            success: function(html){
                window.location.href="http://universam-online.ru/zakaz/";
            }
        });
    }

    function func_minus_zakaz(elem){
        $.ajax({
            url: "/kk_script/ajax_update_basket.php",
            type: "POST",
            data: 'product_id=' + elem.attr("id") + '&type_operation=minus',
            cache: false,
            success: function(html){
                window.location.href="http://universam-online.ru/zakaz/";
            }
        });
    }
    $('.product-quantity .input-text.qty.text').attr("type","text");
    $('.product-quantity .input-text.qty.text').attr("disabled","text");
</script>