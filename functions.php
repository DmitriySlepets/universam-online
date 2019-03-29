<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version' => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce = require 'inc/woocommerce/class-storefront-woocommerce.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';
}

//КК-->
require 'classes/Util.php';
if(!Util::checkMobileDevice()){
    require 'modules/left-sidebar.php';
}
//подключим скрипты
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method(){
    wp_enqueue_script( 'mycript', get_template_directory_uri() . '/js/kk_script.js');
}
//подключаем css
function my_theme_load_resources() {
    wp_enqueue_style('allStyle', get_template_directory_uri() . '/css/allStyle.css');
    wp_enqueue_style('loginRegistration', get_template_directory_uri() . '/css/loginRegistration.css');
    wp_enqueue_style('singleProductStyle', get_template_directory_uri() . '/css/single-product.css');
    if(Util::checkMobileDevice()){
        wp_enqueue_style('mobile', get_template_directory_uri() . '/css/mobile.css');
    }
}
add_action('wp_enqueue_scripts', 'my_theme_load_resources');

//аякс авторизация
//  Ajax Login
function ajax_login_init(){

    /* Подключаем скрипт для авторизации */
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax_form.js', array('jquery') );
    wp_enqueue_script('ajax-login-script');

    /* Локализуем параметры скрипта */
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => $_SERVER['REQUEST_URI'],
        'loadingmessage' => __('Идет проверка данных...')
    ));

// Разрешаем запускать функцию ajax_login() пользователям без привелегий
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}


function ajax_login(){
// Первым делом проверяем параметр безопасности
    check_ajax_referer( 'ajax-login-nonce', 'security' );

// Получаем данные из полей формы и проверяем их
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Неправильный логин или пароль!')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Отлично! Идет перенаправление...')));
    }

    die();
}

// Выполняем авторизацию только если пользователь не вошел
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

//Выпад списки и надписи - Сортировка  - Кол-во на странице  - Скрой
add_action('init','delay_remove');
function delay_remove() {
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
	// Remove the result count from WooCommerce
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
}
//списание бонусов в заказе
add_action('woocommerce_cart_calculate_fees' , 'wo_discount_total');
function wo_discount_total( WC_Cart $cart ){
	$wo_current_price = $cart->subtotal; //получаем текущую цену
	$discount = (float)$_SESSION['bonus']; 
	$cart->add_fee( 'Будет списано со счета', -$discount);
	$purse = (float)$_SESSION['purse']; 
	$cart->add_fee( 'Будет списано с кошелька', -$purse);
	//unset($_SESSION['bonus']);
}

//удалим оплату со старого места
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);

//личный кабинет - начало
add_filter( 'woocommerce_account_menu_items', 'iconic_account_menu_items', 10, 1 );
function iconic_account_menu_items( $items ) {
	$items['information'] = __( 'Мой счет', 'iconic' );
	return $items;
}

function iconic_add_my_account_endpoint() {
	add_rewrite_endpoint( 'information', EP_PAGES );
}
add_action( 'init', 'iconic_add_my_account_endpoint' );
function iconic_information_endpoint_content() {
	//echo '<header class="entry-header"><h1 class="entry-title">Мой счет</h1></header>';
	include "kk_script/page_score.php";
}
add_action( 'woocommerce_account_information_endpoint', 'iconic_information_endpoint_content' );

function woo_change_account_order() {
    $myorder = array(
        'information'        => __( 'Мой счет', 'iconic' ),	
		'orders'             => __( 'Заказы', 'woocommerce' ),
        'edit-account'       => __( 'Настройки', 'woocommerce' ),
        'customer-logout'    => __( 'Выйти', 'woocommerce' )
    );
    return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'woo_change_account_order' );
//сохранить поля в личном кабинете
add_action( 'woocommerce_save_account_details', 'my_account_saving_billing_phone', 10, 1 );
function my_account_saving_billing_phone( $user_id ) {
	$account_first_name = $_POST['account_first_name'];
	if(!empty($account_first_name)){
        update_user_meta( $user_id, 'billing_first_name', sanitize_text_field( $account_first_name));
		update_user_meta( $user_id, 'shipping_first_name', sanitize_text_field( $account_first_name));	
	}
	$account_last_name = $_POST['account_last_name'];
	if(!empty($account_last_name)){
        update_user_meta( $user_id, 'billing_last_name', sanitize_text_field( $account_last_name));
		update_user_meta( $user_id, 'shipping_last_name', sanitize_text_field( $account_last_name));		
	}
	$account_email = $_POST['account_email'];
	if(!empty($account_email)){
        update_user_meta( $user_id, 'billing_email', sanitize_text_field( $account_email));	
	}
    $billing_phone = $_POST['billing_phone'];
    if(!empty($billing_phone)){
        update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $billing_phone ));
	}
	$display_name = $_POST['display_name'];
    if(!empty($display_name )){
        update_user_meta( $user_id, 'display_name', sanitize_text_field( $display_name));
	}
	$billing_address_1 = $_POST['billing_address_1'];
    if(!empty($billing_address_1 )){
        update_user_meta( $user_id, 'billing_address_1', sanitize_text_field( $billing_address_1));
	}
}
add_filter('pre_user_display_name','default_display_name');
function default_display_name($name) {
	if ( isset( $_POST['display_name'] ) ) {
		$name = sanitize_text_field( $_POST['display_name'] );
	}
	return $name;
}

//личный кабинет - конец

//добавить новые поля в профиль пользователя
add_filter('user_contactmethods', 'my_user_contactmethods');
 
function my_user_contactmethods($user_contactmethods){
 
  $user_contactmethods['kk_referal'] = 'Реферальная ссылка';
  $user_contactmethods['kk_promocod'] = 'Промокод';

  return $user_contactmethods;
}
//////////////ФИЗИЧЕСКИЕ/ЮРИДИЧЕСКИЕ - НАЧАЛО////////////////////////////
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
	$array_result = array();
	////////////////ПЛАШКА////////////////////
	$fields['billing']['fiz_ur']['required'] = true;
	$fields['billing']['fiz_ur']['placeholder'] = 'Физическое лицо/Юридическое лицо';
    $fields['billing']['fiz_ur']['label'] = 'Тип покупателя';
	$fields['billing']['fiz_ur']['type'] = 'select';
	$fields['billing']['fiz_ur']['options'] = array(
	  'option_1' => 'Физическое лицо',
	  'option_2' => 'Юридическое лицо'
	);
	$array_result['fiz_ur'] = $fields['billing']['fiz_ur'];
	/////////////////////////////////////////////////////
	if(isset($_GET['type']) && $_GET['type']=='ur_lizo') {
		////////////////ОБЯЗАТЕЛЬНЫЕ////////////////////
		//компания
		$fields['billing']['billing_name1']['label'] = 'Компания';
		$array_result['billing_name1'] = $fields['billing']['billing_name1'];
		
		$fields['billing']['billing_company']['required'] = true;
		$fields['billing']['billing_phone']['label'] = 'Телефон';
		$fields['billing']['billing_phone']['required'] = true;
		$fields['billing']['billing_email']['required'] = true;
		$fields['billing']['billing_address_1']['required'] = true;	
		$fields['billing']['billing_address_2']['label'] = "Подъезд/этаж";
		$fields['billing']['billing_address_2']['required'] = false;	
		$fields['billing']['billing_country']['required'] = false;
		
		$array_result['billing_company'] = $fields['billing']['billing_company'];
		$array_result['billing_phone'] = $fields['billing']['billing_phone'];
		$array_result['billing_email'] = $fields['billing']['billing_email'];
		$array_result['billing_address_1'] = $fields['billing']['billing_address_1'];	
		$array_result['billing_address_2'] = $fields['billing']['billing_address_2'];
		$array_result['billing_country'] = $fields['billing']['billing_country'];
		
		//контактное лицо
		$fields['billing']['billing_name2']['label'] = 'Контактное лицо';
		$array_result['billing_name2'] = $fields['billing']['billing_name2'];
		
		$fields['billing']['billing_first_name']['label'] = 'Имя';
		$fields['billing']['billing_first_name']['required'] = true;
		$fields['billing']['billing_last_name']['label'] = 'Фамилия';
		$fields['billing']['billing_last_name']['required']  = false;
		
		$fields['billing']['billing_email_cont']['label'] = "Почта";
		$fields['billing']['billing_email_cont']['placeholder'] = "ivanov@mail.ru";
		$fields['billing']['billing_email_cont']['required'] = true;
		
		$fields['billing']['billing_phone_cont']['label'] = "Телефон";
		$fields['billing']['billing_phone_cont']['placeholder'] = "+7(901)1234568";
		$fields['billing']['billing_phone_cont']['required'] = true;
		
		$array_result['billing_first_name'] = $fields['billing']['billing_first_name'];
		$array_result['billing_last_name'] = $fields['billing']['billing_last_name'];
		$array_result['billing_email_cont'] = $fields['billing']['billing_email_cont'];
		$array_result['billing_phone_cont'] = $fields['billing']['billing_phone_cont'];

	}else{
		////////////////ОБЯЗАТЕЛЬНЫЕ////////////////////
		//1.имя
		$fields['billing']['billing_first_name']['required'] = true;
		//2.фамилия
		$fields['billing']['billing_last_name']['required'] = true;
		//3.телефон - обязательное поле
		$fields['billing']['billing_phone']['required'] = true;
		//4.почта - обязательное поле
		$fields['billing']['billing_email']['required'] = true;
		//5.адрес доставки - обязательное поле
		$fields['billing']['billing_address_1']['label'] = 'Адрес доставки';
		$fields['billing']['billing_address_1']['required'] = true;
		
		$fields['billing']['billing_address_2']['label'] = "Подъезд/этаж";
		$fields['billing']['billing_address_2']['required'] = false;
		$fields['billing']['billing_country']['required'] = false;		
		////////////////ОСТАЛЬНЫЕ////////////////////
		//1.компания - обязательное поле
		$fields['billing']['billing_company']['required'] = false;
		unset($fields['billing']['billing_company']);
		/////////////////////////////////////////////////
		$array_result['billing_first_name'] = $fields['billing']['billing_first_name'];
		$array_result['billing_last_name'] = $fields['billing']['billing_last_name'];
		$array_result['billing_phone'] = $fields['billing']['billing_phone'];
		$array_result['billing_email'] = $fields['billing']['billing_email'];
		$array_result['billing_address_1'] = $fields['billing']['billing_address_1'];
		$array_result['billing_address_2'] = $fields['billing']['billing_address_2'];
		$array_result['billing_country'] = $fields['billing']['billing_country'];
	}
	/////////////////////////////////////////////////////
	$fields['billing'] = $array_result;
	return $fields;
	
}
//////////////ФИЗИЧЕСКИЕ/ЮРИДИЧЕСКИЕ - КОНЕЦ////////////////////////////

//Карточка товаров - начало
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30); //удаляем стандартный укладчик в корзину
//Карточка товаров - конец


//исключаем лишние категории
add_filter( 'get_terms', 'get_subcategory_terms', 10, 3 );
function get_subcategory_terms( $terms, $taxonomies, $args ) {
  $new_terms = array();
  // если находится в товарной категории и на странице магазина
  if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {
    foreach ( $terms as $key => $term ) {
		if ( is_user_logged_in() ){ 
			$new_terms[] = $term;
		}else{
      		if ( ! in_array( $term->term_id, array( '519' ) ) ) {
        		$new_terms[] = $term;
      		}
		}
	  	//print_r($term);
    }
    $terms = $new_terms;
  }
  return $terms;
}
//////////////////////////////////////
//при выводе товара
add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
function custom_pre_get_posts_query( $q ) {
	if ( is_user_logged_in() ){ 
	}else{
		if ( is_product_category()) {
			$q->set( 'tax_query', array(array(
				'taxonomy' => 'product_cat',
				'field' => 'name',
				'terms' => array( 'Сигареты','Пиво','Пиво +' ),
				'operator' => 'NOT IN'
			)));
		}
		remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
	}//if ( is_user_logged_in() )
}

//////////////////////////////////////
//Количество колонок товаров
add_filter('loop_shop_columns',function($col){ return 5 ; });
//Меняем логотип при входе в админку
function my_login_logo(){
   echo '
   <style type="text/css">
        #login h1 a { background: none !important; }
		.kk_login{display: block; width:100%;}
		.kk_login a{display: block; width:100%; margin:0 auto; text-align: center; text-decoration: none;}
		.kk_login img{display: block; margin:0 auto; height: 162px; margin-bottom: -105px;}
    </style>
	<div class="kk_login">
	<a href="/" style="color: #0066bf; padding: 10px; font-size: 25px; line-height: 10px;">универсам-онлайн.рф</a>
	<img src="/images/logo.png">
	</div>
	';
}
add_action('login_head', 'my_login_logo');
// Область виджетов в шапке
register_sidebar(array(
	'name' => __('Виджеты для шапки'),
	'id' => 'header-widget-area',
	'description' => __('Виджеты в шапке, например для баннера'),
	'before_widget' => '',
	'after_widget' => '',
    'before_title' => '<span style="display: none;"><a href="#">',
    'after_title' => '</a></span>',
));

/******************Смена статусов-начало*****************************/
//На согласовании(новый заказ)
add_action('kk_status_na_soglasovanii', 'kk_status_na_soglasovanii');
function kk_status_na_soglasovanii( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = $order_billing_email;
	$subject     = 'Квитанция вашего заказа на Универсам-онлайн от  ' . $order_date_created;
	
	$massiv_null = array();
	$massiv_null2 = array();
	
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Ваш заказ получен. Нам нужно немного времени, чтобы все проверить.' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';
	
	///////////////////////БЛОК-ВНАЛИЧИИ-НАЧАЛО//////////////////////////////////
	
	///////////заголовок подтаблицы - начало//////////////////
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . '<h2>В наличии:</h2>';
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	///////////заголовок подтаблицы - конец///////////////////
	
	foreach( $order-> get_items() as $item_key => $item_values ):
	
	$item_data = $item_values->get_data();
	$product = new WC_Product($item_data['product_id']);
	
	///////////разбиваем по массивам - начало/////////////////
	$have_pod_zakak = false;
	$kk_attributes = $product->get_attributes();
	foreach ( $kk_attributes as $kk_attribute ) {
		if($kk_attribute['data']['name']=="Под заказ"){
			if($kk_attribute['data']['value']=="Да") $have_pod_zakak = true;
		}
	}
	if($have_pod_zakak==true){
		$massiv_null2[] = $item_key;
		continue;
	}					
	$real_ost = $product->stock_quantity - 1000000;
	if($real_ost<=0){
		$massiv_null[] = $item_key;
		continue;
	}
	///////////разбиваем по массивам - конец//////////////////
	
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	if($item_data['quantity']==0){
		$message = $message . "0";		
	}else{
		$message = $message . $item_data['total']/$item_data['quantity'];
	}
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	///////////////////////БЛОК-ВНАЛИЧИИ-КОНЕЦ//////////////////////////////////	
	
	///////////////////////ТРЕБУЕТ УТОЧНЕНИЯ-НАЧАЛО//////////////////////////////////
	if(count($massiv_null)>0){
		///////////заголовок подтаблицы - начало//////////////////
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . '<h2>Требует уточнения:</h2>';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '</tr>';
		///////////заголовок подтаблицы - конец///////////////////
		foreach( $order-> get_items() as $item_key => $item_values ):
		
		$item_data = $item_values->get_data();
		$product = new WC_Product($item_data['product_id']);
		
		///////////разбиваем по массивам - начало/////////////////
		if(in_array($item_key, $massiv_null)){
			//
		}else{
			continue;
		}//if(array_search($item_key, $massiv_null))
		///////////разбиваем по массивам - конец//////////////////
		
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . $item_values->get_name();
		$message = $message . '</td>';
						
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['quantity'];			
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		if($item_data['quantity']==0){
			$message = $message . "0";		
		}else{
			$message = $message . $item_data['total']/$item_data['quantity'];
		}
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['total'];	
		$message = $message . '</td>';
		$message = $message . '</tr>';
		endforeach;	
	}//if(count($massiv_null)>0)
	///////////////////////ТРЕБУЕТ УТОЧНЕНИЯ-КОНЕЦ//////////////////////////////////
	
	///////////////////////ПОД ЗАКАЗ-НАЧАЛО//////////////////////////////////
	if(count($massiv_null)>0){
		///////////заголовок подтаблицы - начало//////////////////
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . '<h2>Под Заказ:</h2>';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '</tr>';
		///////////заголовок подтаблицы - конец///////////////////
		foreach( $order-> get_items() as $item_key => $item_values ):
		
		$item_data = $item_values->get_data();
		$product = new WC_Product($item_data['product_id']);
		
		///////////разбиваем по массивам - начало/////////////////
		if(in_array($item_key, $massiv_null2)){
			//
		}else{
			continue;
		}//if(array_search($item_key, $massiv_null2))
		///////////разбиваем по массивам - конец//////////////////
		
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . $item_values->get_name();
		$message = $message . '</td>';
						
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['quantity'];			
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		if($item_data['quantity']==0){
			$message = $message . "0";		
		}else{
			$message = $message . $item_data['total']/$item_data['quantity'];
		}
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['total'];	
		$message = $message . '</td>';
		$message = $message . '</tr>';
		endforeach;	
	}//if(count($massiv_null)>0)
	///////////////////////ПОД ЗАКАЗ-КОНЕЦ//////////////////////////////////
	
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <zakaz@ros-prod-torg.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );
}
//Выполняется(У Заказа установили статус К Выполнению)
add_action('kk_status_vipolnyaetsy', 'kk_status_vipolnyaetsy');
function kk_status_vipolnyaetsy( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = $order_billing_email;
	$subject     = 'Ваш заказ на Универсам-онлайн от ' . $order_date_created . ' подтвержден';
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Заказ №' .$order_id . ' подтвержден!' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';
	foreach( $order-> get_items() as $item_key => $item_values ):
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$item_data = $item_values->get_data(); 
	$product = new WC_Product($item_data['product_id']);
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total']/$item_data['quantity'];
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <zakaz@ros-prod-torg.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );
}
//Передан на доставку(У Заказа есть РТУ)
add_action('kk_peredan_na_dostavku', 'kk_peredan_na_dostavku');
function kk_peredan_na_dostavku( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = $order_billing_email;
	$subject     = 'Ваш заказ на Универсам-онлайн от ' . $order_date_created . ' передан на доставку';
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Заказ №' .$order_id . ' передан на доставку!' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';
	foreach( $order-> get_items() as $item_key => $item_values ):
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$item_data = $item_values->get_data(); 
	$product = new WC_Product($item_data['product_id']);
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total']/$item_data['quantity'];
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <zakaz@ros-prod-torg.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );
}
//Не оплачен(У Заказа есть РТУ, но нет оплаты)
add_action('kk_ne_oplachen', 'kk_ne_oplachen');
function kk_ne_oplachen( $order_id ) {
	//отправлять не надо
}
//Закрыт(У Заказа есть РТУ и есть оплата)
add_action('kk_zakrit', 'kk_zakrit'); 
function kk_zakrit( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = $order_billing_email;
	$subject     = 'Ваш заказ на Универсам-онлайн от ' . $order_date_created . ' закрыт';
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Заказ №' .$order_id . ' закрыт!' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';
	foreach( $order-> get_items() as $item_key => $item_values ):
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$item_data = $item_values->get_data(); 
	$product = new WC_Product($item_data['product_id']);
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total']/$item_data['quantity'];
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <zakaz@ros-prod-torg.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );
}
/******************Смена статусов-конец*****************************/

/* Исполняемый код php в статьях/страницах WordPress: [exec]код[/exec]
----------------------------------------------------------------- */
function exec_php($matches){
    eval('ob_start();'.$matches[1].'$inline_execute_output = ob_get_contents();ob_end_clean();');
    return $inline_execute_output;
}
function inline_php($content){
    $content = preg_replace_callback('/\[exec\]((.|\n)*?)\[\/exec\]/', 'exec_php', $content);
    $content = preg_replace('/\[exec off\]((.|\n)*?)\[\/exec\]/', '$1', $content);
    return $content;
}
add_filter('the_content', 'inline_php', 0);

//отправка админу по статусам
add_action('kk_post_admin_na_soglasovani', 'kk_post_admin_na_soglasovani'); 
function kk_post_admin_na_soglasovani( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = 'zakaz@ros-prod-torg.ru';
	$subject     = 'Роз - Новый Заказ №' . $order_id . ' от ' . $order_date_created;
	
	$massiv_null = array();
	$massiv_null2 = array();
	
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Новый Заказ №' .$order_id . ' !' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';

	///////////////////////БЛОК-ВНАЛИЧИИ-НАЧАЛО//////////////////////////////////
	
	///////////заголовок подтаблицы - начало//////////////////
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . '<h2>В наличии:</h2>';
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	///////////заголовок подтаблицы - конец///////////////////
	
	foreach( $order-> get_items() as $item_key => $item_values ):
	
	$item_data = $item_values->get_data();
	$product = new WC_Product($item_data['product_id']);
	
	///////////разбиваем по массивам - начало/////////////////
	$have_pod_zakak = false;
	$kk_attributes = $product->get_attributes();
	foreach ( $kk_attributes as $kk_attribute ) {
		if($kk_attribute['data']['name']=="Под заказ"){
			if($kk_attribute['data']['value']=="Да") $have_pod_zakak = true;
		}
	}
	if($have_pod_zakak==true){
		$massiv_null2[] = $item_key;
		continue;
	}					
	$real_ost = $product->stock_quantity - 1000000;
	if($real_ost<=0){
		$massiv_null[] = $item_key;
		continue;
	}
	///////////разбиваем по массивам - конец//////////////////
	
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	if($item_data['quantity']==0){
		$message = $message . "0";		
	}else{
		$message = $message . $item_data['total']/$item_data['quantity'];
	}
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	///////////////////////БЛОК-ВНАЛИЧИИ-КОНЕЦ//////////////////////////////////	
	
	///////////////////////ТРЕБУЕТ УТОЧНЕНИЯ-НАЧАЛО//////////////////////////////////
	if(count($massiv_null)>0){
		///////////заголовок подтаблицы - начало//////////////////
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . '<h2>Требует уточнения:</h2>';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '</tr>';
		///////////заголовок подтаблицы - конец///////////////////
		foreach( $order-> get_items() as $item_key => $item_values ):
		
		$item_data = $item_values->get_data();
		$product = new WC_Product($item_data['product_id']);
		
		///////////разбиваем по массивам - начало/////////////////
		if(in_array($item_key, $massiv_null)){
			//
		}else{
			continue;
		}//if(array_search($item_key, $massiv_null))
		///////////разбиваем по массивам - конец//////////////////
		
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . $item_values->get_name();
		$message = $message . '</td>';
						
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['quantity'];			
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		if($item_data['quantity']==0){
			$message = $message . "0";		
		}else{
			$message = $message . $item_data['total']/$item_data['quantity'];
		}
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['total'];	
		$message = $message . '</td>';
		$message = $message . '</tr>';
		endforeach;	
	}//if(count($massiv_null)>0)
	///////////////////////ТРЕБУЕТ УТОЧНЕНИЯ-КОНЕЦ//////////////////////////////////
	
	///////////////////////ПОД ЗАКАЗ-НАЧАЛО//////////////////////////////////
	if(count($massiv_null)>0){
		///////////заголовок подтаблицы - начало//////////////////
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . '<h2>Под Заказ:</h2>';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . '</td>';
		$message = $message . '</tr>';
		///////////заголовок подтаблицы - конец///////////////////
		foreach( $order-> get_items() as $item_key => $item_values ):
		
		$item_data = $item_values->get_data();
		$product = new WC_Product($item_data['product_id']);
		
		///////////разбиваем по массивам - начало/////////////////
		if(in_array($item_key, $massiv_null2)){
			//
		}else{
			continue;
		}//if(array_search($item_key, $massiv_null2))
		///////////разбиваем по массивам - конец//////////////////
		
		$message = $message . '<tr class="order_item">';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
		$message = $message . $item_values->get_name();
		$message = $message . '</td>';
						
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['quantity'];			
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		if($item_data['quantity']==0){
			$message = $message . "0";		
		}else{
			$message = $message . $item_data['total']/$item_data['quantity'];
		}
		$message = $message . '</td>';
		$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
		$message = $message . $item_data['total'];	
		$message = $message . '</td>';
		$message = $message . '</tr>';
		endforeach;	
	}//if(count($massiv_null)>0)
	///////////////////////ПОД ЗАКАЗ-КОНЕЦ//////////////////////////////////			
	
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <postmaster@rosprod.nichost.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );	
}
add_action('kk_post_admin_vipolntetsy', 'kk_post_admin_vipolntetsy'); 
function kk_post_admin_vipolntetsy( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = 'zakaz@ros-prod-torg.ru';
	$subject     = 'Роз - Заказ №' . $order_id . ' от ' . $order_date_created . ' подтвержден!';
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Заказ №' .$order_id . ' подтвержден!' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';
	foreach( $order-> get_items() as $item_key => $item_values ):
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$item_data = $item_values->get_data(); 
	$product = new WC_Product($item_data['product_id']);
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . round($item_data['total']/$item_data['quantity'],2);
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <postmaster@rosprod.nichost.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );	
}
add_action('kk_post_admin_na_dostavku', 'kk_post_admin_na_dostavku'); 
function kk_post_admin_na_dostavku( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = 'zakaz@ros-prod-torg.ru';
	//$to = 'slepec_do@codeking.ru';
	$subject     = 'Роз - Заказ №' . $order_id . ' от ' . $order_date_created . ' передан на доставку';
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Заказ №' .$order_id . ' передан на доставку!' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';
	foreach( $order-> get_items() as $item_key => $item_values ):
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$item_data = $item_values->get_data(); 
	$product = new WC_Product($item_data['product_id']);
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . round($item_data['total']/$item_data['quantity'],2);
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <postmaster@rosprod.nichost.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );
}
add_action('kk_post_admin_close', 'kk_post_admin_close'); 
function kk_post_admin_close( $order_id ) {
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_id = $order_data['id'];
	$order_date_created = $order_data['date_created']->date('d.m.Y');
	$order_billing_email = $order_data['billing']['email'];
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$to          = 'zakaz@ros-prod-torg.ru';
	//$to = 'slepec_do@codeking.ru';
	$subject     = 'Роз - Заказ №' . $order_id . ' от ' . $order_date_created . ' закрыт';
	$message = '';
	$message = $message . '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #557da1; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; width: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">';
	$message = $message . '<tbody>';
	$message = $message . '<tr>';
	$message = $message . '<td id="header_wrapper" style="padding: 36px 48px; display: block">';
	$message = $message . '<h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7797b4; -webkit-font-smoothing: antialiased">' . 'Заказ №' .$order_id . ' закрыт!' . '</h1>';
	$message = $message . '</td>';
	$message = $message . '</tr>';
	$message = $message . '</tbody>';
	$message = $message . '</table>';

    //ИНФО-НАЧАЛО
    $message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">ФИО:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Email:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['email'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Телефон:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['phone'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Адрес доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['billing']['address_1'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    //дата доставки - начало
    // подключимся к базе данных
    $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
    mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
    mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
	
    $id_orders = trim($order_data['id']);
    $id_orders = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $id_orders);
    $id_orders = (int) $id_orders;
    $query = "SELECT * FROM `wp_postmeta` WHERE `meta_key`='Дата доставки' && `post_id` = $id_orders";
    $res = mysqli_query($server_bd, $query) or die(mysqli_error($server_bd));
    $date_dost = "";
    while($row = mysqli_fetch_assoc($res)){
        $date_dost = $row['meta_value'];
    }
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Дата доставки:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $date_dost;
    $message = $message . '</td>';
    $message = $message . '</tr>';
    mysqli_close($server_bd);
    //дата доставки - конец
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Доставка:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order->get_shipping_method();
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Способ оплаты:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['payment_method_title'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '<tr>';
    $message = $message . '<th class="td" colspan="2" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Всего:</th>';
    $message = $message . '<td class="td" colspan="3" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">';
    $message = $message . $order_data['total'];
    $message = $message . '</td>';
    $message = $message . '</tr>';
    $message = $message . '</table>';
    $message = $message . '<p></p>';
    //ИНФО-КОНЕЦ

	$message = $message . '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4" border="1">';
	$message = $message . '<thead>';
	$message = $message . '<tr>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Товар</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Кол-во шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Цена за шт.</th>';
	$message = $message . '<th class="td" style="text-align: left; color: #737373; border: 1px solid #e4e4e4; padding: 12px">Итого</th>';
	$message = $message . '</tr>';
	$message = $message . '</thead>';
	$message = $message . '<tbody>';
	foreach( $order-> get_items() as $item_key => $item_values ):
	$message = $message . '<tr class="order_item">';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word; color: #737373; padding: 12px">';
	$message = $message . $item_values->get_name();
	$message = $message . '</td>';
					
	$item_data = $item_values->get_data(); 
	$product = new WC_Product($item_data['product_id']);
					
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['quantity'];			
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . round($item_data['total']/$item_data['quantity'],2);
	$message = $message . '</td>';
	$message = $message . '<td class="td" style="text-align: left; vertical-align: middle; border: 1px solid #eee; color: #737373; padding: 12px">';
	$message = $message . $item_data['total'];	
	$message = $message . '</td>';
	$message = $message . '</tr>';
	endforeach;
	$message = $message . '</tbody>';
	$message = $message . '</table>';
	$headers = 'From: РосПродТорг <postmaster@rosprod.nichost.ru>' . "\r\n";
	$attachments = '';
	$return  = wp_mail( $to, $subject, $message, $headers, $attachments );
}

//<--КК
//в плитке выводим количество в упаковке
add_action( 'woocommerce_shop_loop_item_title', 'kk_plitka_writeln_price'); 
function kk_plitka_writeln_price( ) {
	echo '<span style="display: block;height: 30px;"></span>';
}

//ускоряем работу пресса
/** Disable Ajax Call from WooCommerce */
add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_cart_fragments', 11); 
function dequeue_woocommerce_cart_fragments() { 
	//if (is_front_page()) 
	wp_dequeue_script('wc-cart-fragments'); 
}
add_action( 'init', 'my_deregister_heartbeat', 1 ); 
function my_deregister_heartbeat() { 
	global $pagenow; 
	if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow ) wp_deregister_script('heartbeat'); 
} 
/** Disable All WooCommerce  Styles and Scripts Except Shop Pages*/
add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 99 );
function dequeue_woocommerce_styles_scripts() {
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
		# Styles
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'woocommerce_frontend_styles' );
		wp_dequeue_style( 'woocommerce_fancybox_styles' );
		wp_dequeue_style( 'woocommerce_chosen_styles' );
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		# Scripts
		wp_dequeue_script( 'wc_price_slider' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-add-to-cart' );
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'wc-checkout' );
		wp_dequeue_script( 'wc-add-to-cart-variation' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-cart' );
		wp_dequeue_script( 'wc-chosen' );
		wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
		wp_dequeue_script( 'jquery-blockui' );
		wp_dequeue_script( 'jquery-placeholder' );
		wp_dequeue_script( 'fancybox' );
		wp_dequeue_script( 'jqueryui' );
		}
	}
}
?>