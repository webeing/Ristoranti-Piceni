<?php
/*
Template Name: Registrazione
*/

global $wpdb, $user_ID, $facebook;
//Controlla se l'utente è loggato


if (!$user_ID) {



     get_header();


    ?>

    <section id="container" class="row">
        <div id="content" role="main" class="col-left left">

            <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content', 'page' ); ?>

            <?php endwhile; // end of the loop.?>
            <?php if(get_option('users_can_register')) {
            //controlla se l'amministratore consente la registrazione

            if(!$facebook->getUser()){?>
            <h5 class="reg-claim">Accedi a Ristoranti Piceni semplicemente usando il tuo account Facebook: clicca su "Accedi"</h5>

            <div id="fb-login">
                <div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1" scope="email,user_birthday,status_update,publish_stream" size="xlarge"></div>
            </div>

            <?php } else {?>

                <h5 class="reg-claim">Completa la tua iscrizione inserendo un username</h5>

            <div id="fb-login">
                <div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1" scope="email,user_birthday,status_update,publish_stream" size="xlarge"></div>
            </div>
                <input type="button" id="logout" value="Disconetti da facebook"/>

            <?php } ?>
            <div id="rp-registration-form">
            <?php
                try {
                $fb_user = $facebook->getUser();
                $fb_user_profile = $facebook->api('/me');
                ?>
                    <input type="hidden" name="rp_idfacebook" id="rp_idfacebook" value="<?php echo $fb_user; ?>" />



                <?php
                }
                catch (FacebookApiException $e) {?>

                    <h5 class="reg-claim" id="form-actions">oppure registrati semplicemente inserendo una user e il tuo indirizzo email</h5>

                <?php
                }
            ?>



                <form id="rp_signup_form" method="post" >
                    <p>
                        <label>Username</label><br />
                        <input type="text" name="rp_username" id="rp_username" class="text" value="" />
                    </p>
                    <p>
                        <label>Indirizzo Email</label><br />
                        <?php
                        try {
                        $fb_user = $facebook->getUser();
                        $fb_user_profile = $facebook->api('/me');?>

                        <input type="text" name="rp_email" id="rp_email" class="text" value="<?php echo $fb_user_profile['email']; ?>" disabled="disabled"/>

                        <?php
                        }
                            catch (FacebookApiException $e) {?>

                                <input type="text" name="rp_email" id="rp_email" class="text" value="" />
                            <?php
                        }
                        ?>

                    </p>
                    <p>
                        <input type="button" id="submitbtn" name="submit" value="Registrati" />
                    </p>
                </form>

            </div>
            <?php //Rissultati delle interazioni Ajax ?>
            <div id="result">

            </div>

            <?php } else echo "La registrazione è stata al momento disabilitata dall'amministratore. Riprovare più tardi"; ?>

            <h5 class="reg-claim" id="form-login">Sei già untente? Esegui il <a href="<?php echo "/" . RP_LOGIN_URL_SLUG ?>" title="esegui il login">login</a></h5>

        </div>

        <?php get_sidebar('-page'); ?>
        <div class="clear"></div>
    </section><!-- #container -->
    <?php

    get_footer();

    } else {
    wp_redirect( get_author_posts_url( $user_ID ));
    }
?>