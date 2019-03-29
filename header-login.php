<?php
if (!is_user_logged_in()):
?>
 
<div class="masck none"></div>
<div class="login_box_center none">
    <div class="login_box">
    <h3>Войти</h3>
    <a href="#" class="close-form">Закрыть</a>
    <form id="login" action="login" method="post">
        <p class="status_login"></p>
        <div class="line">
            <i class="icon-user"></i>
            <input id="username" class="input_text" type="text" placeholder="Ваш логин" name="username" />
        </div>
        <div class="line">
            <i class="icon-key"></i>
            <input id="password" class="input_text" type="password" placeholder="Ваш пароль" name="password" />
        </div>
        <div class="line" style="display: none;">
            <input name="rememberme" type="checkbox" id="my-rememberme" checked="checked" value="forever" />
        </div>
        <div class="line cf">
            <input class="submit_button" type="submit" value="Войти" name="submit">
            <div class="login_link">
                <a class="reg_link" href="<?php bloginfo('url'); ?>/wp-login.php?action=register">Регистрация</a> /
                <a class="lost_pass_link" href="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword">Забыли пароль?</a>
            </div>
        </div>
        <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
    </form>
    </div>
</div>
 
<?php
endif;
?>