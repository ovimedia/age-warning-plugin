<?php
/*
Plugin Name: Age Warning Plugin
Description: Plugin that shows a age warning to access on the web page.
Author: Ovi García - ovimedia.es
Author URI: http://www.ovimedia.es/
Text Domain: age-warning-plugin
Version: 0.1
Plugin URI: http://www.ovimedia.es/
*/

function age_warning_menu() 
{	
	$menu = add_menu_page( 'Age Warning', 'Age Warning', 'read',  'age_warning', 'warning_form', 'dashicons-warning', 80);
}

add_action( 'admin_menu', 'age_warning_menu' );


function warning_form()
{
     $values = json_decode(get_option("aw_options"), true);
?>
    <div class="wrap_warning"> 
    
        <form method="post" action="./aw_save_options">

            <p><label for="aw_message"><?php echo _e( 'Message:', 'age-warning-plugin' ); ?> </label><br/>
            <textarea id="aw_message" name="aw_message"><?php echo $values["aw_message"]; ?></textarea></p>

            <p><label for="aw_btn_ok"><?php echo _e( 'Acept button:', 'age-warning-plugin' ); ?></label>
            <input type="text" id="aw_btn_ok"  name="aw_btn_ok" value="<?php echo $values["aw_btn_ok"]; ?>"  /></p>

            <p><label for="aw_btn_cancel"><?php echo _e( 'Cancel button:', 'age-warning-plugin' ); ?> </label>
            <input type="text" id="aw_btn_cancel" name="aw_btn_cancel" value="<?php echo $values["aw_btn_cancel"]; ?>" /></p>

            <input type="hidden" value="1" id="validation" name="validation" />

            <p><input type="submit" class="button-primary" value="Guardar" /></p>
        </form>
    
    </div>
    <?php
    
}   

function aw_admin_styles_scripts() 
{
	wp_register_style( 'custom_aw_admin_css', get_home_url() . '/wp-content/plugins/age-warning-plugin/css/aw_admin.css', false, '1.0.0' );
	
	wp_enqueue_style( 'custom_aw_admin_css' );
}

add_action( 'admin_enqueue_scripts', 'aw_admin_styles_scripts' );

function aw_styles_scripts() 
{
    wp_enqueue_script( 'aw_script', get_home_url(). '/wp-content/plugins/age-warning-plugin/js/message.js', array('jquery') );
    
	wp_register_style( 'custom_aw_css', get_home_url() . '/wp-content/plugins/age-warning-plugin/css/aw_style.css', false, '1.0.0' );
	
	wp_enqueue_style( 'custom_aw_css' );
	
}

add_action( 'wp_enqueue_scripts', 'aw_styles_scripts' );


function age_warning_message() 
{
    $values = json_decode(get_option("aw_options"), true);
	?>
        <div class="aw_background">
            <div class="div_warning_message">
                <p>
                <?php if($values["aw_message"] != "") 
                        echo $values["aw_message"]; 
                    else 
                        echo _e( 'You are entering a restricted page for children under 18 years.', 'age-warning-plugin' );
                    ?>
                </p> 
                <span id="aw_btn_ok">
                <?php if($values["aw_btn_ok"] != "") 
                        echo $values["aw_btn_ok"]; 
                    else 
                        echo _e( 'Enter', 'age-warning-plugin' ); ?>
                    </span> 
                <span id="aw_btn_cancel">
                <?php if($values["aw_btn_cancel"] != "") 
                        echo $values["aw_btn_cancel"]; 
                    else 
                        echo _e( 'Exit', 'age-warning-plugin' );  ?></span> 
            </div>
        </div>
    <?php
}

add_action( 'wp_footer', 'age_warning_message', 1 );

function aw_save_options() {
        if( basename($_SERVER['REQUEST_URI']) == "aw_save_options" && isset($_REQUEST["validation"])){
            update_option("aw_options", json_encode($_REQUEST));
            wp_redirect(get_home_url()."/wp-admin/admin.php?page=age_warning");
        exit();
    }
}

add_action( 'init', 'aw_save_options');                        

function aw_load_languages() 
{
    load_plugin_textdomain( 'age-warning-plugin', false, basename( dirname( __FILE__ ) ) . '/languages/' ); 
}

add_action( 'init', 'aw_load_languages' );

?>