<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1">

<?php endif; ?>

		<h2><?php _e( 'Login', 'woocommerce' ); ?></h2>

        <?php echo do_shortcode('[wordpress_social_login]'); ?>
        <p>или введите данные ниже</p>

		<form class="woocomerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input style="width: 100%; height: 40px; margin-bottom: 20px;" type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
				<a style="width: 100%; height: 40px; margin-bottom: 20px;background-color: #1e73be;border-color: #1e73be;color: #ffffff;display: block;text-align: center;line-height: 41px;" href="/registration">Регистрация</a>
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
			</p>
			
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>
			
			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="u-column2 col-2">
	
		<?php
		//kk-->
		$display_reg = false;
		if($display_reg){
		//<--kk
		?>

		<h2><?php _e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocomerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" />
			</p>
			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
		<?php
		//kk-->
		}else{
			//echo '<h2>Регистрация</h2>';
			//custom_registration_function();
			/*echo '<h2>Регистрация</h2>';
			echo '<p>Регистрация осуществляется на странице оформления заказа!</p>';
			echo '<a href="/get_orders/">Оформить заказ</a>';*/
		}
		//<--kk
		?>
	</div>

</div>
<?php endif; ?>
<?php
function custom_registration_function() {
    if (isset($_POST['submit'])) {
        registration_validation(
		$_POST['login'],
		$_POST['password'],
		$_POST['nicename'],
		$_POST['email'],
		$_POST['phone'],  
		$_POST['adres'],
        $_POST['firstname'],
		$_POST['lastname'],
        $_POST['company'],
        $_POST['ur_fiz'],
		$_POST['promocod']
		);
		
		// sanitize user form input
        global $login, $password, $nicename, $email, $phone, $adres, $firstname, $lastname, $company, $ur_fiz,$promocod;
        $login	    = 	sanitize_text_field($_POST['login']);
        $password 	= 	esc_attr($_POST['password']);
		$nicename	= 	sanitize_text_field($_POST['nicename']);
        $email 		= 	sanitize_email($_POST['email']);
        $phone  	= 	sanitize_text_field($_POST['phone']);
		$adres    	= 	sanitize_text_field($_POST['adres']);
		$firstname 	= 	sanitize_text_field($_POST['firstname']);
		$lastname 	= 	sanitize_text_field($_POST['lastname']);
		$company 	= 	sanitize_text_field($_POST['company']);
		$ur_fiz 	= 	sanitize_text_field($_POST['ur_fiz']);
		$promocod   =   sanitize_text_field($_POST['promocod']);


		// call @function complete_registration to create the user
		// only when no WP_error is found
        complete_registration(
			$login,
			$password,
			$nicename,
			$email,
			$phone,
			$adres,
			$firstname,
			$lastname,
			$company,
			$ur_fiz,
			$promocod
		);
    }

    registration_form(
			$login,
			$password,
			$nicename,
			$email,
			$phone,
			$adres,
			$firstname,
			$lastname,
			$company,
			$ur_fiz,
			$promocod
	);
}
function registration_form( $login,$password,$nicename,$email,$phone,$adres,$firstname,$lastname,$company,$ur_fiz,$promocod ) {
    echo '
    <style>
	.kk_new_registration div {margin-bottom:2px;}
	.kk_new_registration input{margin-bottom:4px;}
	</style>
	';

    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="kk_new_registration">
	
	<div>
	<label for="ur_fiz" style="width: 130px; display: inline-block;">Тип покупателя <strong>*</strong></label>
	<select name="ur_fiz" id="new_reg_ur_fiz"  data-placeholder="Физическое лицо/Юридическое лицо" style="width: 300px; display: inline-block;" >
		<option '.($_POST['ur_fiz']== 'option_1' ? 'selected' : '').' value="option_1">Физическое лицо</option>
		<option '.($_POST['ur_fiz']== 'option_2' ? 'selected' : '').' value="option_2">Юридическое лицо</option>
	</select>
	</div>
	
	<div>
	<label for="login" style="width: 130px; display: inline-block;">Логин <strong>*</strong></label>
	<input type="text" name="login" style="width: 300px; display: inline-block;" value="' . (isset($_POST['login']) ? $login : null) . '">
	</div>
	
	<div>
	<label for="password" style="width: 130px; display: inline-block;">Пароль <strong>*</strong></label>
	<input type="password" name="password" style="width: 300px; display: inline-block;" value="' . (isset($_POST['password']) ? $password : null) . '">
	</div>
	
	<div>
	<label for="nicename" style="width: 130px; display: inline-block;">Никнейм <strong>*</strong></label>
	<input type="text" name="nicename" style="width: 300px; display: inline-block;" value="' . (isset($_POST['nicename']) ? $nicename : null) . '">
	</div>
	
	<div>
	<label for="email" style="width: 130px; display: inline-block;">Email <strong>*</strong></label>
	<input type="text" name="email" style="width: 300px; display: inline-block;" style="width: 300px; display: inline-block;" value="' . (isset($_POST['email']) ? $email : null) . '">
	</div>
	
	<div>
	<label for="phone" style="width: 130px; display: inline-block;">Телефон <strong>*</strong></label>
	<input type="text" name="phone" style="width: 300px; display: inline-block;" value="' . (isset($_POST['phone']) ? $phone : null) . '">
	</div>	
	
	<div>
	<label for="adres" style="width: 130px; display: inline-block;">Адрес <strong>*</strong></label>
	<input type="text" name="adres" style="width: 300px; display: inline-block;" value="' . (isset($_POST['adres']) ? $adres : null) . '">
	</div>';	
	
	
	if($_POST['ur_fiz']== 'option_2'){
		echo '
		<div>
		<label for="company" style="width: 130px; display: inline-block;">Компания <strong>*</strong></label>
		<input type="text" name="company" style="width: 300px; display: inline-block;" value="' . (isset($_POST['company']) ? $company : null) . '">
		</div>';	
	}

	echo '	
	<div>
	<label for="firstname" style="width: 130px; display: inline-block;">Имя <strong>*</strong></label>
	<input type="text" name="firstname" style="width: 300px; display: inline-block;" value="' . (isset($_POST['firstname']) ? $firstname : null) . '">
	</div>
	
	<div>
	<label for="lastname" style="width: 130px; display: inline-block;">Фамилия <strong>*</strong></label>
	<input type="text" name="lastname" style="width: 300px; display: inline-block;" value="' . (isset($_POST['lastname']) ? $lastname : null) . '">
	</div>
	
	<div>
	<label for="promocod" style="width: 130px; display: inline-block;">ПРОМОКОД </label>
	<input type="text" name="promocod" style="width: 300px; display: inline-block;" value="' . (isset($_POST['$promocod']) ? $promocod : null) . '">
	</div>
	
	<input type="submit" name="submit" style="width: 434px;height: 40px;margin-top: 20px;" id="registr_new" value="Зарегистрироваться"/>
	</form>
	';
}
function registration_validation( $login,$password,$nicename,$email,$phone,$adres,$firstname,$lastname,$company,$ur_fiz,$promocod )  {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if ( empty( $login ) || empty( $password ) || empty( $email ) || empty( $nicename ) || empty( $phone ) || empty( $adres ) || empty( $firstname ) || empty( $lastname ) || empty( $ur_fiz )) {
        $reg_errors->add('field', 'Не заполнены обязательные поля');
    }

    if ( strlen( $login ) < 4 ) {
        $reg_errors->add('username_length', 'Логин слишком короткий');
    }

    if ( username_exists( $login ) )
        $reg_errors->add('user_name', 'Данный Логин уже используется');

    if ( !validate_username( $login ) ) {
        $reg_errors->add('username_invalid', 'В Логине присутствуют запрещенные символы');
    }

    if ( strlen( $password ) < 5 ) {
        $reg_errors->add('password', 'Пароль должен быть больше 5 символов');
    }

    if ( !is_email( $email ) ) {
        $reg_errors->add('email_invalid', 'Email не прошел проверку на валидность');
    }

    if ( email_exists( $email ) ) {
        $reg_errors->add('email', 'Email уже используется');
    }
	if($ur_fiz == 'option_2' && empty( $company )){
		$reg_errors->add('field', 'Вы не заполнили поле Компания как Юр. лицо');
	}
    if ( is_wp_error( $reg_errors ) ) {
        foreach ( $reg_errors->get_error_messages() as $error ) {
			echo '<div class="woocommerce-error" style="width: 434px;">';
            echo '<strong>Ошибка</strong>:';
            echo $error . '<br/>';
			echo '</div>';
        }
		
    }
}
function complete_registration() {
    global $reg_errors,$login, $password, $nicename, $email, $phone, $adres, $firstname, $lastname, $company, $ur_fiz,$promocod;
    if ( count($reg_errors->get_error_messages()) < 1 ) {
		//БД-открытие соединения
		$server_bd = mysqli_connect('rosprod.mysql', 'rosprod_mysql', 'D/RSnPZ9') or die('No connect to Server');
		mysqli_select_db($server_bd, 'rosprod_db') or die('No connect to DB');
		mysqli_set_charset($server_bd,"utf8");
		
		//1.Создадим нового
		$display_name = $firstname . ' ' . $lastname;
		$passwordmd5  = md5($password);
		$query_data = "INSERT INTO wp_users (ID,user_login,user_pass,user_nicename,user_email,user_status,display_name) ";
		$query_data = $query_data . "VALUES ('','$login','$passwordmd5','$nicename','$email',0,'$display_name')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));
		$id_int     = mysqli_insert_id($server_bd);	
		//2.создадим информацию фио
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'first_name','$firstname')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));				
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'billing_first_name','$firstname')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));	
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'shipping_first_name','$firstname')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));	
			
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'last_name','$lastname')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));	
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'billing_last_name','$lastname')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));	
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'shipping_last_name','$lastname')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));	
		//3.создадим компанию
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'billing_company','$company')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));		
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'shipping_company','$company')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));
		//4.создадим телефон
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'billing_phone','$phone')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));
		//5.создадим почту
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'billing_email','$email')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));			
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'billing_email_cont','$email')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));	
		//6.создадим адрес
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'billing_address_1','$adres')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'shipping_address_1','$adres')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));
		//7.установим роль клиент
		$query_data = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) ";
		$query_data = $query_data . "VALUES ('',$id_int,'wp_capabilities','a:1:{s:8:\"customer\";b:1;}')";
		$res_data   = mysqli_query($server_bd, $query_data) or die(mysqli_error($server_bd));
		//8.генерируем реферальную ссылку
		$referal = str_replace("(","",$phone);
		$referal = str_replace(")","",$referal);
		$referal = str_replace("+","",$referal);
		$referal = str_replace(" ","",$referal);
		$referal = substr($referal, -7);
        $query_insert = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) VALUES ('',$id_int,'kk_referal','$referal')";
        $res_insert = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));
		//9.запишем промокод
        $query_insert = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) VALUES ('',$id_int,'kk_promocod','$promocod')";
        $res_insert = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));		
		//10.начисление бонусов
		if(strlen($promocod)>0){
			//10.1 ищем по промокоду юзера - реферала
			$query_search_referal = "SELECT user_id FROM wp_usermeta WHERE meta_key = 'kk_referal' AND meta_value='$promocod'";
			$res_search_referal = mysqli_query($server_bd, $query_search_referal) or die(mysqli_error($server_bd));	
			if(mysqli_num_rows($res_search_referal)!=0){
				$row_search_referal = mysqli_fetch_row($res_search_referal);
				$id_referal = $row_search_referal[0];
				//Регистрация по приглашению = 300 руб
				$query_insert = "INSERT INTO kk_score_users (ID_score,ID_user,Amount_score) VALUES ('',$id_int,300)";
				$res_insert   = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));	
				$lastInsertedId = mysqli_insert_id($server_bd);
				//добавим в историю
				$date         = date("Y-m-d H:i:s");
				$query_insert = "INSERT INTO kk_score_users_history (ID_history,ID_score,Bid,Bid_date,Comments) VALUES ('',$lastInsertedId,300,'$date','Начисление бонусов при регистрации по рефералу $promocod')";
				$res_insert   = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));
				

				/*$query_select = "SELECT ID_score,Amount_score FROM kk_score_users WHERE ID_user = $id_referal";
				$res_query    = mysqli_query($server_bd, $query_select) or die(mysqli_error($server_bd));
				$row_query    = mysqli_fetch_row($res_query);
				
				$id_bonus_referal = $row_query[0];	
				$amount_score     = $row_query[1]+100;
				
				$query_update = "UPDATE kk_score_users SET Amount_score = '$amount_score' WHERE ID_user = $id_referal";
				$res_update   = mysqli_query($server_bd, $query_update) or die(mysqli_error($server_bd));				

				$date         = date("Y-m-d H:i:s");
				$query_insert = "INSERT INTO kk_score_users_history (ID_history,ID_score,Bid,Bid_date,Comments) VALUES ('',$id_bonus_referal,100,'$date','Начисление бонусов за приглашение')";
				$res_insert   = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));*/				
			}else{
				//Регистрация = 100 руб на счёт
				$query_insert = "INSERT INTO kk_score_users (ID_score,ID_user,Amount_score) VALUES ('',$id_int,100)";
				$res_insert   = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));	
				$lastInsertedId = mysqli_insert_id($server_bd);				
				//добавим в историю
				$date         = date("Y-m-d H:i:s");
				$query_insert = "INSERT INTO kk_score_users_history (ID_history,ID_score,Bid,Bid_date,Comments) VALUES ('',$lastInsertedId,100,'$date','Начисление бонусов при регистрации')";
				$res_insert   = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));	
				
			}//if(mysqli_num_rows($res_search_referal)!=0)
		}else{
				//Регистрация = 100 руб на счёт
				$query_insert = "INSERT INTO kk_score_users (ID_score,ID_user,Amount_score) VALUES ('',$id_int,100)";
				$res_insert   = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));	
				$lastInsertedId = mysqli_insert_id($server_bd);				
				//добавим в историю
				$date         = date("Y-m-d H:i:s");
				$query_insert = "INSERT INTO kk_score_users_history (ID_history,ID_score,Bid,Bid_date,Comments) VALUES ('',$lastInsertedId,100,'$date','Начисление бонусов при регистрации')";
				$res_insert   = mysqli_query($server_bd, $query_insert) or die(mysqli_error($server_bd));				
		}//if(strlen($promocod)>0)
	
		//БД-закрытие соединения
		mysqli_close($server_bd);		
		
		echo '<div class="woocommerce-error" style="width: 434px;background-color:green;">';
        echo 'Регистрация успешно завершена!'; 
		echo '</div>';		
		
	}
}
?>
<script>   
$(document).ready(function(){
	var url = window.location.href;
	$("#new_reg_ur_fiz" ).change(function(){	
		var ur_fiz_pozt = $("select#new_reg_ur_fiz").val();
		$.post( "http://business.universam-online.ru/my_account/", { ur_fiz: ur_fiz_pozt} );
		$('#registr_new').click();
	});   
});        
</script> 
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
