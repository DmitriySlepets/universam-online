$(document).ready(function(){
  //лупа для картинок
  var native_width = 0;
  var native_height = 0;
  var mouse = {x: 0, y: 0};
  var magnify;
  var cur_img;

  var ui = {
    magniflier: $('.wp-post-image')
  };

  // Добавляем в DOM увеличительное стекло
  if (ui.magniflier.length) {
    var div = document.createElement('div');
    div.setAttribute('class', 'glass');
    ui.glass = $(div);

    $('body').append(div);
  }

  // Определяем положение курсора
  var mouseMove = function(e) {

    // Получаем отступы до края картинки слева и сверху
    var magnify_offset = cur_img.offset();
	
    // Позиция курсора над изображением
    // pageX/pageY - это значения по х и у положения курсора от краев браузера
    mouse.x = e.pageX - magnify_offset.left;
    mouse.y = e.pageY - magnify_offset.top;
 
    // Увеличительное стекло должно отображаться только когда указатель мыши находится над картинкой
    // При отводе курсора от картинки происходит плавное затухание лупы
    // Поэтому необходимо проверить, не выходит ли за границы картинки положение курсора
    if (
      mouse.x < cur_img.width() &&
      mouse.y < cur_img.height() &&
      mouse.x > 0 &&
      mouse.y > 0
      ) {
      // Если условие истинно переходим дальше
      magnify(e);
    }
    else {
	  // иначе скрываем
      ui.glass.fadeOut(100);
    }

    return;
  };

  var magnify = function(e) {

    // Основное изображение будет в качестве фона в блоке div glass
    // поэтому необходимо рассчитать положение фона в этом блоке 
	// относительно положения курсора над картинкой
    //
    // Таким образом мы рассчитываем положение фона
    // и заносим полученные данные в переменную
	// которая будет использоваться в качестве значения
	// свойства background-position

    var rx = Math.round(mouse.x/cur_img.width()*native_width - ui.glass.width()/2)*-1;
    var ry = Math.round(mouse.y/cur_img.height()*native_height - ui.glass.height()/2)*-1;
    var bg_pos = rx + "px " + ry + "px";
   
    // Теперь определим положение самого увеличительного стекла
    // т.е. блока div glass
    // логика простая: половину ширины/высоты лупы вычитаем из 
	// положения курсора на странице

    var glass_left = e.pageX - ui.glass.width() / 2;
    var glass_top  = e.pageY - ui.glass.height() / 2;

    // Теперь присваиваем полученные значения css свойствам лупы
    ui.glass.css({
      left: glass_left,
      top: glass_top,
      backgroundPosition: bg_pos
    });

    return;
  };

  // Движение курсора над изображению
  $(ui.magniflier).on('mousemove', function() {
    // Плавное появление лупы
	ui.glass.fadeIn(100);
    // Текущее изображение
    cur_img = $(this);
    // определяем путь до картинки
    var src = cur_img.attr('src');
	// Если существует src, устанавливаем фон для лупы 
    if (src) {
      ui.glass.css({
        'background-image': 'url(' + src + ')',
        'background-repeat': 'no-repeat'
      });
    }

    // Проверяем есть ли запись о первоначальном размере картинки native_width/native_height
    // если нет, значит вычисляем и создаем об этом запись для каждой картинки
    // иначе показываем лупу с увеличенной областью

      if (!cur_img.data('native_width')) {
		 
        // Создаем новый объект изображение, с актуальной идентичный актуальному изображению
        // Это сделано для того чтобы получить реальные размеры изображения 
        // сделать напрямую мы этого не может, так как в атрибуте width указано др значение
		
        var image_object = new Image();

        image_object.onload = function() {
			
          // эта функция выполнится только тогда после успешной загрузки изображения
          // а до тех пор пока загружается native_width/native_height равны 0
		  
		  // определяем реальные размеры картинки
          native_width = image_object.width;
          native_height = image_object.height;

		  // Записываем эти данные
          cur_img.data('native_width', native_width);
          cur_img.data('native_height', native_height);
		  
		  // Вызываем функцию mouseMove и происходит показ лупы 
		  mouseMove.apply(this, arguments);
          ui.glass.on('mousemove', mouseMove);
		
        };

        image_object.src = src;
		
      return;
      } else {
		// получаем реальные размеры изображения  
        native_width = cur_img.data('native_width');
        native_height = cur_img.data('native_height');
      }

    // Вызываем функцию mouseMove и происходит показ лупы
    mouseMove.apply(this, arguments);
    ui.glass.on('mousemove', mouseMove);
  });  
});

$(document).ready(function(){
	$("#logo_click").click(function(){
		window.location.href="http://universam-online.ru";
	});
	
	//кликер по очистке поиска
	$('.dgwt-wcas-sf-wrapp').append('<div class="kk_clear_search" style="display: block !important;width: 20px;height: 20px;color: #000;position: absolute;top: 1px;right: 10px;z-index: 100;cursor: pointer;">X</div>');
	$(".kk_clear_search").click(function(){
		//$("#dgwt-wcas-search").val("");
		setTimeout(function(){
			$("#dgwt-wcas-search").val("");
			$(".kk_vis").attr("style","display:none;");
		},500);
		
	});

 	/*$(".dropdown_product_cat option" ).each(function() {
    	$(this).removeAttr('selected');
    });*/

	//Проверка на Пиво
	var url = window.location.href;
	if(url.indexOf('%d0%bd%d0%b0%d0%bf%d0%b8%d1%82%d0%ba%d0%b8/%d0%bf%d0%b8%d0%b2%d0%be')>-1) {
		$("#dialog").fadeIn(); //плавное появление блока
	}
	//автопересчет в корзине
	var url = window.location.href;
	if(url.indexOf('basket')>-1) {
		$("#content").on('change', '.input-text', function() { 
			$(".actions .button").click();
		});
	}

	//фиксация шляпы
	//if($(window).width()>1330){
		$nav = $("#masthead");
		$window = $(window);
		// Определяем координаты верха блока навигации
		$h = $nav.offset().top + $nav.height();
		$window.scroll(function(){
			// Если прокрутили скролл ниже макушки блока, включаем фиксацию
			if ( $window.scrollTop() > $h) {
				$nav.addClass("fixed").parent().children("#content").attr("style","margin-top:" + $nav.height() + "px;");
			}else{
				//Иначе возвращаем всё назад
				$nav.removeClass("fixed").parent().children("#content").removeAttr("style");
			}
		});
	//}//if($(window).width()>1330)
	
	//редирект после аутентификации
	if(url=="http://universam-online.ru/my_account/"){
		window.location.href = "http://universam-online.ru/my_account/information/";
	}
});

function fixed_left_bar(){
	/*if($('#masthead').hasClass('fixed')){
			//проверим на залезание на футер
			var top_footer = $('footer').offset().top;
			var left_position = $('#secondary').offset().top;
			var top_body   = $('#secondary').offset().top + $('#secondary').height();
			var scroll_top = $(document).scrollTop()+ $('#secondary').height()+150;
			if(top_body>top_footer){
				$('#secondary').removeAttr('style');	
				$('#secondary').attr('style','position:absolute !important;top:' + (top_footer-$('#secondary').height()) + 'px;');		
			}else{
				if(scroll_top<top_footer){
					$('#secondary').removeAttr('style');
					$('#secondary').attr('style','position:fixed !important;');	
				}			
			}
	}else{
		$('#secondary').removeAttr('style');
	}*/
}
function screenHeight(){
    return window.pageYOffset || document.documentElement.scrollTop;
}
function getViewportSize(doc) {
    doc = doc || document;
    var elem  = doc.compatMode == 'CSS1Compat' ? doc.documentElement : doc.body;
    return [elem.clientWidth, elem.clientHeight];
}
//страница заказа
$(document).ready(function(){
	var url = window.location.href;
	if(url.indexOf('zakaz')>-1 && url.indexOf('order-received')==-1 && url.indexOf('order-pay')==-1) {
		//заставим зарегиться
		$('.woocommerce-form__input.woocommerce-form__input-checkbox.input-checkbox').each(function(i,elem) {
			var parent_inp = $(this).parent();
			var child_span = parent_inp.children("span");
			if(child_span.html()=='Зарегистрировать вас?'){
				child_span.click();
				$('.form-row.form-row-wide.create-account.woocommerce-validated').css("display","none");
			}
		});
		//почистим дату отгрузки-спустя пол часа
		setInterval(function(){$("#e_deliverydate").val("");},1000*1600);
		//автозаполнение полей
		$("#billing_phone").keyup(function () {
			var value = $(this).val();
			$("#billing_phone_cont").val(value);
		}).keyup();
		
		$("#billing_phone").change(function() {
			var value = $(this).val();
			$("#billing_phone_cont").val(value);
		});
	
		$("#billing_email").keyup(function () {
			var value = $(this).val();
			$("#billing_email_cont").val(value);
		}).keyup();		

		$("#billing_email").change(function() {
			var value = $(this).val();
			$("#billing_email_cont").val(value);
		});		

		
		//стили заголовка
		$('#billing_name1').attr('style', 'display: none !important;');	
		$('#billing_name2').attr('style', 'display: none !important;');	
		$('#billing_name1_field').attr('style', 'width: 100% !important; text-align:center; font-size: 18px;');
		$('#billing_name2_field').attr('style', 'width: 100% !important; text-align:center; font-size: 18px;');
		//выберем значение плашки 
		if(url.indexOf('?type=ur_lizo')>-1) {
			$("select#fiz_ur").val('option_2');
		}else{
			$("select#fiz_ur").val('option_1');
		}
		$("#fiz_ur" ).change(function(){	
			switch ($("select#fiz_ur").val()){
				case 'option_1':
					if(url.indexOf('?type=ur_lizo')>-1) {
						window.location.href = "http://universam-online.ru/zakaz/";
					}else{
					}	
					break;
				case 'option_2':			
					if(url.indexOf('?type=ur_lizo')>-1) {
					}else{
						window.location.href = url  + '?type=ur_lizo';
					}		
					break;
			} 
		});   
	}
	
	$(".kk_prod_detail .kk_status1 button").click(function(){
		setTimeout(function() {
			$.ajax({  
				url: "/kk_na_utochnenii.php",  
				cache: false,  
				success: function(html){  
					$(".kk_pod_zakaz").html(html);  
				}  
			});
			$.ajax({  
				url: "/kk_podzakaz.php",  
				cache: false,  
				success: function(html){  
					$(".kk_pod_zakaz2").html(html);  
				}  
			});
		}, 1200);
	});
});    
//подсказки
$(function(){
	$("[data-tooltip]").mousemove(function (eventObject) {
		$data_tooltip = $(this).attr("data-tooltip");
		$("#tooltip").text($data_tooltip)
			.css({ 
				"top" : eventObject.pageY + 5,
				"left" : eventObject.pageX - 200
			})
			.show();
	}).mouseout(function () {
		$("#tooltip").hide()
			.text("")
			.css({
				"top" : 0,
				"left" : 0
		});
	});
});
$(document).ready(function(){
	
	//аякс пересчет корзины под заказ
		setInterval(function() {
			$.ajax({  
				url: "/kk_script/add_basket_na_utochnenii.php",  
				cache: false,  
				success: function(html){  
					$(".kk_pod_zakaz").html(html);  
				}  
			});
		}, 3100);
		setInterval(function() {
			$.ajax({  
				url: "/kk_script/add_basket_podzakaz.php",  
				cache: false,  
				success: function(html){  
					$(".kk_pod_zakaz2").html(html);  
				}  
			});
		}, 3200);
		setInterval(function() {
			$.ajax({  
				url: "/kk_script/add_basket_mobile.php",  
				cache: false,  
				success: function(html){  
					$(".kk_mobile_basket a").html(html);  
				}  
			});
		}, 2500);
	
	
	//открытие корзины
	$(".xoo-wsc-basket").click(function(){
		if($(".xoo-wsc-modal").hasClass("xoo-wsc-active")){
			$(".xoo-wsc-modal").removeClass("xoo-wsc-active");
		}else{
			$(".xoo-wsc-modal").addClass("xoo-wsc-active");
		}
	});
	$(".xoo-wsc-basket1").click(function(){
		if($(".xoo-wsc-modal").hasClass("xoo-wsc-active")){
			$(".xoo-wsc-modal").removeClass("xoo-wsc-active");
		}else{
			$(".xoo-wsc-modal").addClass("xoo-wsc-active");
		}
	});
	$(".xoo-wsc-basket2").click(function(){
		if($(".xoo-wsc-modal").hasClass("xoo-wsc-active")){
			$(".xoo-wsc-modal").removeClass("xoo-wsc-active");
		}else{
			$(".xoo-wsc-modal").addClass("xoo-wsc-active");
		}
	});

});
//увеличиваем/уменьшаем количество для витрины магазина
function func_plus_basket(elem){
	var tek_el = elem.parent().children('.qty_menu').children();
	tek_el.focus();
	var result = +tek_el.val()+1;
	tek_el.val(result);
	elem.parent().parent().children('.in_bascet').children('.cart').children('.quantity').children().val(result);	
}
function func_minus_basket(elem){
	var tek_el = elem.parent().children('.qty_menu').children();
	tek_el.focus();
	var result = +tek_el.val()-1;
	if (result>=1){
		tek_el.val(result);
	}
	elem.parent().parent().children('.in_bascet').children('.cart').children('.quantity').children().val(result);
}
