/**
 * Created with JetBrains PhpStorm.
 * User: Webeing.net
 * Date: 30/10/12
 * Time: 13.40
 * To change this template use File | Settings | File Templates.
 */

/**
 * LA VARIABILE rp_ajax_data è PRESENTE SEMPRE NEL FILE GRAZIE ALLA CHIAMATA WP_LOCALIZE_SCRIPT IN FUNCTION.PHP
 */

jQuery(function($){

    var ajaxurl = rp_ajax_data.ajaxurl;
    var template_url = rp_ajax_data.template_url;

    /**
     * click modifica password in content-profile
     */
    $("body.author #submitbtn").click(function() {

        $('#result').html('<img src="' + template_url + '/images/loader.gif" class="loader" />').fadeIn();


        var data = {
            action: 'rp_nuova_password',
            password: $('#rp_nuova_password').val(),
            user_id: $('#rp_user_id').val()
            };


            $.post(ajaxurl, data, function(response) {

                $('.loader').remove();
                $('<div class="' + response.status + '">').html(response.value).appendTo('div#result').hide().fadeIn('slow');
                }, 'json');

            return false;


    });


    /**
     * click login in page-login
     */


    $("body.page-template-page-login-php #submitbtn").click(function() {

        $('#result').html('<img src="' + template_url + '/images/loader.gif" class="loader" />').fadeIn();


        var data = {
            action: 'rp_login',
            username: $('input[name="rp_login_username"]').val(),
            password: $('input[name="rp_login_password"]').val(),
            rememberme: $('input[name="rp_login_rememberme"]').val()

        };


        $.post(ajaxurl, data, function(response) {
            if (response.status == 'data')
                window.location.href = response.value;
            else{
                $('.loader').remove();
                $('<div class="' + response.status + '">').html(response.value).appendTo('div#result').hide().fadeIn('slow');
            }
        }, 'json');
        return false;



    });

    $("body.page-template-page-registrazione-php #submitbtn").click(function() {

        $('#result').html('<img src="' + template_url + '/images/loader.gif" class="loader" />').fadeIn();

        var data = {
            action: 'rp_registrazione',
            username: $('#rp_username').val(),
            email: $('#rp_email').val(),
            idfacebook : $('input[name="rp_idfacebook"]').val(),
            nonce: $('input[name="rp_registration_nonce"]').val()

        };


        $.post(ajaxurl, data, function(response) {
            $('.loader').remove();
            $('<div class="' + response.status + '">').html(response.value).appendTo('div#result').hide().fadeIn('slow');
        }, 'json');

        return false;

    });
    /**
     * logout wp
     */
    $("#logout_wp").click(function() {

        $('#result_logout').html('<img src="' + template_url + '/images/loader.gif" class="loader" />').fadeIn();

        var data = {
            action: 'rp_logout'
        };


        $.post(ajaxurl, data, function(response) {
            if (response.status == 'success')
                window.location.href = response.value;
            $('.loader').remove();
            $('<div class="' + response.status + '">').html(response.value).appendTo('div#result_logout').hide().fadeIn('slow');

        }, 'json');

        return false;

    });


    $("#btn_si").live('click',function() {

        var data = {
            action: 'rp_save_user'
        };

        $.post(ajaxurl, data, function(response) {
            if (response.status == 'success')
            $('#msg').html("<div>" + response.value + "</div>");
        }, 'json');
        $('.loader').remove();
        return false;

    });

    $("#btn_no").live('click',function() {

        $('#msg').html('');
        FB.api("/me/permissions","DELETE",function(response){
            console.log(response); //gives true on app delete success

        });
        $('.loader').remove();
        return false;

    });
    /**
     * click sul tasto resetta password
     */
    $("#recoverbtn").click(function() {

        $('#result_recover').html('<img src="' + template_url + '/images/loader.gif" class="loader" />').fadeIn();

        var data = {
            action: 'rp_recupera_psw',
            email: $('input[name="rp_recover_psw"]').val()


        };

        $.post(ajaxurl, data, function(response) {
            $('.loader').remove();
            $('<div class="' + response.status + '">').html(response.value).appendTo('div#result_recover').hide().fadeIn('slow');
        }, 'json');

        return false;

    });
});