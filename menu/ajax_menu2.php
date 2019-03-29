<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	$sub_category_term_id   = (int)$_POST['cat_id_new'];
	$sub_category_term_page = (int)$_POST['cat_page'];
?>
<?php	
	$pr_cat = kk_get_products_by_category($sub_category_term_id,$sub_category_term_page);
	foreach($pr_cat as $pr_item){
		$tek_product = wc_get_product($pr_item['id']);				
		$kk_price_product = $tek_product->price . ' руб.';
		$image_src = wp_get_attachment_url($tek_product->image_id);
		echo '<div class="kk_prod_menu">';
			echo '<div style="width: 40px;display: inline-block;vertical-align: middle;margin:0 auto; margin-left:10px; text-align:center;">';
				if($tek_product->image_id==""){
					echo '<img src="/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="'.$pr_item['name'].'" style="height:25px;" />';								
				}else{
					echo '<img src="'.$image_src.'" alt="'.$pr_item['name'].'" style="height:25px;" />';
				}	
			echo '</div>';
			$string_hits = ($pr_item['hits']==1)?'<span style="color:red;">ХИТ</span>':'';
			$string_new  = ($pr_item['new']==1)?'<span style="color:red;">НОВИНКА</span>':'';
			echo '<a style="display: inline-block;width: 280px;padding-left: 10px;vertical-align: middle;padding-right: 10px;" href="' . $pr_item['url'] . '">' . $pr_item['name'] . ' ' . $string_hits . $string_new . '</a>';		
			echo '<span style="color:#000; font-weight: bold;display: inline-block;width: 68px;vertical-align: middle;text-align:right;">' . $kk_price_product .  '</span>';
			//ВЫВОД ДЕТАЛИЗАЦИИ ТОВАРОВ - НАЧАЛО
			echo '<div style="display:none;" class="kk_prod_detail">';
				if($tek_product->image_id==""){
					echo '<img src="/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="'.$pr_item['name'].'" style="margin-left: 10px;width: 70px;display: block;float:left;" />';								
				}else{
					echo '<img src="'.$image_src.'" alt="'.$pr_item['name'].'" style="margin-left: 0 auto;height: 200px;display: block;margin: 0 auto;" />';
				}
				echo '<a style="display: block;width: auto;text-align:center;" href="' . $pr_item['url'] . '">' . $pr_item['name'] . '</a>';
				echo '<div style="display: block;width: 100%;vertical-align: top;padding-left: 10px;padding-right: 10px; clear: left;text-align: center;margin-top:30px;">';
					
					//echo '<p class="product woocommerce add_to_cart_inline" style="margin-top:20px;display: inline-block;">';	
						//Получим цвет кнопки - начало
						$have_pod_zakak = false;
						$kk_attributes = $tek_product->get_attributes();
						$color_tovar = "green";
						$class_basket = "kk_status1";
						foreach ( $kk_attributes as $kk_attribute ) {
							if($kk_attribute['data']['name']=="Под заказ"){
								if($kk_attribute['data']['value']=="Да") $have_pod_zakak = true;
							}
						}//foreach ( $kk_attributes as $kk_attribute ) 
						if($have_pod_zakak==true){
							$color_tovar = "red";
							$class_basket = "kk_status3";
						}else{
							$real_ost = $tek_product->stock_quantity - 1000000;
							if($real_ost<=0){
								$color_tovar = "grey";
								$class_basket = "kk_status2";
							}
						}//if($have_pod_zakak==true)						
						//Получим цвет кнопки - конец									
						
						echo '<span style="color:#000; font-weight: bold;display: inline-block;vertical-align: top;width: auto;margin-right:4px;margin-top:5px;font-size: 18px;line-height: 16px;width: 32%;">' . $kk_price_product .  '</span>';
						echo '<div class="qty_menu_main" style="display:inline-block;vertical-align: top; margin-right:4px;width: 32%;">'.
								'<div style="color:grey; border-radius: 5px 5px; display: inline-block;width: 22px;border: 1px solid #000;cursor: pointer;text-align: center;" onclick="func_minus_basket_torg_menu($(this));">-</div>'.
								'<div class="qty_menu" style="display: inline-block;text-align:center;">'.
									'<input style="height: 27px;width: 25px;text-align:center;" type="text" step="1" min="1" max="1000006" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric" disabled>'.
								'</div>'.
								'<div style="color:grey; border-radius: 5px 5px; display: inline-block;width: 22px;border: 1px solid #000;cursor: pointer;text-align: center;" onclick="func_plus_basket_torg_menu($(this));">+</div>'.
							 '</div>';
						//echo '<a style="background-color: '.$color_tovar.';color: #fff; margin-top:10px; font-size:12px;" href="/?add-to-cart='.$pr_item['id'].'&quantity=1" data-quantity="" data-product_id="'.$pr_item['id'].'" data-product_sku="'.$tek_product->sku.'" class="button menu_add_button">Добавить в корзину</a>';
						echo '<div class="in_bascet '.$class_basket.'" style="display:inline-block;vertical-align: top;width: 32%;">';
						echo '<form class="cart" method="post" enctype="multipart/form-data">';			
							echo '<div class="quantity" style="float: none !important;display: inline-block;">';
								echo '<input type="text" style="display: none;" class="input-text qty text" step="1" min="1" max="1000000" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric">';
							echo '</div>';
							echo '<input type="hidden" name="add-to-cart" value="'.$pr_item['id'].'">';	 
							echo '<button type="submit" class="single_add_to_cart_button button alt" style="margin: 0 !important; background-position: left; color: #000; padding-left: 24px;  font-size: 10px;"></button>';	 
						echo '</form>';
						echo '</div>';
					//echo '</p>';
				echo '</div>';
			echo '</div>';
			//ВЫВОД ДЕТАЛИЗАЦИИ ТОВАРОВ - КОНЕЦ
		echo '</div>'; //.kk_prod_menu
	}//foreach($pr_cat as $pr_item)
	//кнопка показать еще
?>
<?php
	function kk_get_products_by_category($id_category,$number_page){
		$result_it = array();
		$result_pr = array();
		if($id_category=="1234"){

		}else{
			$args = array(
				'post_type'             => 'product',
				'post_status'           => 'publish',
				'ignore_sticky_posts'   => 1,
				'paged'                 => $number_page,
				'tax_query'             => array(
					array(
						'taxonomy'      => 'product_cat',
						'terms'         => $id_category,
						'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
					),
					array(
						'taxonomy'      => 'product_visibility',
						'field'         => 'slug',
						'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
						'operator'      => 'NOT IN'
					)
				)
			);
			$products_ar = new WP_Query($args);
			foreach($products_ar as $product_ar){
				if(is_array($product_ar)=='array'){	
					//if(count($product_ar)>=5){
						foreach($product_ar as $product_item){
							if($product_item->post_title!=""){
								$res_array = array();
								$res_array['name'] = $product_item->post_title;
								//$res_array['url']  = $product_item->guid;
								$res_array['url']  = get_permalink($product_item->ID);
								$res_array['id']   = $product_item->ID;
								$res_array['new']  = 0;
								$res_array['hits'] = 0;
								/*$string_hits_news  = kk_get_new_hits($product_item->post_title);
								if($string_hits_news=='НОВИНКА') $res_array['new']  = 1;
								if($string_hits_news=='ХИТ')     $res_array['hits'] = 1;*/
								$res_array['new']  = 0;
								$res_array['hits'] = 0;
								$result_pr[]       = $res_array;
							}	
						}//foreach($product_ar as $product_item)							
					//}//if(count($product_ar)==5)
				}//if(is_array($product_ar)=='array')
			}//foreach($products_ar as $product_ar)
			//отсортируем массив
			if(count($result_pr)>0){
				$temp_hits  = array();
				$temp_new   = array();
				$temp_other = array();

				foreach($result_pr as $item_pr){
					if($item_pr['hits']==1){
						$temp_hits[] = $item_pr;
					}elseif($item_pr['new']==1){
						$temp_new[] = $item_pr;
					}else{
						$temp_other[] = $item_pr;
					}//if($item_pr['new']==1)				
				} //foreach($result_pr as $item_pr)
				
				//сначала хиты
				foreach($temp_hits as $item_hits){
					$result_it[] = $item_hits;
				} //foreach($temp_hits as $item_hits)
				//потом новинки
				foreach($temp_new as $item_new){
					$result_it[] = $item_new;
				} //foreach($temp_new as $item_new)
				//далее остальные
				foreach($temp_other as $item_other){
					$result_it[] = $item_other;
				} //foreach($temp_new as $item_other)		
			}//if(count($result_pr)>0)
		}//if($id_category=="1234")


		
		return $result_it;
	}
	
	function kk_get_new_hits($name_product){
        $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
        mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
        mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
				
		$kk_type_product = "";
		$query_new  = "SELECT * FROM kk_newhits WHERE priznak=1 AND name ='$name_product'";
		$result_new = mysqli_query($server_bd,$query_new) or die(mysqli_error($server_bd)); 			
		$query_hits = "SELECT * FROM kk_newhits WHERE priznak=2 AND name ='$name_product'";
		$result_hits = mysqli_query($server_bd,$query_hits) or die(mysqli_error($server_bd));  
		
		$res_new = array();
		$res_hits = array();
		while($row_new = mysqli_fetch_assoc($result_new)){$res_new[] = $row_new;}
		while($row_hits = mysqli_fetch_assoc($result_hits)){$res_hits[] = $row_hits;}					
		foreach($res_new as $res_new_item){$kk_type_product = 'НОВИНКА';} 
		foreach($res_hits as $res_hits_item){$kk_type_product = 'ХИТ';} 
		//убрать подключение
		mysqli_close($server_bd);
		
		return $kk_type_product;
	}
?>
<script>
	/*Товары детализация-начало*/
	tek_elem_prod_item = null;
	$('.kk_prod_menu').hover(function(){
		$(".kk_prod_detail").hide();
		$(this).children(".kk_prod_detail").show();	
		var kk_left = $(this).offset().left + 160 + 7 + 250;
		var kk_top = $(this).parent().offset().top;
		if($('#masthead').hasClass('fixed')){
			//kk_top = kk_top-87;
			kk_top = 66;
		}
		//$(this).children(".kk_prod_detail").attr('style','display: block;position: fixed;background: #fff;border: 1px solid gray;left: '+kk_left+'px;top: '+kk_top+'px;text-align: left;padding-left: 20px;padding-right: 20px;padding-top: 20px;height:' + ($('.kk_par').height()+2) + 'px;');
		$(this).children(".kk_prod_detail").attr('style','display: block;position: fixed;background: #fff;border: 1px solid gray;left: '+kk_left+'px;top: '+kk_top+'px;text-align: left;padding-left: 20px;padding-right: 20px;padding-top: 20px;height:400px;');
	});	
	/*Товары детализация-конец*/
</script>