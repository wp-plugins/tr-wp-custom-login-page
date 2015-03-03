<?php 

/*
****************************************************************
*
* Enqueue Script
***********************************************************************/

// enqueue needed assets (for tinymce actualy)
function tr_options_page_enqueue() {
    wp_enqueue_script('common');
    wp_enqueue_script('jquery-color');
    wp_print_scripts('editor');
    if (function_exists('add_thickbox')) add_thickbox();
    wp_print_scripts('media-upload');
    if (function_exists('wp_editor()')) wp_editor();
    wp_admin_css();
    wp_enqueue_script('utils');
    do_action("admin_print_styles-post-php");
    do_action('admin_print_styles');

    // handling upload_button for logotype, copy-pasted from custom-metadata plugin
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var upload_field, upload_preview;
        if ($('.upload_button').length) {
            $('.upload_button').live('click', function(e) {
                upload_field = $(this).closest('td').find('input.upload_field:first');
                upload_preview = $(this).closest('td').find('img.upload_preview:first');
                window.send_to_editor=window.send_to_editor_clone;
                tb_show('','media-upload.php?TB_iframe=true');
                return false;
            });
            window.original_send_to_editor = window.send_to_editor;
            window.send_to_editor_clone = function(html){
                file_url = jQuery('img',html).attr('src');
                if (!file_url) { file_url = jQuery(html).attr('href'); }
                tb_remove();
                upload_field.val(file_url);
                upload_preview.attr('src', file_url);
            }
        }

        $('.upload_clear').live('click', function(e) {
            $(this).closest('td').find('input.upload_field:first').val('');
            $(this).closest('td').find('img.upload_preview:first').hide();
            return false;
        });
    });
    </script>
    <?php
}





add_action( 'admin_enqueue_scripts', 'tmrd_add_color_picker' );
function tmrd_add_color_picker( $hook ) {
 
    if( is_admin() ) { 
     
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'color-picker/custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}





/*
****************************************************************
*
* Default Value
***********************************************************************/

//Default theme options Value
function tr_default_option_value() {
    $options = array(
        'text_ex' => 'TR Options Text Box Demo',
        'tynemce_ex' => 'TR Options TyneMce Demo',
        'copyright' => 'All rights reserverd.',
        'logo_demo' => '',
    );
    return $options;
}


/*
****************************************************************
*
* Helper Function to Get Value
***********************************************************************/



function get_tmrd_option($name) {
    $options = get_option('tr_theme_options', tr_default_option_value());

    return $options[$name];
}
function tmrd_option($name) {
    echo get_tmrd_option($name);
}




/*
****************************************************************
*
*Add Menu Settings Page
***********************************************************************/


function tmrd_menu_options() {
    // page title, menu title, access rules, url slug, render callback function
    $page = add_menu_page('TR Options', 'Custom Login', 'edit_theme_options', 'demo_options', 'tr_theme_options_callback');
    add_action('admin_print_scripts-' . $page, 'tr_options_page_enqueue');
}
add_action('admin_menu', 'tmrd_menu_options');


/*
****************************************************************
*
* Register Settings
***********************************************************************/

function tr_settings_api_init() {
    // retrieve settings, if settings not set, save options
    if(false === get_option('tr_theme_options', tr_default_option_value()))
        add_option('tr_theme_options', tr_default_option_value());

    //group name (can be any, see settings_fields() call in tr_theme_options_render_page()), option name (look at add_option, get_option), validate function callback
    register_setting('tr_options', 'tr_theme_options', 'tr_theme_options_validate');

    // id, title, render callback function, url slug
    add_settings_section('general', '', '__return_false', 'demo_options');
    // $options[KEY], label, render callback function, url slug, settings_section id
    
    add_settings_field('logo_demo', 'Login Form Logo', 'tr_settings_field_demo_logo', 'demo_options', 'general');

    add_settings_field('text_demo', 'Custom Messege', 'tr_settings_field_demo_text', 'demo_options', 'general');
    add_settings_field('login_form_bg', 'Login Form Background', 'tr_settings_field_login_form_bg', 'demo_options', 'general');

    add_settings_field('login_form_text', 'Login Form Text Color', 'tr_settings_field_login_form_text', 'demo_options', 'general');
    add_settings_field('login_bg', 'Login Form Body Background', 'tr_settings_field_login_text', 'demo_options', 'general');
   
    
}
add_action('admin_init', 'tr_settings_api_init');




/*
****************************************************************
*
*Render Demo  Field
***********************************************************************/
 
function tr_settings_field_demo_logo() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
    <?php if(!empty($options['logo_demo'])):?>
        <div>
            <img style="width:150px;height:150px;" class="upload_preview" src="<?php echo esc_attr($options['logo_demo'])?>" />
        </div>
    <?php endif;?>
    <input type="text" class="upload_field" name="tr_theme_options[logo_demo]" id="logo_demo" value="<?php echo esc_attr($options['logo_demo']); ?>" />
    <input type="button" class="button upload_button" value="Upload" />
    <input type="button" class="button upload_clear" value="Remove" />
<?php }




function tr_settings_field_demo_text() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
    <input type="text" name="tr_theme_options[text_demo]" id="text_demo" value="<?php echo esc_attr($options['text_demo']); ?>" />
<?php }

function tr_settings_field_login_form_text() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
    <input type="text" class="demo-color" name="tr_theme_options[login_form_text]" id="login_form_text" value="<?php echo esc_attr($options['login_form_text']); ?>" />
<?php }

function tr_settings_field_login_form_bg() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
    <input type="text" class="demo-color" name="tr_theme_options[login_form_bg]" id="login_form_bg" value="<?php echo esc_attr($options['login_form_bg']); ?>" />
<?php }
function tr_settings_field_login_text() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
    <input type="text" class="demo-color" name="tr_theme_options[login_bg]" id="login_bg" value="<?php echo esc_attr($options['login_bg']); ?>" />
<?php }








/*
****************************************************************
*
*validation callbackd
***********************************************************************/


function tr_theme_options_validate($input) {
    $output = $defaults = tr_default_option_value();

    $output['login_bg'] = empty($input['login_bg']) ? $defaults['login_bg'] : $input['login_bg'];
    $output['login_form_bg'] = empty($input['login_form_bg']) ? $defaults['login_form_bg'] : $input['login_form_bg'];
    $output['login_form_text'] = empty($input['login_form_text']) ? $defaults['login_form_text'] : $input['login_form_text'];

    $output['text_demo'] = empty($input['text_demo']) ? $defaults['text_demo'] : $input['text_demo'];


    $output['logo_demo'] = empty($input['logo_demo']) ? $defaults['logo_demo'] : $input['logo_demo'];

    if(!empty($output['logo_demo'])) { // allow only jpg, png and gif logotypes
        $output['logo_demo'] = in_array(strtolower(end(explode('.', $output['logo_demo']))), array('jpg', 'jpeg', 'png', 'gif')) ? $output['logo_demo'] : '';
    }

    if(!empty($output['logo_demo'])) { // try to get full image
        if(0 === strpos($output['logo_demo'], home_url())) { // if it is local image
            if(preg_match('/(.*?)\-\d+x\d+\.(jpg|jpeg|gif|png)$/usi', $output['logo_demo'], $match)) { //not full size
                $upload_dir = wp_upload_dir();

                if(file_exists($upload_dir['basedir'] . DIRECTORY_SEPARATOR . str_replace($upload_dir['baseurl'], '', $match[1] . '.' . $match[2]))) {
                    $output['logo_demo'] = $match[1] . '.' . $match[2];
                }
            }
        }
    }

    return $output;
}

// render page callback
function tr_theme_options_callback() { ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Custom Login Options</h2>
        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php
                settings_fields('tr_options');
                do_settings_sections('demo_options');
                submit_button();
        
            ?>
        </form>
    </div>
<?php }




