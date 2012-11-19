
/**
 * Created by JetBrains PhpStorm.
 * User: Webeing.net
 * Date: 26/10/12
 * Time: 18:34
 */
/**
 * Facebook Area
 */


jQuery(function($){

    rp_reset();

    var appId = '328362657261088';
    var channel = '//rp.essereweb.net/channel.php';

    window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
        appId      : appId, // App ID from the App Dashboard
        channelUrl : channel, // Channel File for x-domain communication
        status     : true, // check the login status upon init?
        cookie     : true, // set sessions cookies to allow your server to access the session?
        xfbml      : true  // parse XFBML tags on this page

    });

    // Additional initialization code such as adding Event Listeners goes here

        FB.getLoginStatus(function(response) {
            console.log(response);
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app
            } else {
                // the user isn't logged in to Facebook.
            }
        });

        FB.Event.subscribe('auth.login', function(response) {
            login();

        });

        FB.Event.subscribe('auth.logout', function(response) {
            logout();
        });

        FB.Event.subscribe('auth.authResponseChange', function(response){
            if (response.status === "connected") {
               // console.log(response);

                // Utente Loggato e Autenticato nell'applicazione
                addLogoutButton();

            }
            else if (response.status === 'not_authorized'){
                console.log(response);
            }
            else{
                console.log(response);
            }
        });




  };

    // Load the SDK's source Asynchronously
    (function(d){
      var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/it_IT/all.js";
     ref.parentNode.insertBefore(js, ref);
    }(document));

    $('input#logout').live('click',function(){
       FB.logout(function(){
           window.location.reload();
       });
    });

    $('input#add_friends').live('click',function(){
        FacebookInviteFriends();


    });

    function FacebookInviteFriends()
    {
        FB.ui({
            method: 'apprequests',
            message: 'Invita i tuoi amici'
        });
    }

     $('#loginfb').click(function(){
         login();
     });

    function login(){
        $('#result').html('<img src="<?php bloginfo('template_url') ?>/images/loader.gif" class="loader" />').fadeIn();
        $('#rp-registration-form').hide();

        FB.api('/me', function(response) {


           var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
           var data = {
               action:  'rp_set_cookie',
               email:   response.email
           };


           $.post(ajaxurl, data, function(result) {


               if(result.status == 'data') {//Se la funzione mi torna un errore (utente già inserito)

                   window.location.href = result.value; //Impostare con l'url per il redirect dopo il login (Ad esempio profilo utente)
                   return;

               } else { //Se la funzione mi dice che posso procedere con la registrazione


                   $( '#form-actions' ).empty().html('Sei registrato con Facebook. Completa solo alcune informazioni di seguito');
                   $( '#rp_email' ).val(data.email);
                   $( '#rp-registration-form' ).fadeIn(2000); //Se l'utente si è iscrittto faccio apparire la nuova form già compilata per il secondo passaggio
                   $( '.loader' ).remove();
                   return;
               }


           }, 'json');
        });


        return;
    }

    function logout(){
       alert('Hai effettuato il logout');
    }

    function addLogoutButton(){
        $('#fb-login .fb-login-button').after('<input type="button" id="logout" value="Disconetti"/>');
        $('#fb-login .fb-login-button').after('<input type="button" id="add_friends" value="Invita i tuoi amici"/>');
    }

    function rp_reset(){
        $('#rp_signup_form').children().val('');
    }

});
