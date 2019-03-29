<?php
	$taxonomy     = 'product_cat';
	$orderby      = '';  
	$show_count   = 0;
	$pad_counts   = 0; 
	$hierarchical = 1; 
	$title        = '';  
	$empty        = 0;
	$args = array(
		'taxonomy'     => $taxonomy,
		'orderby'      => $orderby,
		'show_count'   => $show_count,
		'pad_counts'   => $pad_counts,
		'hierarchical' => $hierarchical,
		'title_li'     => $title,
		'hide_empty'   => $empty
	);
	$all_categories = get_categories( $args );
?>
<style>
/*#show {background-color: #7c7fe0;border: 0;color: #fff;padding: 10px 20px;text-transform: uppercase;cursor: pointer;outline: none;position: absolute;top: 54px;left: 40px;transform: translate(-50%, -50%);z-index:1000;display:none;}*/
#show{display:none;position: absolute;top: 12px;left: 10px;box-sizing: content-box;width: 2rem;padding: 0;padding: 18px .75rem 30px;-webkit-transition: all .6s cubic-bezier(.19,1,.22,1);transition: all .6s cubic-bezier(.19,1,.22,1);-webkit-transform: translateZ(0);transform: translateZ(0);border: 0;outline: 0;background-color: transparent;box-shadow:none;background: #1e73be;border-radius: 8px;z-index:2001;}
.sr-only {position: absolute;overflow: hidden;clip: rect(0,0,0,0);width: 1px;height: 1px;margin: -1px;padding: 0;border: 0;}
.drawer-hamburger-icon{width: 100%;height: 2px;-webkit-transition: all .6s cubic-bezier(.19,1,.22,1);transition: all .6s cubic-bezier(.19,1,.22,1);background-color: #fff;}
.drawer-hamburger-icon {position: relative;display: block;margin-top: 10px;}
.drawer-hamburger-icon:before {position: absolute;top: -10px;left: 0;content: " ";}
.drawer-hamburger-icon:before {width: 100%;height: 2px;-webkit-transition: all .6s cubic-bezier(.19,1,.22,1);transition: all .6s cubic-bezier(.19,1,.22,1);background-color: #fff;}
.drawer-hamburger-icon:after {top: 10px;}
.drawer-hamburger-icon:after {position: absolute;left: 0;content: " ";}
.drawer-hamburger-icon:after {width: 100%;height: 2px;-webkit-transition: all .6s cubic-bezier(.19,1,.22,1);transition: all .6s cubic-bezier(.19,1,.22,1);background-color: #fff;}

.navigation {position: fixed;width: 300px;height: 100%;top: 0;overflow-y: auto;overflow-x: hidden;opacity: 0;visibility: hidden;z-index: 1000;transition-delay: 300ms;left: 0; }
.navigation.active {opacity: 1;visibility: visible;transition-delay: 0s;}
.navigation.active .navigation__inner {background-color: #f5f5f5;transform: translate(0, 0);transition: transform 300ms linear, background-color 0s linear 599ms;}
.navigation.active .navigation__inner:after {width: 300%;border-radius: 50%;animation: elastic 150ms ease 300.5ms both;}
.navigation__inner {position: absolute;width: 100%;height: 100%;top: 0;left: 0;overflow: hidden;z-index: 999999;transform: translate(-100%, 0);transition: transform 300ms linear, background-color 0s linear 300ms;}
.navigation__inner:after {content: '';position: absolute;width: 0;height: 100%;top: 0;right: 0;background-color: #f5f5f5;border-radius: 50%;z-index: -1;transition: all 300ms linear;}
@keyframes elastic {
  0% {border-radius: 50%;}
  45% {border-radius: 0;}
  65% {border-top-right-radius: 40px 50%;border-bottom-right-radius: 40px 50%;}
  80% {border-radius: 0;}
  90% {border-top-right-radius: 20px 50%;border-bottom-right-radius: 20px 50%;}
  100% {border-radius: 0;}
}

.menu_level{display:none;}
.parent_mobile_menu{list-style: none;margin-left: 20px;}
	.parent_mobile_menu ul{list-style: none;}
	.parent_mobile_menu li{height: 30px;line-height: 30px;}
	.parent_mobile_menu li a{width: 260px;display: block;max-width: 90%;}
	.parent_mobile_menu span{float: right;font-weight: bold;font-size: 30px;}
	.parent_mobile_menu .back_menu{margin-bottom:5px;padding-bottom:5px;}
	.parent_mobile_menu .back_menu a{border-bottom: 1px solid grey;border-radius: unset !important;}

	.mobile_menu_catalog_parent.invise ul{display:none;}
	.mobile_menu_catalog_parent .mobile_sub_cats{width: 244px;}
	.mobile_menu_catalog_parent .mobile_sub_cats2{width: 244px;}
</style>

<!--mobile-menu-start-->
<div id="nav" class="navigation">
  <div class="navigation__inner" style="overflow-y: auto;">
	<div class="menu_level">0</div>
	<h2 style="text-align:center;">Меню</h2>
	<div style="border-bottom:1px solid grey;width:100%;"></div>
	<?php  /* Панель входа на сайт */
  	global $user_ID,$current_user;
  	get_currentuserinfo();
  	if (!$user_ID):?> 
		<a style="display:inline-block;width: 48%;height:40px;line-height:39px;vertical-align:top;text-align:center;border-right: 1px solid grey;" href="/my_account/">Вход</a>
		<a style="display:inline-block;width: 48%;height:40px;line-height:39px;vertical-align:top;text-align:center;border-left: 1px solid grey;" href="/registration/">Регистрация</a>
	<?php
  	else:
	?>
	<?php
		//текущее состояние счета
		$server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
		mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
		mysqli_set_charset($server_bd,"utf8");

		$id_user = get_current_user_id();
		$query_select = "SELECT ID_score,Amount_score FROM kk_score_users WHERE ID_user = $id_user";
		$res_query    = mysqli_query($server_bd, $query_select) or die(mysqli_error($server_bd));
		$row_query    = mysqli_fetch_row($res_query);
		$amount_score = $row_query[1];
			
		mysqli_close($server_bd);
	?>
		<a style="display:inline-block;width:148px;height:40px;line-height:39px;vertical-align:top;text-align:center;border-right: 1px solid grey;" href="/my_account/information/">Счет: <?php echo $amount_score; ?> руб.</a>
		<a style="display:inline-block;width:148px;height:40px;line-height:39px;vertical-align:top;text-align:center;border-left: 1px solid grey;" href="/my_account/information/"><?php echo $current_user->display_name; ?></a>
	<?php
  	endif;
	?>	
	<div style="border-bottom:1px solid grey;width:100%;"></div>
	<div style="width: 100%;text-align: center;margin-top: 10px;">
		<a style="display: inline-block;width: 30px;height: 30px;" href="https://www.facebook.com/366707910507832"><img style="float: left; margin-right: 10px;" src="/images/icons/fb.png" width="30" height="30"></a>
		<a style="display: inline-block;width: 30px;height: 30px;" href="https://vk.com/universamonline"><img style="float: left; margin-right: 10px;" src="/images/icons/vk.png" width="30" height="30"></a>
		<a style="display: inline-block;width: 30px;height: 30px;" href="https://ok.ru/universamonline?st._aid=ExternalGroupWidget_OpenGroup"><img style="" src="/images/icons/ok.png" width="30" height="30"></a>
	</div>
    <ul class="parent_mobile_menu">
		<li class="back_menu" style="display:none;"><a href="javascript:void(0);">Назад<span><</span><a></li>
		<li class="other"><a href="/not_paid/">Экономия 100%</a></li>
		<li class="mobile_menu_catalog_parent invise">
			<a href="javascript:void(0);">Каталог товаров<span>></span></a>
			<ul>
			<li><a href="/sale">Распродажа</a></li>
			<?php
			foreach ($all_categories as $cat) {
				if($cat->category_parent == 0) {
					if ( is_user_logged_in() ){ 
						if($cat->name=='Услуги') continue;
						if($cat->name=='Снято') continue;
					}else{
						if($cat->name=='Услуги') continue;
						if($cat->name=='Сигареты') continue;
						if($cat->name=='Пиво') continue;
						if($cat->name=='Пиво +') continue;	
						if($cat->name=='Снято') continue;
					}//if ( is_user_logged_in() )
					echo '<li>';					
						//подкатегории-начало
						$category_id = $cat->term_id;
						$args2 = array(
								'taxonomy'     => $taxonomy,
								'child_of'     => 0,
								'parent'       => $category_id,
								'orderby'      => $orderby,
								'show_count'   => $show_count,
								'pad_counts'   => $pad_counts,
								'hierarchical' => $hierarchical,
								'title_li'     => $title,
								'hide_empty'   => $empty
						);
						$sub_cats = get_categories( $args2 );
						if($sub_cats) {	
							echo '<a class="mobile_sub_cats" href="javascript:void(0);">' . $cat->name . '<span>></span></a>';
							echo '<ul class="mobile_menu_catalog_daught" style="display:none;">';
								foreach($sub_cats as $sub_category):
									echo '<li>';									
										$category_id2 = $sub_category->term_id;
										$args3 = array(
												'taxonomy'     => $taxonomy,
												'child_of'     => 0,
												'parent'       => $category_id2,
												'orderby'      => $orderby,
												'show_count'   => $show_count,
												'pad_counts'   => $pad_counts,
												'hierarchical' => $hierarchical,
												'title_li'     => $title,
												'hide_empty'   => $empty
										);																				
										$sub_cats2 = get_categories( $args3 );
										if($sub_cats2) {
											echo '<a class="mobile_sub_cats2" href="javascript:void(0);">' . $sub_category->name . '<span>></span></a>';
											echo '<ul class="mobile_menu_catalog_daught2" style="display:none;">';
												foreach($sub_cats2 as $sub_category2):
													echo '<li>';
														echo '<a href="/shop-categoty/' . $cat->slug . '/' . $sub_category2->slug . '">' . $sub_category2->name . '</a>';
													echo '</li>';
												endforeach;
											echo '</ul>';
										}else{
											echo '<a href="/shop-categoty/' . $cat->slug . '/' . $sub_category->slug . '">' . $sub_category->name . '</a>';												
										}//if($sub_cats2)
									echo '</li>';
								endforeach;
							echo '</ul>';
						}else{
							echo '<a href="/shop-categoty/' . $cat->slug . '">' . $cat->name . '</a>';
						}//if($sub_cats)
					echo '</li>';
				}//if($cat->category_parent == 0)
			}//foreach ($all_categories as $cat)
			?>
			</ul>
		</li>
		<li class="other"><a href="/usloviya-zakaza/">Условия заказа</a></li>
		<li class="other"><a href="/sample-page/">О нас</a></li>
		<li class="other"><a href="/kontakty/">Контакты</a></li>
	</ul>
  </div>
</div>
<!--mobile-menu-end-->

<script>

$(document).ready(function(){
	$('#show').click(function(){
		if($('#nav').hasClass('active')){
			$('#nav').removeClass('active');
			$('#show').removeAttr("style");		
			$('.dgwt-wcas-search-wrapp').removeAttr("style");		
		}else{
			$('#nav').addClass('active');
			$('#show').attr("style","left:295px !important;")	
			$('.dgwt-wcas-search-wrapp').attr("style","display:none !important;");	
		}

	});
	$('.mobile_menu_catalog_parent').click(function(){
		if($('.mobile_menu_catalog_parent').hasClass('invise')){
			$('.parent_mobile_menu .other').attr('style','display:none;');
			$('.mobile_menu_catalog_parent').removeClass('invise');
			$('.back_menu').removeAttr('style');
			$('.menu_level').html("1");
		}
	});
	$('.mobile_sub_cats').click(function(){
		var thisElement  = $(this);
		var ulParentThis = thisElement.parent().parent();
		var liParentThis = thisElement.parent();
		var ulDauthThis  = liParentThis.children("ul");
		ulDauthThis.removeAttr('style');
		ulParentThis.children().each(function(index) {
			if($(this).children(".mobile_sub_cats").html()!=thisElement.html()){
				$(this).attr('style','display:none;');
			}//if($(this)!=liParentThis)
		});
		$('.menu_level').html("2");
	});
	$('.mobile_sub_cats2').click(function(){
		var thisElement  = $(this);
		var ulParentThis = thisElement.parent().parent();
		var liParentThis = thisElement.parent();
		var ulDauthThis  = liParentThis.children("ul");
		ulDauthThis.removeAttr('style');
		ulParentThis.children().each(function(index) {
			if($(this).children(".mobile_sub_cats2").html()!=thisElement.html()){
				$(this).attr('style','display:none;');
			}//if($(this)!=liParentThis)
		});
		$('.menu_level').html("3");
	});	
	$('.back_menu').click(function(){
		var thisLevel = +$('.menu_level').html();
		if(thisLevel==1){
			$('.parent_mobile_menu .other').removeAttr('style');
			$('.mobile_menu_catalog_parent').addClass('invise');
			$('.back_menu').attr('style','display:none;');
			$('.menu_level').html("0");			
		}else if(thisLevel==2){
			$('.mobile_menu_catalog_parent ul li').each(function(index) {
				$(this).removeAttr('style');
			});
			$('.mobile_menu_catalog_daught li').each(function(index) {
				$(this).attr('style','display:none;');
			});
			$('.menu_level').html("1");
		}else if(thisLevel==3){
			$('.mobile_menu_catalog_daught li').each(function(index) {
				$(this).removeAttr('style');
			});
			$('.mobile_menu_catalog_daught2').each(function(index) {
				$(this).attr('style','display:none;');
			});
			$('.menu_level').html("2");
		}//if(thisLevel>0)

	});
});
</script>

<button id="show">      
	<span class="sr-only">toggle navigation</span>
    <span class="drawer-hamburger-icon"></span>
</button>
<?php 
	echo '<div class="kk_menu_block">';
	echo '<div class="kk_menu_name">Каталог</div>';
	echo '<div class="kk_menu_cat" style="display:none;"><ul class="kk_par">';
	//выведим распродажу - начало
	echo '<li class="kk_sub_category" id="1234" style="width: auto !important;">';
	echo '<a href="/sale">Распродажа</a>';
	//ВЫВОД ТОВАРОВ - НАЧАЛО
	echo '<div style="display:none;" class="kk_prod" id="1234">';
	//ЗДЕСТ ВЫВОД АЯКС!!!
	echo '</div>';
	//ВЫВОД ТОВАРОВ - КОНЕЦ
	echo '</li>';
	//выведим распродажу - конец
	foreach ($all_categories as $cat) {
		if ( is_user_logged_in() ){ 
			if($cat->name=='Услуги') continue;
			if($cat->name=='Снято') continue;
		}else{
			if($cat->name=='Услуги') continue;
			if($cat->name=='Сигареты') continue;
			if($cat->name=='Пиво') continue;
			if($cat->name=='Пиво +') continue;	
			if($cat->name=='Снято') continue;
		}//if ( is_user_logged_in() )
		if($cat->category_parent == 0) {
			//подкатегории-начало
			$category_id = $cat->term_id;
			$args2 = array(
				'taxonomy'     => $taxonomy,
				'child_of'     => 0,
				'parent'       => $category_id,
				'orderby'      => $orderby,
				'show_count'   => $show_count,
				'pad_counts'   => $pad_counts,
				'hierarchical' => $hierarchical,
				'title_li'     => $title,
				'hide_empty'   => $empty
			);
			$sub_cats = get_categories( $args2 );
			if($sub_cats) {
				echo '<li class="kk_m_par">';
				echo '<a href="/shop-categoty/' . $cat->slug . '">' . $cat->name . '</a>';
				echo '<ul style="display:none;" class="kk_sub">';
				foreach($sub_cats as $sub_category) {
					if ( is_user_logged_in() ){ 
						if($sub_category->name=='Услуги') continue;
					}else{
						if($sub_category->name=='Услуги') continue;
						if($sub_category->name=='Сигареты') continue;
						if($sub_category->name=='Пиво') continue;
						if($sub_category->name=='Пиво +') continue;	
					}//if ( is_user_logged_in() )					
					$category_id2 = $sub_category->term_id;
					$args3 = array(
						'taxonomy'     => $taxonomy,
						'child_of'     => 0,
						'parent'       => $category_id2,
						'orderby'      => $orderby,
						'show_count'   => $show_count,
						'pad_counts'   => $pad_counts,
						'hierarchical' => $hierarchical,
						'title_li'     => $title,
						'hide_empty'   => $empty
					);			
					$sub_cats2 = get_categories($args3);
					if($sub_cats2) {

						echo '<li class="kk_last_ma_par">';
						echo '<a href="/shop-categoty/' . $cat->slug . '/' . $sub_category->slug . '">' . $sub_category->name . '</a>';
						echo '<ul style="display:none;" class="kk_sub2">';
						foreach($sub_cats2 as $sub_category2) {
							if ( is_user_logged_in() ){ 
								if($sub_category2->name=='Услуги') continue;
							}else{
								if($sub_category2->name=='Услуги') continue;
								if($sub_category2->name=='Сигареты') continue;
								if($sub_category2->name=='Пиво') continue;
								if($sub_category2->name=='Пиво +') continue;	
							}//if ( is_user_logged_in() )	
							echo '<li class="kk_sub_category_d2" id="' . $sub_category2->term_id . '">';
							echo '<a href="/shop-categoty/' . $cat->slug . '/' . $sub_category2->slug . '">' . $sub_category2->name . '</a>';
							//ВЫВОД ТОВАРОВ - НАЧАЛО
							echo '<div style="display:none;" class="kk_prod" id="' . $sub_category2->term_id . '">';
								//ЗДЕСТ ВЫВОД АЯКС!!!
							echo '</div>';
							//ВЫВОД ТОВАРОВ - КОНЕЦ
							echo '</li>';
						}	
						echo '</ul>';						
						echo '</li>';
					}else{
						echo '<li class="kk_sub_category_d" id="' . $sub_category->term_id . '">';
						echo '<a href="/shop-categoty/' . $cat->slug . '/' . $sub_category->slug . '">' . $sub_category->name . '</a>';
						//ВЫВОД ТОВАРОВ - НАЧАЛО
						echo '<div style="display:none;" class="kk_prod" id="' . $sub_category->term_id . '">';
							//ЗДЕСТ ВЫВОД АЯКС!!!
						echo '</div>';
						//ВЫВОД ТОВАРОВ - КОНЕЦ
						echo '</li>';
					}//if($sub_cats2)	
				}//foreach($sub_cats as $sub_category)
				echo '</ul>';
			}else{
				echo '<li class="kk_sub_category" id="' . $cat->term_id . '" style="width: auto !important;">';
				echo '<a href="/shop-categoty/' . $cat->slug . '">' . $cat->name . '</a>';
				//ВЫВОД ТОВАРОВ - НАЧАЛО
				echo '<div style="display:none;" class="kk_prod" id="' . $cat->term_id . '">';
					//ЗДЕСТ ВЫВОД АЯКС!!!
				echo '</div>';
				//ВЫВОД ТОВАРОВ - КОНЕЦ
				echo '</li>';
			}//if($sub_cats)
			//подкатегории-конец
			echo '</li>';
		}//if($cat->category_parent == 0) 
	}//foreach ($all_categories as $cat)
	echo '</ul></div>';
	echo '</div>';
	
?> 
<div class="first_m" style="display:none;"></div>
<div id="kk_overlay"></div>
<script>
	var query_ajax;
	
	/*категория - начало*/
	$('.kk_menu_name').hover(
        function(){
            timeout = setTimeout (function () {
                $(".kk_menu_cat").show();
                $("#kk_overlay").attr('style','display:block !important;');
            }, 500);
        },
        function(){
            clearTimeout(timeout);
        }
    );
    $('.kk_menu_name').click(
        function(){
            timeout = setTimeout (function () {
                $(".kk_menu_cat").show();
                $("#kk_overlay").attr('style','display:block !important;');
            }, 500);
        });
	/*категория - конец*/
	
	/*Основное меню-начало*/
	$('.kk_m_par').hover(	
		function(){
			tek_block = $(this);
			timeout1 = setTimeout (function () {
				$(".kk_sub").hide();
				$(".kk_prod").hide();
				$(".kk_prod_detail").hide();		
				
				var index_first = $('.kk_m_par').index(this);
				$('.first_m').html(index_first);
				
				tek_block.children(".kk_sub").show();
				tek_block.children(".kk_sub").attr("style","min-height:" + (tek_block.parent().height()+2) + "px;height:auto;");
			}, 100);
		},
		function(){
			clearTimeout(timeout1);
		}
	);
	$('.kk_last_ma_par').hover(
		function(){
			tek_block = $(this);
			timeout1 = setTimeout (function () {
				$(".kk_sub2").hide();
				$(".kk_prod").hide();
				$(".kk_prod_detail").hide();	
				
				tek_block.children(".kk_sub2").show();
				
				tek_block.children(".kk_sub2").attr("style","min-height:"+(tek_block.parent().height()+2)+"px;height:auto;");				
			}, 100);
		},
		function(){
			clearTimeout(timeout1);
		}
	);	
	/*Основное меню-конец*/

	$('#kk_overlay').hover(	
		function(){
			timeout1 = setTimeout (function () {
				$(".kk_menu_cat").hide();
				$(".kk_sub").hide();	
				$(".kk_sub2").hide();
				$(".kk_prod").hide();
				$(".kk_prod_detail").hide();
				$("#kk_overlay").removeAttr('style');		
			}, 500);
		},
		function(){
			clearTimeout(timeout1);
		}
	);
	
	/*Товары категории-начало*/
	$('.kk_sub_category').hover(
		//при наведении
		function(){	
			tek_block = $(this);
			timeout2 = setTimeout (function () {	
				$(".kk_sub").hide();
				$(".kk_sub2").hide();	
				$('#kk_wait').remove();
				
				id = tek_block.attr("id");
				
				$('.kk_prod').remove();	
				
				tek_block.append('<div style="display:none;" class="kk_prod" id="'+id+'">');

				tek_block.children(".kk_prod").show();	
				var kk_left = tek_block.offset().left + 160 + 10;
				kk_left = 198;	
				tek_block.children(".kk_prod").attr('style','display: block;position: absolute;background: #fff;border: 1px solid gray;left: '+kk_left+'px;top: -1px;text-align: left;width:420px;height:400px;');
				tek_block.children('.kk_prod').html('<p><img src="/images/kk_loading.gif" id="kk_wait" /><p><p style="text-align:center;">Загрузка...</p>');
				//получим товары аяксом		
				try {
					query_ajax.abort();
					//console.log(1);
				}
				catch(err) {
					//console.log(2);
				}
				query_ajax = $.ajax({  
					type: "POST",
					data: "cat_id=" + id,
					url: "/wp-content/themes/storefront/menu/ajax_menu1.php",
					cache: true,  
					success: function(html){ 
						//установим в текущий блок
						tek_block.children('.kk_prod').html(html);
					}  
				}); 
			}, 100);
		},
		//при уходе
		function(){
			clearTimeout(timeout2);
		}
	);
	$('.kk_sub_category_d').hover(
		//при наведении
		function(){	
			tek_block = $(this);
			timeout2 = setTimeout (function () {	
				$(".kk_sub2").hide();	
				$('#kk_wait').remove();
				
				id = tek_block.attr("id");
				
				$('.kk_prod').remove();	
				
				tek_block.append('<div style="display:none;" class="kk_prod" id="'+id+'">');

				tek_block.children(".kk_prod").show();	
				var kk_left = tek_block.offset().left + 160 + 10;
				kk_left = 198;	
				tek_block.children(".kk_prod").attr('style','display: block;position: absolute;background: #fff;border: 1px solid gray;left: '+kk_left+'px;top: -1px;text-align: left;width:420px;height:400px;');
				tek_block.children('.kk_prod').html('<p><img src="/images/kk_loading.gif" id="kk_wait" /><p><p style="text-align:center;">Загрузка...</p>');
				//получим товары аяксом		
				try {
					query_ajax.abort();
					//console.log(1);
				}
				catch(err) {
					//console.log(2);
				}
				query_ajax = $.ajax({  
					type: "POST",
					data: "cat_id=" + id,
					url: "/wp-content/themes/storefront/menu/ajax_menu1.php",
					cache: true,  
					success: function(html){ 
						//установим в текущий блок
						tek_block.children('.kk_prod').html(html);
					}  
				}); 
			}, 100);
		},
		//при уходе
		function(){
			clearTimeout(timeout2);
		}
	);	
	$('.kk_sub_category_d2').hover(
		//при наведении
		function(){	
			tek_block = $(this);
			timeout2 = setTimeout (function () {	
				$('#kk_wait').remove();
				
				id = tek_block.attr("id");
				
				$('.kk_prod').remove();	
				
				tek_block.append('<div style="display:none;" class="kk_prod" id="'+id+'">');

				tek_block.children(".kk_prod").show();	
				var kk_left = tek_block.offset().left + 160 + 10;
				kk_left = 198;	
				tek_block.children(".kk_prod").attr('style','display: block;position: absolute;background: #fff;border: 1px solid gray;left: '+kk_left+'px;top: -1px;text-align: left;width:420px;height:400px;');
				tek_block.children('.kk_prod').html('<p><img src="/images/kk_loading.gif" id="kk_wait" /><p><p style="text-align:center;">Загрузка...</p>');
				//получим товары аяксом		
				try {
					query_ajax.abort();
					//console.log(1);
				}
				catch(err) {
					//console.log(2);
				}
				query_ajax = $.ajax({  
					type: "POST",
					data: "cat_id=" + id,
					url: "/wp-content/themes/storefront/menu/ajax_menu1.php",
					cache: true,  
					success: function(html){ 
						//установим в текущий блок
						tek_block.children('.kk_prod').html(html);
					}  
				}); 
			}, 100);
		},
		//при уходе
		function(){
			clearTimeout(timeout2);
		}
	);	
	/*Товары категории-конец*/
	
</script>
<style>
/*Меню категорий - начало*/
.kk_menu_name{width: 108px;background-color: #fff;border: 1px solid #0066bf;text-align: center;height: 23px;line-height: 22px;font-weight: bold;position: absolute;top: 44px;left: 182px;z-index: 101;cursor: pointer;color: red;}
.kk_menu_cat{display: block;margin-left: 140px;margin-top: 66px;width: 200px;border-bottom: 1px solid grey;background-color: #fff;border: 1px solid grey;position:absolute;z-index:101;}
.kk_menu_cat .kk_par{text-align: center;margin: 0px;}
.kk_menu_cat .kk_par li{display:block; width: auto; margin-right: 0px;border-bottom: 1px dashed grey;padding-top: 5px !important;padding-bottom: 5px;}
.kk_menu_cat .kk_par li:last-child{border-bottom:none !important;}
.kk_menu_cat .kk_par li:hover{background-color: #a2c1dc;}
.kk_menu_cat .kk_par li a{color: grey; font-weight:normal;}
.kk_menu_cat .kk_sub{border: 1px solid grey;position: absolute;margin-left: 198px;margin-top: -1px;background-color: #fff;top: 0px;z-index:100;}
.kk_menu_cat .kk_sub2{border: 1px solid grey;position: absolute;margin-left: 198px;margin-top: -1px;background-color: #fff;top: 0px;z-index:100;}
.kk_menu_cat .kk_last_ma_par{width: 198px !important;}
.kk_menu_cat .kk_m_par{width: 198px !important;}
.kk_menu_cat .kk_sub_category{display: block !important;margin: 0;text-align: center;padding-top: 5px !important;padding-bottom: 5px;border-bottom: 1px dashed grey;width:198px !important;margin-right: 0 !important;}
.kk_menu_cat .kk_sub_category:last-child{border-bottom:none !important;}
.kk_menu_cat .kk_sub_category:hover{background-color: #a2c1dc;}
.kk_menu_cat .kk_sub_category_d{display: block !important;margin: 0;text-align: center;padding-top: 5px !important;padding-bottom: 5px;border-bottom: 1px dashed grey;width:198px !important;margin-right: 0 !important;}
.kk_menu_cat .kk_sub_category_d:last-child{border-bottom:none !important;}
.kk_menu_cat .kk_sub_category_d:hover{background-color: #a2c1dc;}
.kk_menu_cat .kk_sub_category_d2{display: block !important;margin: 0;text-align: center;padding-top: 5px !important;padding-bottom: 5px;border-bottom: 1px dashed grey;width:198px !important;margin-right: 0 !important;}
.kk_menu_cat .kk_sub_category_d2:last-child{border-bottom:none !important;}
.kk_menu_cat .kk_sub_category_d2:hover{background-color: #a2c1dc;}

.kk_menu_cat .kk_prod{overflow-y: scroll;display:block;}
.kk_menu_cat .kk_prod_menu{font-size: 14px;display: block !important;margin: 0;padding-top: 2px !important;padding-bottom: 2px;border-bottom: 1px dashed grey;width:400px !important;}
.kk_menu_cat .kk_prod_menu:last-child{border-bottom:none !important;}
.kk_menu_cat .kk_prod_menu:hover{background-color: #a2c1dc;}
.kk_menu_cat .kk_prod_detail{width:280px !important;}

#kk_ones .kk_prod{left: 198px !important;}
@media (max-width: 640px){
	.kk_menu_name{display:none;}
	.kk_menu_cat{display:none;}
}
.kk_status1 .single_add_to_cart_button.button.alt{background:none; background-image:url(/images/korzina_green.png); background-repeat:no-repeat; height:25px; background-size:contain; background-position:center;border: none;box-shadow: none;}
.kk_status2 .single_add_to_cart_button.button.alt{background:none; background-image:url(/images/korzina_grey.png); background-repeat:no-repeat; height:25px; background-size:contain; background-position:center;border: none;box-shadow: none;}
.kk_status3 .single_add_to_cart_button.button.alt{background:none; background-image:url(/images/korzina_red.png); background-repeat:no-repeat; height:25px; background-size:contain; background-position:center;border: none;box-shadow: none;}
#kk_overlay {  z-index: 100; /* подложка должна быть выше слоев элементов сайта, но ниже слоя модального окна */  position: fixed; /* всегда перекрывает весь сайт */  background-color: #000; /* черная */  opacity: 0.8; /* но немного прозрачна */  width: 100%;  height: 100%; /* размером во весь экран */  top: 0;  left: 0; /* сверху и слева 0, обязательные свойства! */  cursor: pointer;  display: none; /* в обычном состоянии её нет) */  }
/*Меню категорий - конец*/
</style>

	

	