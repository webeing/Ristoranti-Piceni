<?php
//definizione delle costanti

define("RP_THEME_IMAGES_URL", get_bloginfo('template_url') . "/images");

define("RP_EVENTI_SPECIALI_ID", "6");
define("RP_EVENTI_TERRITORIO_ID", "29");

define("RP_REGISTER_URL_SLUG","registrazione");
define("RP_LOGIN_URL_SLUG","login");

define("RP_FACEBOOK_APP_ID", '328362657261088');
define("RP_FACEBOOK_APP_SECRET",'770dd7b4dd4e7e9957d97f4870f47fe8');

define("SLUG_EVENTI_SPECIALI", 'serate-speciali');
define("SLUG_EVENTI_NEL_TERRITORIO",'eventi-nel-territorio');
/**
 * Facebook
 */
require_once TEMPLATEPATH . "/includes/facebook_api/base_facebook.php";
include_once TEMPLATEPATH . "/includes/facebook_api/facebook.php";
global $facebook;

$facebook = new Facebook(array(
    'appId'  => RP_FACEBOOK_APP_ID,
    'secret' => RP_FACEBOOK_APP_SECRET,
));
?>