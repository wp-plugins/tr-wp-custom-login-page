<?php  


/**
 * Plugin Name: TR WP Custom Login Page
 * Plugin URI: http://nakshighor.com/plugins/
 * Description: WP Custom Login Page allows to you change your unlimited custom logo,unlimited custom text,unlimited custom background color,unlimited custom body background color easily.After publishing this plugin people enjoy custom wp login page smoothly. It's really easy to use. So, enjoy and don't forget to rated us.
 
 * Version:  1.0.0
 * Author: Theme Road
 * Author URI: http://nakshighor.com/plugins/
 * License:  GPL2
 *Text Domain: tmrd
 *  Copyright 2015 GIN_AUTHOR_NAME  (email : BestThemeRoad@gmail.com)
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License, version 2, as
 *	published by the Free Software Foundation.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */



require_once('tr_settings.php');





// add a new logo to the login page
function tmrd_login_logo() { ?>

<?php $options = get_option('tr_theme_options', tr_default_option_value());?>

    <style type="text/css">



    .login #login h1 a {


            background-image: url(<?php echo $options['logo_demo']?>);
            min-height: 64px;
            width: 100%;

        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'tmrd_login_logo' );



add_filter( 'login_headertitle', 'login_headertitle_tmrd' );
function login_headertitle_tmrd( $title ){
    return site_url();
}





add_filter( 'login_headerurl', 'login_headerurl_tmrd' );
function login_headerurl_tmrd( $url ){
    return site_url();
}


//Custom Messege

add_filter( 'login_message', 'login_message_tmrd' );
function login_message_tmrd( $msg ){

 $options = get_option('tr_theme_options', tr_default_option_value());?>


 
<h1 class="custom-messege">
    <?php echo $options['text_demo'] ?>
</h1>


<?php
}


function tmrd_login_form_bg(){


   



    ?>

<?php $options = get_option('tr_theme_options', tr_default_option_value());?>



<style type="text/css">

.login label,
#login_error, .login .message,
h1.custom-messege ,
.login #backtoblog a, .login #nav a {
color: <?php echo $options['login_form_text']; ?>;

}

h1.custom-messege {
padding-bottom: 10px;
}

    .login form {
        background: <?php echo $options['login_form_bg']; ?> ;
        background-size: coverd;

    }

    .login-action-login{
        background: <?php echo $options['login_bg']; ?>;
        
        
    }




h1.custom_mesg_style {
padding-bottom: 10px;
}

html {
background:transparent; 
}

    /*Only For Mozila Firefox*/

    @-moz-document url-prefix() {
  
        #login {
        width: 320px;
        padding: 4% 0px 0px;
        margin: auto;
    }
}


</style>

<?php
}
add_action('login_head','tmrd_login_form_bg');







