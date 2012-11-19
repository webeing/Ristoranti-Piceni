<?php
/**
 * The template used for displaying profilo
 */
global $user_ID;
global $facebook;

$user = get_user_by('id', $user_ID);

 try {
$fb_user = $facebook->getUser();
$fb_user_profile = $facebook->api('/me');
 }catch (FacebookApiException $e) {

     }
?>
	<header class="entry-header">
        <?php
            if ( $fb_user && $fb_user_profile )
                echo '<img src="http://graph.facebook.com/'. $fb_user_profile['id'] . '/picture?type=large" alt="' . $fb_user_profile['username'] .'" />';
            else
                echo get_avatar( $user_ID, 150, $default, $user->user_login );

       ?>


        <h2 class="entry-title title"><?php echo $user->user_login; ?></h2>
	</header><!-- .entry-header -->
	<div class="entry-content">
        <ul>
            <li> <p>Indirizzo email di registrazione: <?php echo $user->user_email; ?></p> </li>
            <li>
                <?php if($fb_user_profile==''){ ?>
                <h5 class="reg-claim">Accedi a Ristoranti Piceni usando il tuo account Facebook per partecipare a "Io Mangio Gratis": clicca su "Accedi"</h5>
                <?php } ?>
                <div id="fb-login">
                    <div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1" scope="email,user_birthday,status_update" size="xlarge"></div>
                </div>
            </li>
            <li>
                <h5 class="reg-claim">Cambia password</h5>

                <form id="rp_nuova_password_form" method="post" >
                    <p>
                        <label>Nuova Password:</label>
                        <input type="password" name="rp_nuova_password" id="rp_nuova_password" class="text" value="" />
                        <input type="button" id="submitbtn" name="submit" value="Modifica Password" />
                        <input type="hidden" name="rp_user_id" id="rp_user_id" value="<?php echo $user_ID; ?>">

                    </p>
                </form>

                <?php //Risultati delle interazioni Ajax ?>
                <div id="result"></div>
            </li>
            <li>
                <?php if($fb_user_profile){ ?>
                <input type="button" id="logout" value="Disconetti da facebook"/>
                <input type="button" id="add_friends" value="Invita i tuoi amici"/>
                <?php }?>
                <?php if($user_ID){ ?>

                <input type="button" id="logout_wp" value="Esci"/>

                <?php }?>
                <div id="msg"></div>
            </li>
        </ul>
      <div class="clear"></div>
	</div><!-- .entry-content -->


