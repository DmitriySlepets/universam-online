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

    <div class="header-main">
        <div class="wrapper header-main-slider">
            <div class="mobile-slider">
                <img src="/wp-content/themes/storefront/images/mobile/banner_mobile.png" />
            </div>
        </div>
        <div class="content">
            <div id="search_main">
                <?php echo do_shortcode("[devisesearchmobile]"); ?>
            </div>
            <div class="entry-points entry-points_blocks-four">
                <a href="/magazin/" class="entry-point-item">
                    <div class="image">
                        <div class="container">
                            <img src="/wp-content/themes/storefront/images/mobile/catalog_2.png" class="img img">
                        </div>
                    </div>
                    <div class="name">Каталог</div>
                </a>
                <a href="#" class="entry-point-item">
                    <div class="image">
                        <div class="container">
                            <img src="/wp-content/themes/storefront/images/mobile/premium_1.png" class="img img">
                        </div>
                    </div>
                    <div class="name">Популярное</div>
                </a>
                <a href="#" class="entry-point-item">
                    <div class="image">
                        <div class="container">
                            <img src="/wp-content/themes/storefront/images/mobile/shop_in_shop.png" class="img img">
                        </div>
                    </div>
                    <div class="name">Акции</div>
                </a>
                <a href="/kontakty/" class="entry-point-item">
                    <div class="image">
                        <div class="container">
                            <img src="/wp-content/themes/storefront/images/mobile/sales_2.png" class="img img">
                        </div>
                    </div>
                    <div class="name">Магазины</div>
                </a>

            </div>
        </div>
    </div>

    <div class="products-collection sticky-middle-place">
        <div class="card">
            <a href="#" class="header">
                <div class="banner"></div>
                <div class="info"></div>
            </a>
            <div class="products">
                <a href="#" class="product">
                    <div class="image"></div>
                    <div class="price-block"></div>
                </a>
                <a href="#" class="product">
                    <div class="image"></div>
                    <div class="price-block"></div>
                </a>
                <a href="#" class="product">
                    <div class="image"></div>
                    <div class="price-block"></div>
                </a>
                <a href="#" class="product">
                    <div class="image"></div>
                    <div class="price-block"></div>
                </a>
            </div>
        </div>
    </div>

    <?php
    /**
     * Functions hooked in to storefront_before_content
     *
     * @hooked storefront_header_widget_region - 10
     */
    do_action( 'storefront_before_content' ); ?>

    <div id="content" class="site-content" tabindex="-1">
        <div class="col-full">
            <?php
            /**
             * Functions hooked in to storefront_content_top
             *
             * @hooked woocommerce_breadcrumb - 10
             */
            ?>
            <div class="breadcrumbs-top" style="display: block;"><?php do_action( 'storefront_content_top' ); ?></div>