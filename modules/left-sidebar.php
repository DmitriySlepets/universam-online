<?php
//мой виджет боковой панели - начало
add_action( 'widgets_init', 'my_widget' );
function my_widget() {register_widget( 'MY_Widget' );}
class MY_Widget extends WP_Widget {
    function MY_Widget() {
        $widget_ops = array( 'classname' => 'example', 'description' => __('Codeking - левая панель хитов/новинок ', 'example') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );	$this->WP_Widget( 'example-widget', __('KK_Хиты/Новинки', 'example'), $widget_ops, $control_ops );
    }
    function widget( $args, $instance ) {
        extract( $args );
        //Our variables from the widget settings.
        $title = apply_filters('widget_title', $instance['title'] );
        $name = $instance['name'];
        $show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
        echo $before_widget;
        // Display the widget title
        /*if ( $title )
            echo $before_title . '<span style="color: #1e73be; text-align:center; display: block;">' . $title . '</span>' . $after_title;*/
        echo $after_widget;
        echo '<div class="google-direct" title="google-direct">';

        echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
        echo '<!-- Новая маленькая левая реклама -->';
        echo '<ins class="adsbygoogle"';
        echo 'style="display:inline-block;width:180px;height:200px"';
        echo 'data-ad-client="ca-pub-2521513377576679"';
        echo 'data-ad-slot="6364017355"></ins>';
        echo '<script>';
        echo '(adsbygoogle = window.adsbygoogle || []).push({});';
        echo '</script>';

        echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
        echo '<!-- Новая маленькая левая реклама2 -->';
        echo '<ins class="adsbygoogle"';
        echo 'style="display:inline-block;width:180px;height:200px"';
        echo 'data-ad-client="ca-pub-2521513377576679"';
        echo 'data-ad-slot="6156003916"></ins>';
        echo '<script>';
        echo '(adsbygoogle = window.adsbygoogle || []).push({});';
        echo '</script>';

        echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
        echo '<!-- Новая маленькая левая реклама3 -->';
        echo '<ins class="adsbygoogle"';
        echo 'style="display:inline-block;width:180px;height:200px"';
        echo 'data-ad-client="ca-pub-2521513377576679"';
        echo 'data-ad-slot="1009271401"></ins>';
        echo '<script>';
        echo '(adsbygoogle = window.adsbygoogle || []).push({});';
        echo '</script>';

        echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
        echo '<!-- Новая маленькая левая реклама4 -->';
        echo '<ins class="adsbygoogle"';
        echo 'style="display:inline-block;width:180px;height:200px"';
        echo 'data-ad-client="ca-pub-2521513377576679"';
        echo 'data-ad-slot="3060719676"></ins>';
        echo '<script>';
        echo '(adsbygoogle = window.adsbygoogle || []).push({});';
        echo '</script>';

        /*
        echo '<div title="google-direct" style="width:90%;">';
        echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
        echo '<!-- Новый левый баннер -->';
        echo '<ins class="adsbygoogle"';
        echo 'style="display:inline-block;width:250px;height:360px"';
        echo 'data-ad-client="ca-pub-2521513377576679"';
        echo 'data-ad-slot="8089627603"></ins>';
        echo '<script>';
        echo '(adsbygoogle = window.adsbygoogle || []).push({});';
        echo '</script>';
        */
        /*
        echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
        echo '<!-- Рекламный блок -->';
        echo '<ins class="adsbygoogle"';
        echo 'style="display:block"';
        echo 'data-ad-client="ca-pub-2521513377576679"';
        echo 'data-ad-slot="3328768862"';
        echo 'data-ad-format="auto"';
        echo 'data-full-width-responsive="true"></ins>';
        echo '<script>';
        echo '(adsbygoogle = window.adsbygoogle || []).push({});';
        echo '</script>';
        */
        echo '</div>';

    }
    //Update the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        //Strip tags from title and name to remove HTML
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }
    function form( $instance ) {
        //Set up some default widget settings.
        $defaults = array( 'title' => __('Example', 'example'), 'name' => __('Bilal Shaheen', 'example'), 'show_info' => true );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <?php
    }
}
//мой виджет боковой панели - конец
?>