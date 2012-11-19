<?php
/*
 * Template Name: Login
 */
    get_header();
?>

        <section id="container" class="row">
            <div id="content" role="main" class="col-left left">
                <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', 'page' ); ?>

                <?php endwhile;?>
                <div id="fb-login">
                    <div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1" scope="email,user_birthday,status_update,publish_stream" size="xlarge"></div>
                </div>
                <div id="result"></div> <!-- To hold validation results -->
                <form id="wp_login_form" method="post">

                    <label>Username</label><br>
                    <input name="rp_login_username" class="text" value="" type="text"><br>
                    <label>Password</label><br>
                    <input name="rp_login_password" class="text" value="" type="password"> <br>
                    <label>
                        <input name="rp_login_rememberme" value="forever" type="checkbox">Ricordami</label>
                    <br><br>
                    <input id="submitbtn" name="submit" value="Login" type="button">
                </form>
                    <h5 class="reg-claim" id="form-login">non sei ancora registrato? <a href="<?php echo "/" . RP_REGISTER_URL_SLUG ?>" title="registrati subito">Registrati subito</a> oppure usa il tasto Facebook!</h5>

                <a id="recover-rp" href="#dialog-recover-rp" title="<?php _e('Resetta password ', 'rp') ;?>"> <?php  _e( 'Resetta password ', 'rp' ) ;?></a>
                <div id="dialog-recover-rp" class="hide">
                    <form id="wp_recover_password_form" method="post">
                        <label><?php _e('Inserisci la mail che hai usato per la registrazione ', 'rp') ;?></label><br>
                        <input name="rp_recover_psw" class="text" value="" type="text">
                        <input id="recoverbtn" name="submit" value="<?php _e('Resetta password', 'rp') ;?>" type="button">
                    </form>
                    <div id="result_recover"></div>
                </div>
            </div><!-- #content -->

        <?php get_sidebar('-page'); ?>
        <div class="clear"></div>
    </section><!-- #container -->
    <?php get_footer(); ?>

