<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>




<?php
//Миниконтроллер - начало
$kk_view = empty($_GET['edit_order']) ? 'main' : $_GET['edit_order'];
if($kk_view!='main'){
	echo '<p>Заказ №' . $kk_view . '</p>';
	echo '<p>Форма редактирования заказа!</p>';
	$kk_order = wc_get_order((int)$kk_view);
	$order_data = $kk_order->get_data(); // The Order data
	$order_status = $order_data['status'];
	if($order_status!='processing'){
?>
		<script type="text/javascript">
		alert("Заказ уже обработан!Редактирование запрещено!");
		location.href = 'http://universam-online.ru/my_account/orders/';
		</script>
<?php		
	}else{
		//очищаем корзину
		global $woocommerce;
		$woocommerce->cart->empty_cart();
		//кладем в корзину все что есть в ордере
		foreach( $kk_order-> get_items() as $item_key => $item_values ){
			$item_data = $item_values->get_data();
			for ($i = 1; $i <= $item_data['quantity']; $i++) {
				$woocommerce->cart->add_to_cart( (int)$item_data['product_id']);
			}
		}
		//удаляем ордер
		wp_delete_post((int)$kk_view,true);
		//echo '<pre>' . print_r($kk_order) . '</pre>';
?>
		<script type="text/javascript">
		alert("Заказ восстановлен в корзине для редактирования!");
		location.href = 'http://universam-online.ru/zakaz/';
		</script>
<?php
	}//if($order_status!='processing')	
}else{
	$kk_view2 = empty($_GET['copy_order']) ? 'main' : $_GET['copy_order'];
	if($kk_view2!='main'){
		//очищаем корзину
		global $woocommerce;
		$woocommerce->cart->empty_cart();
		$kk_order = wc_get_order((int)$kk_view2);
		$order_data = $kk_order->get_data(); // The Order data
		//кладем в корзину все что есть в ордере
		foreach( $kk_order-> get_items() as $item_key => $item_values ){
			$item_data = $item_values->get_data();
			for ($i = 1; $i <= $item_data['quantity']; $i++) {
				$woocommerce->cart->add_to_cart( (int)$item_data['product_id']);
			}
		}
?>
		<script type="text/javascript">
		alert("Заказ скопирован!");
		location.href = 'http://universam-online.ru/zakaz/';
		</script>
<?php		
	}//if($kk_view2!='main')
//Миниконтроллер - конец
?>



<?php if ( $has_orders ) : ?>

	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ( $customer_orders->orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				$item_count = $order->get_item_count();
				$kk_order_data = $order->get_data(); // The Order data
				$kk_order_status = $kk_order_data['status'];
				?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
									<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
								</a>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								//printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count );
								echo $order->get_formatted_order_total(); 
								?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
								<div id="orders_list">
								<?php
									$actions = array(
										'pay'    => array(
											'url'  => $order->get_checkout_payment_url(),
											'name' => __( 'Pay', 'woocommerce' ),
										),
										'view'   => array(
											'url'  => $order->get_view_order_url(),
											'name' => __( 'View', 'woocommerce' ),
										),
										'cancel' => array(
											'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
											'name' => __( 'Cancel', 'woocommerce' ),
										),
									);

									if ( ! $order->needs_payment() ) {
										unset( $actions['pay'] );
									}

									if ( ! in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
										unset( $actions['cancel'] );
									}

									if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
										foreach ( $actions as $key => $action ) {
									?>
												<div>
													<a style="color: #fff;" href="<?php if ($key=='view'){ echo '/my_account/?view-order=' . $order->get_order_number();} else{ echo esc_url( $action['url'] );} ?>" class="woocommerce-button button <?php echo sanitize_html_class( $key );?>"><?php echo esc_html( $action['name'] ); ?></a>
												</div>
									<?php
										}
									}
								?>
								<!--Редактировать заказ - начало-->
								<?php
								if($kk_order_status!='processing'){
									$kk_href='javascript:void(0)';
									$kk_button_active = false;
								}else{
									$kk_href= 'http://universam-online.ru/my_account/orders/?edit_order=' . $order->get_order_number();
									$kk_button_active = true;
								}
								?>
								<div>
									<a style="color: #fff;" href="<?php echo $kk_href; ?>" class="woocommerce-button button" <?php if($kk_button_active==false) echo 'style="background: gray;"';?>>Редактировать</a>
								</div>
								<div>
									<a style="color: #fff;" href="http://universam-online.ru/my_account/orders/?copy_order=<?php echo $order->get_order_number(); ?>" class="woocommerce-button button">Скопировать</a>
								</div>
								<!--Редактировать заказ - конец-->
								</div>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php _e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php _e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php _e( 'Go shop', 'woocommerce' ) ?>
		</a>
		<?php _e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php //кк--> ?>
<?php
	function add_product_to_cart2($product_id) {
		//if ( ! is_admin() ):
			/*$found = false;*/
			//check if product already in cart
			/*if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
				foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
					$_product = $values['data'];
					if ( $_product->id == $product_id )
						$found = true;
				}
				// if product not found, add it
				if ( ! $found )*/
					WC()->cart->add_to_cart( $product_id );
			/*} else {
			
				// if no products in cart, add it
				WC()->cart->add_to_cart( $product_id );
			}*/
		//endif;
	}
?>
<?php
	$server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
	mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
	mysqli_set_charset($server_bd,"utf8");

	if(!empty($_GET['backet_del'])){
		$delid = $_GET['backet_del'];
		$query = "DELETE FROM kk_basket WHERE basket_id = $delid";
		$res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd)); 
	}//if(!empty($_GET['backet_del']))
	

	if(!empty($_GET['backet_return'])){
		global $woocommerce;
		$woocommerce->cart->empty_cart();
		
		$returnid = $_GET['backet_return'];
		$query = "SELECT * FROM kk_basket WHERE basket_id = $returnid";
		$res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd)); 
		$list_return = array();
		while($row = mysqli_fetch_assoc($res)){
			$list_return[] = $row;
		}
		$massiv_tov = explode("_", $list_return[0]['basket']);	
		$coint_item = 1;
		$productid = 0;
		foreach($massiv_tov as $itemM){
			if($coint_item==1){
				$productid = $itemM;
			}else{
				for ($i = 1; $i <= $itemM; $i++) {
					add_product_to_cart2($productid);
					//WC()->cart->add_to_cart( $product_id );
				}
			}//if($coint_item==1)

			$coint_item++;
			if($coint_item>2) $coint_item=1;
		}
		if($res==true):
?>
<script type="text/javascript">
$(document).ready(function(){
	location.href = 'http://universam-online.ru/zakaz/';
});
</script>
<?php
		endif;
	}//if(!empty($_GET['backet_return']))
		
	if(!empty($_GET['backet_add'])){
		$addid = $_GET['backet_add'];
		global $woocommerce;
		$backettext = "";
		foreach ( $woocommerce->cart->cart_contents as $key => $values ) {
			if($backettext == ""){
				$backettext = $values['data']->get_id(). '_' . $values['quantity'];
			}else{
				$backettext = $backettext . '_' . $values['data']->get_id(). '_' . $values['quantity'];
			}
		}//foreach ( $woocommerce->cart->cart_contents as $key => $values ) 
		$total_cart_main = $woocommerce->cart->get_cart_total();
		$total_cart  = str_replace('<span class="woocommerce-Price-amount amount">', '', $total_cart_main);
		$total_cart  = str_replace('&nbsp;<span class="woocommerce-Price-currencySymbol"><span class="rur">р<span>уб.</span></span></span></span>', '', $total_cart);
		$total_cart  = str_replace(' ', '', $total_cart);
		$total_cart_float = (float)$total_cart;
		/*if($total_cart_float<2000){
			echo '<ul class="woocommerce-error"><li><strong>Внимание! Минимальная сумма заказа должна быть не менее: 2000 RUB.</strong><br>Текущая сумма заказа: '.$total_cart.' RUB</li></ul>';
		}else{*/
			$query = "INSERT INTO `kk_basket` (`user_id`, `date`, `basket`,`sum`) VALUES ($addid, now() , '$backettext','$total_cart_main')";
			$res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd)); 
		/*}*/
	}//if(!empty($_GET['backet_add']))

////////////////////////////////////////////////////////////////////

	$cur_user_id = get_current_user_id();
    $query = "SELECT * FROM kk_basket WHERE user_id = $cur_user_id";
	$res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd)); 
    $list_cache = array();

    while($row = mysqli_fetch_assoc($res)){
        $list_cache[] = $row;
    }
	
	// закрываем подключание к базе данных
	mysqli_close($server_bd);
?>
<header class="entry-header">
	<h1 class="entry-title">Черновики</h1>		
</header>
<a href="?backet_add=<?php echo $cur_user_id; ?>">Добавить текущую корзину в черновик</a>
<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
	<thead>
		<tr>
			<th class="woocommerce-orders-table__header"><span class="nobr">Номер</span></th>
			<th class="woocommerce-orders-table__header"><span class="nobr">Дата</span></th>
			<th class="woocommerce-orders-table__header"><span class="nobr">Сумма</span></th>
			<th class="woocommerce-orders-table__header"><span class="nobr"></span></th>
			<th class="woocommerce-orders-table__header"><span class="nobr"></span></th>
		</tr>
	</thead>

	<tbody>
	<?php if(sizeof($list_cache)>0): ?>
		<?php foreach($list_cache as $item): ?>
		<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
			<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Заказ">
				<?php echo $item['basket_id']; ?>
			</td>
			<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Дата">
				<time datetime="2017-06-26T14:23:39+00:00"><?php echo $item['date']; ?></time>
			</td>
			<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Сумма">
				<?php echo $item['sum']; ?>
			</td>
			<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions" data-title="Действия">
				<a href="?backet_return=<?php echo $item['basket_id']; ?>" class="woocommerce-button button view">Восстановить</a>
			</td>
			<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions" data-title="Действия">
				<a href="?backet_del=<?php echo $item['basket_id']; ?>" class="woocommerce-button button view">Удалить</a>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
<?php //<--кк ?>

<?php
//Миниконтроллер - начало
}
//Миниконтроллер - начало
?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
