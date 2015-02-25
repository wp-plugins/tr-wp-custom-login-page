<?php  

/**
 * Plugin Name: TR Custom Login
 * 
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







