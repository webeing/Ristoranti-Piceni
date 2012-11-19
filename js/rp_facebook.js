/**
 * Created by JetBrains PhpStorm.
 * User: Webeing.net
 * Date: 26/10/12
 * Time: 18:34
 */
/**
 * Facebook Area
 */
var appId = '328362657261088';

jQuery(function($){

    var ajaxurl = rp_ajax_data.ajaxurl;
    var template_url = rp_ajax_data.template_url;

    rp_reset();



    window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
        appId      : appId, // App ID from the App Dashboard
       // channelUrl : channel, // Channel File for x-domain communication
        status     : true, // check the login status upon init?
        cookie     : true, // set sessions cookies to allow your server to access the session?
        xfbml      : true  // parse XFBML tags on this page

    });

    // Additional initialization code such as adding Event Listeners goes here

        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {


            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app

                //login();
            } else {
                // the user isn't logged in to Facebook.

                //login();
            }
        });

        FB.Event.subscribe('auth.login', function(response) {

            appLogin();
          // if(confirm('Attenzione da questo momento il tuo utente sarà associato a questo account Facebook. Continuare?')){
                // if ( checkUserFacebook() )
              //  appLogin();
                /*else{
                 alert("Il profilo ha gia' un utente Facebook associato. Operazioni non possibile, contattare un amministratore");
                 FB.api("/me/permissions","DELETE",function(response){
                 console.log(response); //gives true on app delete success
                 return;

                 });
                 return;
                 }*/
           /* }
            else {
                FB.api("/me/permissions","DELETE",function(response){
                    console.log(response); //gives true on app delete success

                });
            }*/
            //window.location.reload();
            //reload per la pagina registrazione messo qui perchè su response ricarica la pagina tante volte
        });

        FB.Event.subscribe('auth.logout', function(response) {
        });

        FB.Event.subscribe('auth.authResponseChange', function(response){
            if (response.status === "connected") {



            }
            else if (response.status === 'not_authorized'){

            }
            else{
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


    function login(){
        FB.login(function(response) {
            if (response.authResponse) {


            } else {


            }
        });
    }


    //C'è bisogno i questa????
    //$('#loginfb').click(function(){
        //login();
    //});

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
        }, requestCallback);
    }

    function requestCallback(response) {
        console.log(response);
    }

    function appLogin(){


        $('#result').html('<img src="' + template_url + '/images/loader.gif" class="loader" />').fadeIn();
        $('#rp-registration-form').hide();

        FB.api('/me', function(response) {


           //var ajaxurl = ajaxurl;
           var data = {
               action:  'rp_check_user'
           };


           $.post(ajaxurl, data, function(result) {


               if(result.status == 'data') {

                   window.location.href = result.value;

                   return;

               }
               else if(result.status == 'error') {
                   alert(result.value);

                   FB.api("/me/permissions","DELETE",function(response){
                      // console.log(response); //gives true on app delete success


                   });
                   FB.logout(function(){
                       window.location.reload();
                   });
               }
               else if(result.status == 'success'){
                  $('#msg').html("<div>" + result.value + "</div><br><input type='button' id='btn_si' value='SI'><input type='button' id='btn_no' value='NO'>");
                       /*var div = $("<div>" + result.value + "</div>");
                       div.dialog({
                           title: "",
                           buttons: [
                               {
                                   text: "Si",
                                   click: function () {

                                       var data = {
                                           action: 'rp_save_user'
                                       };

                                       $.post(ajaxurl, data, function(response) {
                                           if (response.status == 'success')
                                               window.location.href = response.value;
                                           $('#msg').html("<div>" + result.value + "</div>");
                                       }, 'json');



                                   }
                               },
                               {
                                   text: "NO",
                                   click: function () {
                                       $('#msg').html('');
                                       FB.api("/me/permissions","DELETE",function(response){
                                           console.log(response); //gives true on app delete success

                                       });
                                   }
                               }
                           ]
                       });*/
                   return false;
               }
               else{
                   return;
               }

           }, 'json');
        });


        return;
    }

    function checkUserFacebook(){


        FB.api('/me', function(response) {


            //var ajaxurl = ajaxurl;
            var data = {
                action:  'rp_check_user_facebook',
                id_facebook: response.id,

            };


            $.post(ajaxurl, data, function(result) {

                return;

                if(result.status == 'success') {

                    //window.location.href = result.value;

                    return true;

                } else {
                    FB.api("/me/permissions","DELETE",function(response){
                        console.log(response); //gives true on app delete success

                    });
                    return false;
                }

            }, 'json');
        });

    }



    function logout(){
       alert('Hai effettuato il logout');
    }


    function rp_reset(){
        $('#rp_signup_form').children().val('');

    }

});