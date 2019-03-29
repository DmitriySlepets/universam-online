<?php  
if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html'){
?>
	<meta name="Description" content="Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком.">
	<meta name="keywords" content="универсам-онлайн, универсам-онлайн.рф, семья, розница">
<?php
}else if(strpos($_SERVER['REQUEST_URI'], "registration")!=false){
	if(!isset($_GET['refer']) && !isset($_GET['guid'])){
		?>
		<meta name="Description" content="Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком.">
		<meta name="keywords" content="универсам-онлайн, универсам-онлайн.рф, семья, розница">
		<!-- fb -->
		<meta property="og:image" content="http://universam-online.ru/images/logo.png">
		<meta property="og:description" content="Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком."/>
		<meta property="og:image:height" content="200">
		<!-- fb -->
	<?php			
	}else if(isset($_GET['guid'])){
	?>
		<meta name="Description" content="Получайте 10% кэш-бэк от своих покупок.5% от покупок ваших подписчиков.Оплачивайте ими свои заказы или выводите на карту.Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком.">
		<meta name="keywords" content="универсам-онлайн, универсам-онлайн.рф, семья, розница">
		<!-- fb -->
		<meta property="og:image" content="http://universam-online.ru/images/logo.png">
		<meta property="og:description"  content="Получайте 10% кэш-бэк от своих покупок.5% от покупок ваших подписчиков.Оплачивайте ими свои заказы или выводите на карту.Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком."/>
		<meta property="og:image:height" content="200">
		<!-- fb -->
	<?php				
	}else{
	?>
		<meta name="Description" content="Получайте 10% кэш-бэк от своих покупок.5% от покупок ваших подписчиков.Оплачивайте ими свои заказы или выводите на карту.Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком.">
		<meta name="keywords" content="универсам-онлайн, универсам-онлайн.рф, семья, розница">
		<!-- fb -->
		<meta property="og:image" content="http://universam-online.ru/images/logo.png">
		<meta property="og:description"  content="Получайте 10% кэш-бэк от своих покупок.5% от покупок ваших подписчиков.Оплачивайте ими свои заказы или выводите на карту.Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком."/>
		<meta property="og:image:height" content="200">
		<!-- fb -->
	<?php		
	}
}else if(strpos($_SERVER['REQUEST_URI'], "rich-href")!=false) {
    if (isset($_GET['guid'])) {
        if (!empty($_GET['guid'])) {
            // подключимся к базе данных
            $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
            mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
            mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
            //ищем по гуиду
            $guid = $_GET['guid'];
            $query_search_guid = "SELECT * FROM kk_href WHERE guid = '$guid'";
            $res_search_guid = mysqli_query($server_bd, $query_search_guid) or die(mysqli_error($server_bd));
            if (mysqli_num_rows($res_search_guid) != 0) {
                $row_search_guid = mysqli_fetch_row($res_search_guid);
                $sum = $row_search_guid[1];
                ?>
                <meta name="Description" content="Получить <?php echo $sum; ?> рублей на свой счет.">
                <meta name="keywords" content="универсам-онлайн, универсам-онлайн.рф, семья, розница">
                <!-- fb -->
                <meta property="og:image" content="http://universam-online.ru/images/logo.png">
                <meta property="og:description" content="Получить <?php echo $sum; ?> рублей на свой счет"/>
                <meta property="og:image:height" content="200">
                <!-- fb -->
                <?php
            }//if(mysqli_num_rows($res_search_guid)!=0)
            //БД-закрытие соединения
            mysqli_close($server_bd);
        }//if(!empty($_GET['guid']))
    }//if(isset($_GET['guid']))
}else if(Util::itsDirect()){
    ?>
    <meta name="Description" content="Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком.">
    <meta name="keywords" content="универсам-онлайн, универсам-онлайн.рф, семья, розница">
    <?php
}else{
	$kk_tek_url =  $_SERVER['REQUEST_URI'] ;
	if(strpos($kk_tek_url , "product")!=false) {
?>
		<!-- fb -->
		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );?>
		<meta property="og:image" content="<?php echo $image[0]; ?>">
		<?php $tek_product = wc_get_product(get_the_ID()); ?>
		<meta property="og:description" content="<?php echo 'Цена: ' . $tek_product->price . ' руб.'; ?> универсам-онлайн.рф"/>
		<!-- fb -->
<?php
		$meta_have_category = false;
		$meta_categ = $tek_product->get_categories();
		$meta_pos1   = strrpos($meta_categ, "tag");
		if($meta_pos1!=false){
			$meta_rest1 = substr($meta_categ, $meta_pos1+5); 
			$meta_pos2  = strrpos($meta_rest1, "<");
			if($meta_pos2!=false){
				$meta_rest2 = substr($meta_rest1,0, $meta_pos2);
				$meta_have_category = true;
			}
		}//if($meta_pos!=false)
		$keywords = "$tek_product->name"; 
		if($meta_have_category==true){
			$keywords = $keywords . ', ' . $meta_rest2;
		}//if($meta_have_category==true)
		$keywords = $keywords . ", универсам-онлайн, универсам-онлайн.рф, семья, розница";
	?>
		<meta name="Description" content="Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком.<?php if($meta_have_category==true) echo '| Категория - ' . $meta_rest2 . '| Товар - ' . $tek_product->name; ?> ">
		<meta name="keywords" content="<?php echo $keywords;?>">
	<?php

	} else {
	?>
		<meta name="Description" content="Дешевый благотворительный интернет-магазин товаров повседневного спроса с кэш-бэком.">
		<meta name="keywords" content="универсам-онлайн, универсам-онлайн.рф, семья, розница">
	<?php
	}
}//if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html')
?>