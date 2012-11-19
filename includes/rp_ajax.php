<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Webeing.net
 * Date: 29/10/12
 * Time: 12.04
 * Interazioni Ajax per Ristoranti Piceni
 */

//Registro le mie action frontend
add_action('wp_ajax_rp_login', 'rp_ajax_login');
add_action('wp_ajax_nopriv_rp_login', 'rp_ajax_login');

function rp_ajax_login(){
    global $wpdb;

    if($_POST){

        //We shall SQL escape all inputs
        $username = $wpdb->escape( $_POST['username'] );
        $password = $wpdb->escape( $_POST['password'] );
        $remember = $wpdb->escape( $_POST['rememberme'] );

        $remember = $remember ? "true" : "false";

        $login_data = array();
        $login_data['user_login'] = $username;
        $login_data['user_password'] = $password;
        $login_data['remember'] = $remember;
        $user_verify = wp_signon( $login_data, true );

        if ( is_wp_error($user_verify) )
        {
            echo responseReturn('error', "Username o password non valida. Riprova ancora" );
            //Password sbagliata
            exit();
        } else {
            echo responseReturn('data', get_author_posts_url($user_verify->ID) );
            exit();
        }
    }

    exit();
}

add_action('wp_ajax_rp_logout', 'rp_ajax_logout');
add_action('wp_ajax_nopriv_rp_logout', 'rp_ajax_logout');

function rp_ajax_logout(){

    wp_clear_auth_cookie();
    echo responseReturn('success', '/');
    exit();
}

//Registro le mie action frontend
add_action('wp_ajax_rp_registrazione', 'rp_ajax_registration');
add_action('wp_ajax_nopriv_rp_registrazione', 'rp_ajax_registration');
/**
 * Elabora i dati dell'invio dalla form di registrazione
 */
function rp_ajax_registration(){
    global $wpdb;
    $idfacebook = $wpdb->escape($_POST['idfacebook']);


    if($_POST){

        $username = $wpdb->escape($_POST['username']);
        if(empty($username)) {

            echo responseReturn( 'error','Inserire una username valida' );
            exit();
        }

        $email = $wpdb->escape($_POST['email']);
        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {

            echo responseReturn( 'error', "Inserire un email valida" );
            exit();
        }

        //$nonce = wp_verify_nonce($_POST['rp_registration_nonce'],'rp_frontend_registration_form');

        $random_password = wp_generate_password( 12, false );


        $status = wp_create_user( $username, $random_password, $email );

        if ( $status != "" && is_wp_error($status) ){
            echo responseReturn( 'error',  "Utente Esistente o errato. Riprova" );

        } else {
            $from = get_option('admin_email');
            $headers = 'From: '.$from . "\r\n";

            $subject = registrationEmailSubject();
            $msg = registrationEmailMessage();

            $msg .= "\nDettaglio login\nUsername: $username\nPassword: $random_password\n";

            wp_mail( $email, $subject, $msg, $headers );
            update_usermeta( $status, 'id_facebook', $idfacebook);
            echo responseReturn('sucess', "Iscrizione avvenuta con successo! Ora controlla la tua email per i dettagli del login" );

        }

        exit();
    }
}


add_action('wp_ajax_rp_user_exists', 'rp_ajax_user_exists');
add_action('wp_ajax_nopriv_rp_user_exists', 'rp_ajax_user_exists');
/**
 * Controlla se esiste uno user con una data email
 */
function rp_ajax_user_exists(){
    global $wpdb;

    if($_POST){

      $email = $wpdb->escape($_REQUEST['email']);

      if ( email_exists($email) ) {
            //Utente già registrato
            echo responseReturn('data', get_author_posts_url(email_exists($email)));
            exit();
      }
      else
            echo responseReturn();
            exit();

   }

}

add_action('wp_ajax_rp_set_cookie', 'rp_ajax_set_cookie_for_user');
add_action('wp_ajax_nopriv_rp_set_cookie', 'rp_ajax_set_cookie_for_user');
/**
 * Imposta il cookie per un utente
 */
function rp_ajax_set_cookie_for_user(){
    global $wpdb;
    if($_POST){

        $email = $wpdb->escape($_REQUEST['email']);

        $user_id = email_exists($email);

        if ( $user_id ) {

            wp_set_auth_cookie( $user_id );
            //Utente già registrato
            echo responseReturn('data', get_author_posts_url($user_id));
            exit();
        }
        else
            echo responseReturn();
        exit();

    }


}


add_action('wp_ajax_rp_recupera_psw', 'rp_ajax_recover_password');
add_action('wp_ajax_nopriv_rp_recupera_psw', 'rp_ajax_recover_password');
/**
 * imposta nuova password
 */
function rp_ajax_recover_password(){
    global $wpdb;
    if($_POST){

        $email = $wpdb->escape($_POST['email']);

        $user_id = email_exists($email);

        if ( $user_id ) {
            $user_info = get_userdata($user_id);
            $username = $user_info-> user_login;
            $random_password = wp_generate_password( 12, false );

            wp_set_password( $random_password, $user_id);


            $from = get_option('admin_email');
            $headers = 'From: '.$from . "\r\n";

            $subject = 'Dati per effettuare il login';
            $msg = 'Può effettuare di nuovo il login con i seguenti dati: ';

            $msg .= "\nUsername: $username\nPassword: $random_password\n";

            wp_mail( $email, $subject, $msg, $headers );

            echo responseReturn('sucess', "Password resettata! Ora controlla la tua email per i dettagli del login" );
            exit();
       }
       else {
           echo responseReturn('error', "Il suo indirizzo email non risulta registrato!" );
           exit();
       }

    }

}




add_action('wp_ajax_rp_nuova_password', 'rp_ajax_change_password');
add_action('wp_ajax_nopriv_rp_nuova_password', 'rp_ajax_change_password');
/**
 * imposta nuova password
 */
function rp_ajax_change_password(){

    //Se il valore dsella passsword è giuto
    //Preparo la risposta
    if(isset($_POST['password']) && isset($_POST['user_id'])){
        wp_set_password( $_POST['password'], $_POST['user_id']);

        $from = get_option('admin_email');
        $headers = 'From: '.$from . "\r\n";

        $password = $_POST['password'];
        $user_info = get_userdata( $_POST['user_id'] );
        $email = $user_info-> user_email;
        $username = $user_info-> user_login;
        $subject = 'Nuova password';
        $msg = 'Riepilogo dati per accedere a ristoranti piceni';

        $msg .= "\nDettaglio login\nUsername: $username\nPassword: $password\n";

        wp_mail( $email, $subject, $msg, $headers );
        echo responseReturn('success','La tua password è stata cambiata correttamente');
        exit();
    }else{
    //Se invece qualcosa va storto
         echo responseReturn('error','Errore');
         exit();
    }

}

/**
 * @param string $status PUò VALERE 'ERROR'(messaggi di errore), 'SUCCESS' (messaggi di successo), 'DATA' (scambio valori)
 * @param string $value
 * @return string
 *
 * Imposta i dati per la restituzione in formato JSON
 */
function responseReturn($status = "success", $value="" ){
    return json_encode(
        array(
            'status'    => $status,
            'value'     => $value
        ));
}

function registrationEmailMessage(){
    //Personalizza il messaggio email
    $url = get_bloginfo('url') . "/" . RP_LOGIN_URL_SLUG;
    $textmail = <<< MAIL
    <p>Grazie per esserti registrato a Ristoranti Piceni!<br />Ti aspettiamo sul nostro sito per partecipare ai contest</p>
    <p>Puoi accedere al seguente link: {$url}</p>
MAIL;
    return $textmail;
}

function registrationEmailSubject(){
    //Personalizza il soggetto email
    return "Registrazione effettuata";
}

add_action('wp_ajax_rp_save_user', 'rp_ajax_save_user_status');
add_action('wp_ajax_nopriv_save_user', 'rp_ajax_save_user_status');
function rp_ajax_save_user_status(){
    global $user_ID;
    global $facebook;
    $user_profile = $facebook->api('/me');

    if( $_POST ){
        update_usermeta( $user_ID, 'id_facebook', $user_profile['id']);
        echo responseReturn('success', 'Complimenti hai associato il tuo profilo facebook al tuo account');
        exit();
    }
}

add_action('wp_ajax_rp_check_user', 'rp_ajax_check_user_status');
add_action('wp_ajax_nopriv_rp_check_user', 'rp_ajax_check_user_status');
function rp_ajax_check_user_status(){
    //Current Wordpress User
    global $user_ID;
    global $facebook;
    global $wpdb;

    // Get Facebook User ID
    $user = $facebook->getUser();

    if ($user) { //utente loggato facebook
        try {
            // Sono autenticato
            $user_profile = $facebook->api('/me');



            //Loggaro dsu WP?
            if ( $user_ID ){


                //controllo se l'utente corrente di facebook corrisponde all'utente wordpress
                if ( get_the_author_meta('id_facebook',$user_ID) != $user_profile['id'] && get_the_author_meta('id_facebook',$user_ID) != ""){

                    $user = null;
                    echo responseReturn('error', 'Il profilo ha già un utente Facebook associato. Operazioni non possibile, contattare un amministratore');
                    exit();

                }
                elseif ( get_the_author_meta('id_facebook',$user_ID) == "" ){
                    echo responseReturn('success', 'Attenzione da questo momento il tuo utente sarà associato a questo account Facebook. Continuare?');
                    exit();
                }



                if(!is_author())
                    echo responseReturn('data',get_author_posts_url( $user_ID ));
                    exit();
            }
            else{
                //non sono loggato su wp
                //$current_facebook = $_POST['id_facebook'];
                //$email = $wpdb->escape($user_profile['email']);
                $current_facebook = $user_profile['id'];

                //$user_register_id = email_exists($email);
                $users = get_users(array('meta_key' => 'id_facebook', 'meta_value' => $current_facebook));

                //controllo se quell'utente fb ha un account wp
                if (count($users) == 1){

                //if ( $user_register_id ){
                    wp_set_auth_cookie( $users[0]->ID );
                    if(!is_author()){
                        echo responseReturn('data',get_author_posts_url( $users[0]->ID ));
                        exit();
                    }
                }
                else{
                    $user = null;
                    if(!is_page(RP_REGISTER_URL_SLUG)){
                        echo responseReturn('data',"/" . RP_REGISTER_URL_SLUG);
                        exit();
                    }
                }
            }

        } catch (FacebookApiException $e) {
            //non sono autenticato
            $user = null;
            if(!is_page(RP_REGISTER_URL_SLUG)){
                echo responseReturn('data',"/" . RP_REGISTER_URL_SLUG);
                exit();
            }
        }
    }
    else {
        if( $user_ID ){
            if(!is_author())
                echo responseReturn('data',get_author_posts_url( $user_ID ));
                exit();
        }

    }
}


/**
add_action('wp_ajax_rp_check_user_facebook', 'rp_ajax_check_user_status_facebook');
add_action('wp_ajax_nopriv_rp_check_user_facebook', 'rp_ajax_check_user_status_facebook');
function rp_ajax_check_user_status_facebook(){
    //Current Wordpress User
    global $user_ID;

    $current_facebook = $_POST['id_facebook'];
    $id_facebook = get_the_author_meta( 'id_facebook', $user_ID );
        if($id_facebook){
            if ( $id_facebook == intval($current_facebook) ) { //utente corrente di facebook corrisponde ad un utente wordpress
                echo responseReturn('success',get_author_posts_url( $user_ID ));
                exit();
            }
            else{
                echo responseReturn('error', 'I dati non corrispondono, usa un altro utente o contattare l amministratore');
                exit();
            }
        }
        else{
            update_usermeta( $user_ID, 'id_facebook', $current_facebook);
        }


}
*/