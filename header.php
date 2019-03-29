<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta name="yandex-verification" content="046c82b6b167464d" />


<!-- seo -->
<meta name="yandex-verification" content="8601216da96b377b" />
<?php
	require_once(WP_CONTENT_DIR . 'themes/storefront/seo/seo.php');
?>
<!-- seo -->

<!-- print -->
<style media='print' type='text/css'>
	.storefront-primary-navigation{border: 1px solid black;padding: 10px;}
	#site-navigation .textwidget {display: inherit !important;width: 100% !important;margin-top: 5px !important;margin-bottom: 5px !important;text-align: center !important;}
	#site-navigation .textwidget a {color: #0066bf !important;font-size: 20px !important;}
	#site-navigation .textwidget a span {color: red !important;display: block !important;}
	.dgwt-wcas-search-submit {display: none;}
	#site-navigation .menu-toggle{display: none;}
	#rt-footer-surround{display: none;}
	.xoo-wsc-modal{display: none;}
	.site-main ul.products li.product {width: 14.4%;float: left !important;margin-right: 1%;}
	ul.products li.product.first {clear: both!important;}
</style>
<!-- print -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="http://allfont.ru/allfont.css?fonts=comic-sans-ms" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Everslider CSS and JS files -->
<link rel="stylesheet" type="text/css" href="/slider/evslider.css">
<script type="text/javascript" src="/slider/jquery.everslider.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#fullwidth_slider1').everslider({mode: 'carousel', moveSlides: 1, slideEasing: 'easeInOutCubic', slideDuration: 700, navigation: true, keyboard: true, nextNav: '<span class="alt-arrow">Next</span>', prevNav: '<span class="alt-arrow">Next</span>', ticker: true, tickerAutoStart: true, tickerHover: true, tickerTimeout: 6000});
		$('#fullwidth_slider2').everslider({mode: 'carousel', moveSlides: 1, slideEasing: 'easeInOutCubic', slideDuration: 700, navigation: true, keyboard: true, nextNav: '<span class="alt-arrow">Next</span>', prevNav: '<span class="alt-arrow">Next</span>', ticker: true, tickerAutoStart: true, tickerHover: true, tickerTimeout: 6000});
		$('#fullwidth_slider3').everslider({mode: 'carousel', moveSlides: 1, slideEasing: 'easeInOutCubic', slideDuration: 700, navigation: true, keyboard: true, nextNav: '<span class="alt-arrow">Next</span>', prevNav: '<span class="alt-arrow">Next</span>', ticker: true, tickerAutoStart: true, tickerHover: true, tickerTimeout: 6000});
		$('#fullwidth_slider4').everslider({mode: 'carousel', moveSlides: 1, slideEasing: 'easeInOutCubic', slideDuration: 700, navigation: true, keyboard: true, nextNav: '<span class="alt-arrow">Next</span>', prevNav: '<span class="alt-arrow">Next</span>', ticker: true, tickerAutoStart: true, tickerHover: true, tickerTimeout: 6000});
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$( function() {
		$( "#tabs_score" ).tabs();
		$( "#tabs" ).tabs();
		$( "#order_speed" ).accordion();
	} );
</script>
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<?php wp_head(); ?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-2521513377576679",
            enable_page_level_ads: true
        });
    </script>
    <script type="text/javascript" async src="https://scripts.witstroom.com/check/231"></script>
	<meta name="yandex-verification" content="2669e8c2cd6a4531" />
	<meta name="verify-admitad" content="bd71357b09" />
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(53038231, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/53038231" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body <?php body_class(); ?>>
<?php get_template_part( 'header', 'login' ); ?>
<?php require_once(WP_CONTENT_DIR . 'themes/storefront/controller/controller_header.php'); ?>
<div id="page" class="hfeed site">
	<? //кк--> ?>
	<div class="back-dialog" id="dialog" style="display: none;">
		<div class="dialog-content">
			<div class="dialog-title">
				<span>Внимание!!!</span>
				<a class='close-dialog' href='javascript: $("#dialog").fadeOut();'></a>
			</div>
			Данные раздел доступен лицам, достигшим 18 лет! Вам есть 18 лет?
			<a href='javascript: $("#dialog").fadeOut();'>Да</a>
			<a href='javascript: location.href = "http://universam-online.ru"; '>Нет</a>
		</div>
	</div>
	<? //<--кк ?>
	<?php
	do_action( 'storefront_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
		<div class="col-full">
			<!--decktop header start-->
			<img id="logo_click" src="http://universam-online.ru/images/logo.png" style="height: 104px;position: absolute;z-index: 100;cursor:pointer;"/>
			<!--fast href start-->
			<!--<a class="kk_header_left1" href="/usloviya-zakaza/" style="color: #1e73be;position: absolute;left: 184px;top: 5px;z-index: 100;">Условия</a>
			<a class="kk_header_left2" href="/kontakty/"       style="color: #1e73be;position: absolute;left: 270px;top: 5px;z-index: 100;">Контакты</a>
			<a class="kk_header_left3" href="/not_paid/"       style="color: #1e73be;position: absolute;left: 360px;top: 5px;z-index: 100;">Экономия 100%</a>-->
			<!--fast href end-->
			<?php
			if (!$user_ID):?> 
				<div id="right_header_href" style="z-index: 100;position: absolute;right: 60px;">
					<a href="/my_account/"><strong class="kk_right">Личный кабинет</strong></a>
					<div style="display: block;margin-top: 5px;margin-left: 15px;">
						<a href="https://www.facebook.com/366707910507832"><img style="float: left; margin-right: 10px;" src="/images/icons/fb.png" width="20" height="20"></a>
						<a href="https://vk.com/universamonline"><img style="float: left; margin-right: 10px;" src="/images/icons/vk.png" width="20" height="20"></a>
						<a href="https://ok.ru/universamonline?st._aid=ExternalGroupWidget_OpenGroup"><img style="" src="/images/icons/ok.png" width="20" height="20"></a>
					</div>
				</div>
			<?php
			else:
			?>
				<div id="right_header_href" style="z-index: 100;position: absolute;right: 60px;">
					<div style="display:inline-block;vertical-align:top;margin-right: 20px;">
						<a style="margin-bottom: 5px;display: block;margin-top: 5px;" href="https://www.facebook.com/366707910507832"><img src="/images/icons/fb.png" width="20" height="20"></a>
						<a style="margin-bottom: 5px;display: block;" href="https://vk.com/universamonline"><img src="/images/icons/vk.png" width="20" height="20"></a>
						<a href="https://ok.ru/universamonline?st._aid=ExternalGroupWidget_OpenGroup"><img src="/images/icons/ok.png" width="20" height="20"></a>
					</div>
					<div style="display:inline-block;vertical-align:top;">
						<a href="/my_account/information/" class="kk_href_lk0">Счет: <?php echo $amount_score; ?> руб.</a></br>
						<a href="/my_account/information/" class="kk_href_lk0">Кошелек: <?php echo $amount_purse; ?> руб.</a></br>
						<a href="/my_account/information/" class="kk_href_lk"><?php _e(' '); ?><strong class="kk_right"><?php echo $current_user->display_name; ?></strong></a>
					</div>
				</div>
			<?php
			endif;
			?>
			<!--decktop header end-->
			
			<!--new menu start-->
			<?php
				require_once(WP_CONTENT_DIR . 'themes/storefront/menu/menu.php');
  			?>
			<!--new menu end-->			
			
			<!--text slider start-->
			<?php //if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html'){ ?>
			<div class="kk_mobile_text_main_slider">
			<?php //} ?>
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Вместо текстового баннера -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:234px;height:60px"
                     data-ad-client="ca-pub-2521513377576679"
                     data-ad-slot="8984014671"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
				<?php //echo do_shortcode( '[text-slider]' ); ?>
			<?php //if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html'){ ?>
			</div>
			<?php //} ?>
			<!--text slider end-->
				
			<!--mobile header start-->
			<div class="kk_mobile_search"><a href="/search/"><img src="/images/mobile/lupa.png" /></a></div>
			<?php
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
				
				if($total_true>=1000){
					$total_true_new = intval($total_true/1000);
					$total_true_string = $total_true_new . 'К';
				}else{
					$total_true_string = $total_true;
				}
			}			
			?>
			<div class="kk_mobile_basket"><a href="/zakaz/"><img src="/images/mobile/basket.png" /><?php echo $total_true_string . ' р.'; ?></a></div>
			<?php
			if (!$user_ID){}else{?> 
			<div class="kk_mobile_schet">
				<a href="/my_account/information/" data-tooltip="Счет / Кошелек"><img src="/images/mobile/money.png" /><?php echo $m_amount_score; ?> / <?php echo $m_amount_purse; ?></a>			
			</div>
			<?php } ?>
			<!--mobile header end-->
			
			<?php
			if (!dynamic_sidebar("header-widget-area") ) : ?>
			<!-- Код который будет выводиться если в вашей области не добавлено --> 
			<!-- ни одного виджета -->
			<?php endif; ?>
			
			
		</div>
	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 */
	do_action( 'storefront_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">
		<!--text-slider start-->
		<?php //if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html'){ ?>
		<div class="kk_mobile_text_slider">
		</div>
		<?php //} ?>
		<!--text-slider end-->
		<?php
		/**
		 * Functions hooked in to storefront_content_top
		 *
		 * @hooked woocommerce_breadcrumb - 10
		 */
		?>
		<div class="breadcrumbs-top" style="display: block;"><?php do_action( 'storefront_content_top' ); ?></div>
