<?php
/**
* Definzione CPT Ristoranti Piceni
*/

add_action('init', 'rp_register_scheda_ristorante');

/**
 * Crea il CPT prodotti
 */
function rp_register_scheda_ristorante() {

    $rp_schede_labels = array(
        'name'               => __('Schede Locali'),
        'singular_name'      => __('Scheda Locale'),
        'add_new'            => __('Aggiungi Nuova'),
        'add_new_item'       => __('Nuova'),
        'edit_item'          => __('Modifica'),
        'new_item'           => __('Nuova'),
        'all_items'          => __('Elenco Schede Locali'),
        'view_item'          => __('Visualizza'),
        'search_items'       => __('Cerca'),
        'not_found'          => __('Scheda non trovato'),
        'not_found_in_trash' => __('Scheda non trovato nel cestino'),
    );

    $rp_schede_cpt = array(
        'labels'             => $rp_schede_labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'locali/%tipologia_locale%', 'with_front' => true),
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 4,
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'comments',
        ),
    );

    register_post_type('locali', $rp_schede_cpt);

    flush_rewrite_rules();

}

add_filter('post_type_link', 'custom_post_link', 1, 3);
function custom_post_link( $post_link, $id = 0 )
{

    $post = get_post($id);
    if ( is_object($post) && $post->post_type == 'locali' )
    {
        $terms = wp_get_object_terms($post->ID, 'tipologia');
        if ($terms)
        {
           //var_dump(str_replace("%tipologia_locale%", $terms[0]->slug, $post_link));
           // die();
           $post_link = str_replace("%tipologia_locale%", $terms[0]->slug, $post_link);

        }
    }
    flush_rewrite_rules();
    return $post_link;

}

add_filter( 'generate_rewrite_rules','my_insert_rewrite_rules' );
function my_insert_rewrite_rules( $wp_rewrite )
{
    $newrules = array( 'locali/(.+)/(.+)$' => 'index.php?locali='.$wp_rewrite->preg_index(2) );
    $newrules += array( 'locali$' => 'index.php?post_type=locali');
    $wp_rewrite->rules = $newrules + $wp_rewrite->rules;
}


/**
 * Inizio creazione meta box info prodotto
 */

/**
 * Box Info locali
 */
add_action( 'add_meta_boxes', 'rp_box_info_locali' );
/**
 * Aggiungo il meta box info scheda ristorante
 */
function rp_box_info_locali() {
    add_meta_box(
        'ristorante_id',
        __( 'Info scheda ristorante', 'localipiceni' ),
        'rp_print_box_info_locali',
        'locali',
        'advanced',
        'high'
    );
}

add_action( 'add_meta_boxes', 'rp_box_social' );
function rp_box_social() {
    add_meta_box(
        'ristorante_social_id',
        __( 'Social Account', 'rp' ),
        'rp_print_box_social',
        'locali',
        'advanced',
        'high'
    );
}

add_action( 'add_meta_boxes', 'rp_box_menu' );
function rp_box_menu() {
    add_meta_box(
        'ristorante_menu_id',
        __( 'Menu', 'rp' ),
        'rp_print_box_info_menu',
        'locali',
        'advanced',
        'high'
    );
}

function rp_print_box_info_menu( $post ) {
    $rp_value_info_menu = get_post_meta( $post->ID, 'rp_info_menu_saved', true);

    //wp_nonce_field( 'rp_scheda_nonce', 'nonce_scheda' );
    echo '<p><b><label for="rp_info_menu">';
    _e("Inserire il menu", 'rp' );
    echo '</label></b> ';

    wp_editor( $rp_value_info_menu, 'rp_info_menu', array('textarea_rows' => 40));
    echo '<br class="clear" /></p>';
}

function rp_print_box_info_locali( $post ) {
    $rp_value_scheda_indirizzo = get_post_meta( $post->ID, 'rp_scheda_indirizzo_saved', true);
    $rp_value_scheda_cap = get_post_meta( $post->ID, 'rp_scheda_cap_saved', true);
    $rp_value_scheda_citta = get_post_meta( $post->ID, 'rp_scheda_citta_saved', true);
    $rp_value_scheda_prov = get_post_meta( $post->ID, 'rp_scheda_prov_saved', true);
    $rp_value_scheda_tel = get_post_meta( $post->ID, 'rp_scheda_tel_saved', true);
    $rp_value_scheda_cel = get_post_meta( $post->ID, 'rp_scheda_cel_saved', true);
    $rp_value_scheda_fax = get_post_meta( $post->ID, 'rp_scheda_fax_saved', true);
    $rp_value_scheda_mail = get_post_meta( $post->ID, 'rp_scheda_mail_saved', true);
    $rp_value_scheda_sito = get_post_meta( $post->ID, 'rp_scheda_sito_saved', true);
    $rp_value_scheda_map_lat = get_post_meta($post->ID,'wp_geo_latitude',true);
    $rp_value_scheda_map_long  = get_post_meta($post->ID,'wp_geo_longitude',true);
    $rp_value_scheda_map_options  = get_post_meta( $post->ID, '_wp_geo_map_settings', true);
    $rp_value_scheda_sottoscritto = get_post_meta( $post->ID, 'rp_scheda_sottoscritto_saved', true);
    $rp_value_scheda_prenotazione = get_post_meta( $post->ID, 'rp_scheda_prenotazione_saved', true);
    $rp_value_scheda_gallery = get_post_meta( $post->ID, 'rp_scheda_gallery_saved', true);
    $rp_value_scheda_coperti_totali = get_post_meta( $post->ID, 'rp_scheda_coperti_totali_saved', true);
    $rp_value_scheda_coperti_estivi = get_post_meta( $post->ID, 'rp_scheda_coperti_estivi_saved', true);
    $rp_value_scheda_prezzo_medio_menu = get_post_meta( $post->ID, 'rp_scheda_prezzo_medio_menu_saved', true);
    $rp_value_scheda_chiusura_settimanale = get_post_meta( $post->ID, 'rp_scheda_chiusura_settimanale_saved', true);
    $rp_value_scheda_chiusura_per_ferie = get_post_meta( $post->ID, 'rp_scheda_chiusura_per_ferie_saved', true);

    wp_nonce_field( 'rp_scheda_nonce', 'nonce_scheda' );


    $checked ='';
    if ($rp_value_scheda_sottoscritto == 1){
        $checked = ' checked="checked"';

    }
    echo '<p><label for="rp_scheda_sottoscritto">';
    _e("Ristorante abbonato", 'rp' );
    echo '</label>';
    echo '<input name="rp_scheda_sottoscritto" id="rp_scheda_sottoscritto_id" value="1" type="checkbox" '.$checked.' /></p>';



    echo '<p><label for="rp_scheda_indirizzo">';
    _e("Indirizzo", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_indirizzo" id="rp_scheda_indirizzo_id" value="'.$rp_value_scheda_indirizzo.'"></p>';

    echo '<p><label for="rp_scheda_cap">';
    _e("Cap", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_cap" id="rp_scheda_cap_id" value="'.$rp_value_scheda_cap.'"></p>';

    echo '<p><label for="rp_scheda_citta">';
    _e("Citta", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_citta" id="rp_scheda_citta_id" value="'.$rp_value_scheda_citta.'"></p>';

    echo '<p><label for="rp_scheda_prov">';
    _e("Provincia", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_prov" id="rp_scheda_prov_id" value="'.$rp_value_scheda_prov.'"></p>';


    echo '<input type="button" class="button" value="Cerca sulla mappa" name="search_button_ristoranti" id="search_button_ristoranti_id">';


    echo '<p><label for="rp_scheda_tel">';
    _e("Telefono", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_tel" id="rp_scheda_tel_id" value="'.$rp_value_scheda_tel.'"></p>';

    echo '<p><label for="rp_scheda_cel">';
    _e("Cellulare", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_cel" id="rp_scheda_cel_id" value="'.$rp_value_scheda_cel.'"></p>';


    echo '<p><label for="rp_scheda_fax">';
    _e("Fax", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_fax" id="rp_scheda_fax_id" value="'.$rp_value_scheda_fax.'"></p>';

    $checked_pronotazione ='';
    if ($rp_value_scheda_prenotazione == 1){
        $checked_pronotazione = ' checked="checked"';
    }

    echo '<p><label for="rp_scheda_mail">';
    _e("E-Mail", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_mail" id="rp_scheda_mail_id" value="'.$rp_value_scheda_mail.'">';

    echo '<input name="rp_scheda_prenotazione" id="rp_scheda_prenotazione" value="1" type="checkbox" '.$checked_pronotazione.' />';
    echo '<label for="rp_scheda_prenotazione">';
    _e("Attivare l'area prenotazione", 'rp' );
    echo '</label></p>';

    echo '<p><label for="rp_scheda_sito">';
    _e("Sito web", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_sito" id="rp_scheda_sito_id" value="'.$rp_value_scheda_sito.'"></p>';

    echo '<p><label for="rp_scheda_coperti_totali">';
    _e("Coperti totali", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_coperti_totali" id="rp_scheda_coperti_totali_id" value="'.$rp_value_scheda_coperti_totali.'"></p>';

    echo '<p><label for="rp_scheda_coperti_estivi">';
    _e("Coperti estivi", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_coperti_estivi" id="rp_scheda_coperti_estivi_id" value="'.$rp_value_scheda_coperti_estivi.'"></p>';

    echo '<p><label for="rp_scheda_prezzo_medio_menu">';
    _e("Prezzo Medio Menu", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_prezzo_medio_menu" id="rp_scheda_prezzo_medio_menu_id" value="'.$rp_value_scheda_prezzo_medio_menu.'"></p>';

    echo '<p><label for="rp_scheda_chiusura_settimanale">';
    _e("Chiusura settimanale", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_chiusura_settimanale" id="rp_scheda_chiusura_settimanale" value="'.$rp_value_scheda_chiusura_settimanale.'"></p>';

    echo '<p><label for="rp_scheda_chiusura_per_ferie">';
    _e("Chiusura per ferie", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_chiusura_per_ferie" id="rp_scheda_chiusura_per_ferie" value="'.$rp_value_scheda_chiusura_per_ferie.'"></p>';


    echo '<input name="rp_scheda_lat" id="rp_scheda_lat_id" value="'.$rp_value_scheda_map_lat.'" type="hidden"></p>';
    echo '<input name="rp_scheda_long" id="rp_scheda_long_id" value="'.$rp_value_scheda_map_long.'"  type="hidden"></p>';
    echo '<input name="rp_scheda_zoom" id="rp_scheda_zoom_id" value="'.$rp_value_scheda_map_options['zoom'].'" type="hidden"></p>';
    echo '<input name="rp_scheda_centre" id="rp_scheda_centre_id" value="'.$rp_value_scheda_map_options['centre'].'" type="hidden"></p>';
    echo '<input name="rp_scheda_type" id="rp_scheda_type_id" value="'.$rp_value_scheda_map_options['type'].'" type="hidden"></p>';


    echo '<p><label for="rp_scheda_gallery">';
    _e("Galleria Immagini Associata: ", 'rp' );
    echo '</label> ';
    //echo '<input type="text" name="rp_scheda_gallery" id="rp_scheda_gallery_id" value="'.$rp_value_scheda_gallery.'" /></p>';
    rp_nextgen_gallery_list();
    echo '<p><a href="'.admin_url().'/admin.php?page=nggallery-add-gallery">Crea una nuova galleria</a></p>';

}

function rp_print_box_social( $post ) {
    $rp_value_scheda_facebook = get_post_meta( $post->ID, 'rp_scheda_facebook_saved', true);
    $rp_value_scheda_twitter = get_post_meta( $post->ID, 'rp_scheda_twitter_saved', true);
    $rp_value_scheda_google = get_post_meta( $post->ID, 'rp_scheda_google_saved', true);
    $rp_value_scheda_youtube = get_post_meta( $post->ID, 'rp_scheda_youtube_saved', true);
    $rp_value_scheda_instagram = get_post_meta( $post->ID, 'rp_scheda_instagram_saved', true);
    $rp_value_scheda_skype = get_post_meta( $post->ID, 'rp_scheda_skype_saved', true);

    echo '<p><label for="rp_scheda_facebook">';
    _e("Account Facebook", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_facebook" id="rp_scheda_facebook_id" value="'.$rp_value_scheda_facebook.'"></p>';

    echo '<p><label for="rp_scheda_twitter">';
    _e("Account twitter", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_twitter" id="rp_scheda_twitter_id" value="'.$rp_value_scheda_twitter.'"></p>';

    echo '<p><label for="rp_scheda_google">';
    _e("Account Google+", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_google" id="rp_scheda_google_id" value="'.$rp_value_scheda_google.'"></p>';

    echo '<p><label for="rp_scheda_youtube">';
    _e("Account Youtube", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_youtube" id="rp_scheda_youtube_id" value="'.$rp_value_scheda_youtube.'"></p>';

    echo '<p><label for="rp_scheda_skype">';
    _e("Account Skype", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_skype" id="rp_scheda_skype_id" value="'.$rp_value_scheda_skype.'"></p>';

    echo '<p><label for="rp_scheda_instagram">';
    _e("Account Instagram", 'rp' );
    echo '</label> ';
    echo '<input type="text" name="rp_scheda_instagram" id="rp_scheda_instagram_id" value="'.$rp_value_scheda_instagram.'"></p>';

    wp_nonce_field( 'rp_scheda_nonce', 'nonce_scheda' );

    //var_dump(get_post_meta($post->ID,'_wp_geo_marker',true));
}


add_action( 'save_post', 'rp_save_scheda_locali' );

function rp_save_scheda_locali( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;


    if ( !wp_verify_nonce( $_POST['nonce_scheda'], 'rp_scheda_nonce' ))
        return;

    if (isset($_POST['rp_scheda_indirizzo'])) {
    $rp_scheda_indirizzo = $_POST['rp_scheda_indirizzo'];
    }
    if (isset($_POST['rp_scheda_cap'])) {
    $rp_scheda_cap = $_POST['rp_scheda_cap'];
    }
    if (isset($_POST['rp_scheda_citta'])) {
    $rp_scheda_citta = $_POST['rp_scheda_citta'];
    }
    if (isset($_POST['rp_scheda_prov'])) {
    $rp_scheda_provincia = $_POST['rp_scheda_prov'];
    }
    if (isset($_POST['rp_scheda_tel'])) {
    $rp_scheda_tel = $_POST['rp_scheda_tel'];
    }
    if (isset($_POST['rp_scheda_cel'])) {
    $rp_scheda_cel = $_POST['rp_scheda_cel'];
    }
    if (isset($_POST['rp_scheda_fax'])) {
    $rp_scheda_fax = $_POST['rp_scheda_fax'];
    }
    if (isset($_POST['rp_scheda_mail'])) {
    $rp_scheda_mail = $_POST['rp_scheda_mail'];
    }
    if (isset($_POST['rp_scheda_sito'])) {
    $rp_scheda_sito = $_POST['rp_scheda_sito'];
    }
    if (isset($_POST['rp_scheda_social_account'])) {
    $rp_scheda_social_account = $_POST['rp_scheda_social_account'];
    }
    if (isset($_POST['rp_scheda_lat'])) {
    $rp_scheda_lat = $_POST['rp_scheda_lat'];
    }
    if (isset($_POST['rp_scheda_long'])) {
    $rp_scheda_long = $_POST['rp_scheda_long'];
    }
    if (isset($_POST['rp_scheda_coperti_totali'])) {
    $rp_scheda_coperti_totali = $_POST['rp_scheda_coperti_totali'];
    }
    if (isset($_POST['rp_scheda_coperti_estivi'])) {
    $rp_scheda_coperti_estivi = $_POST['rp_scheda_coperti_estivi'];
    }
    if (isset($_POST['rp_scheda_prezzo_medio_menu'])) {
    $rp_scheda_prezzo_medio_menu = $_POST['rp_scheda_prezzo_medio_menu'];
    }
    if (isset($_POST['rp_scheda_chiusura_settimanale'])) {
    $rp_scheda_chiusura_settimanale = $_POST['rp_scheda_chiusura_settimanale'];
    }
    if (isset($_POST['rp_scheda_chiusura_per_ferie'])) {
    $rp_scheda_chiusura_per_ferie = $_POST['rp_scheda_chiusura_per_ferie'];
    }

    $rp_scheda_map_options = array(
        'zoom' => $_POST['rp_scheda_zoom'],
        'type' => $_POST['rp_scheda_type'],
        'centre' => $_POST['rp_scheda_centre']
    );

    if (isset($_POST['wp_geo_marker'])){
    $rp_wp_geo_marker = $_POST['wp_geo_marker'];
    }

    $rp_scheda_sottoscritto = $_POST['rp_scheda_sottoscritto'];

    if (isset($_POST['rp_scheda_prenotazione'])){
    $rp_scheda_prenotazione = $_POST['rp_scheda_prenotazione'];
    }
    if (isset($_POST['rp_scheda_facebook'])){
    $rp_scheda_facebook = $_POST['rp_scheda_facebook'];
    }
    if (isset($_POST['rp_scheda_twitter'])){
    $rp_scheda_twitter = $_POST['rp_scheda_twitter'];
    }
    if (isset($_POST['rp_scheda_skype'])){
    $rp_scheda_skype = $_POST['rp_scheda_skype'];
    }
    if (isset($_POST['rp_scheda_google'])){
    $rp_scheda_google = $_POST['rp_scheda_google'];
    }
    if (isset($_POST['rp_scheda_instagram'])){
    $rp_scheda_instagram = $_POST['rp_scheda_instagram'];
    }
    if (isset($_POST['rp_scheda_youtube'])){
    $rp_scheda_youtube = $_POST['rp_scheda_youtube'];
    }
    if (isset($_POST['rp_info_menu'])){
    $rp_info_menu = $_POST['rp_info_menu'];
    }
    if (isset($_POST['rp_ristoranti_select_gallery'])){
    $rp_scheda_gallery = $_POST['rp_ristoranti_select_gallery'];
    }



    update_post_meta($post_id,'rp_scheda_sottoscritto_saved', $rp_scheda_sottoscritto);
    update_post_meta($post_id,'rp_scheda_prenotazione_saved', $rp_scheda_prenotazione);
    update_post_meta($post_id,'rp_scheda_indirizzo_saved',$rp_scheda_indirizzo);
    update_post_meta($post_id,'rp_scheda_cap_saved',$rp_scheda_cap);
    update_post_meta($post_id,'rp_scheda_citta_saved',$rp_scheda_citta);
    update_post_meta($post_id,'rp_scheda_prov_saved',$rp_scheda_provincia);
    update_post_meta($post_id,'rp_scheda_tel_saved',$rp_scheda_tel);
    update_post_meta($post_id,'rp_scheda_cel_saved',$rp_scheda_cel);
    update_post_meta($post_id,'rp_scheda_fax_saved',$rp_scheda_fax);
    update_post_meta($post_id,'rp_scheda_mail_saved',$rp_scheda_mail);
    update_post_meta($post_id,'rp_scheda_sito_saved',$rp_scheda_sito);
    update_post_meta($post_id,'rp_scheda_social_account_saved',$rp_scheda_social_account);
    update_post_meta($post_id,'wp_geo_latitude',$rp_scheda_lat);
    update_post_meta($post_id,'wp_geo_longitude',$rp_scheda_long);
    update_post_meta($post_id,'wp_geo_map_settings',$rp_scheda_map_options);


    //Salva il marker di default per il locale a seconda della termine 'Tipologia' associato, non occorre testare nulla
    $post_terms = get_the_terms($post_id,'tipologia');
    if( str_replace('-','',$post_terms[0]->slug) != $rp_wp_geo_marker ) //Aggiorno il tutto solo quando ho una modifica (cambio di tipologia o al primo salvataggio)
        update_post_meta($post_id,'wp_geo_marker', str_replace('-','',$post_terms[0]->slug) ); //Aggiorno il marker con quello avente lo stesso slug del termine (vedi funzione apposito nello spazio sottostante)
        update_post_meta($post_id,'rp_scheda_sottoscritto_saved',$rp_scheda_sottoscritto);
        update_post_meta($post_id,'rp_scheda_coperti_totali_saved',$rp_scheda_coperti_totali);
        update_post_meta($post_id,'rp_scheda_coperti_estivi_saved',$rp_scheda_coperti_estivi);
        update_post_meta($post_id,'rp_scheda_prezzo_medio_menu_saved',$rp_scheda_prezzo_medio_menu);
        update_post_meta($post_id,'rp_scheda_chiusura_settimanale_saved',$rp_scheda_chiusura_settimanale);
        update_post_meta($post_id,'rp_scheda_chiusura_per_ferie_saved',$rp_scheda_chiusura_per_ferie);

    // save gallery

        update_post_meta($post_id,'rp_scheda_gallery',$rp_scheda_gallery);

    //save dati social

        update_post_meta($post_id,'rp_scheda_facebook_saved',$rp_scheda_facebook);
        update_post_meta($post_id,'rp_scheda_twitter_saved',$rp_scheda_twitter);
        update_post_meta($post_id,'rp_scheda_youtube_saved',$rp_scheda_youtube);
        update_post_meta($post_id,'rp_scheda_skype_saved',$rp_scheda_skype);
        update_post_meta($post_id,'rp_scheda_google_saved',$rp_scheda_google);
        update_post_meta($post_id,'rp_scheda_instagram_saved',$rp_scheda_instagram);

    //save menu

        update_post_meta($post_id,'rp_info_menu_saved',$rp_info_menu);

}

/**
 * TAXONOMIES SECTIONS
 */

add_action( 'init', 'create_locali_taxonomies', 0 );
//creo una tassonomia per il CTP scheda ristorante
function create_locali_taxonomies()
{

    // tassonomia tipologia prodotto

    $labels = array(
        'name' => 'Tipologie',
        'singular_name' => 'Tipologia',
        'search_items' => 'Cerca',
        'popular_items' =>  'Tipologie Popolari',
        'all_items' => 'Tutte le Tipologie' ,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Modifica',
        'update_item' => 'Aggiorna',
        'add_new_item' => 'Nuovo',
        'new_item_name' => 'Nuovo nome',
        'separate_items_with_commas' => 'Separare le tipologie con le virgole',
        'add_or_remove_items' => 'Aggiungi o rimuovi tipologie',
        'choose_from_most_used' => 'Scegli tra le tipologie in uso',
        'menu_name' => 'Tipologie locali',
    );

    register_taxonomy('tipologia','locali',array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'tipologia', 'with_front' => true, 'hierarchical' => true ),
    ));


    flush_rewrite_rules();

}

add_action( 'init', 'create_tipo_di_cucina_taxonomies', 0 );
function create_tipo_di_cucina_taxonomies()
{

    // tassonomia tipologia tipo cucina

    $labels = array(
        'name' => 'Tipi di Cucina',
        'singular_name' => 'Tipo di Cucina',
        'search_items' => 'Cerca Tipo Cucina',
        'popular_items' =>  'Tipo cucina Popolari',
        'all_items' => 'Tutte le Tipo Cucina' ,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Modifica Tipo Cucina',
        'update_item' => 'Aggiorna Tipo Cucina',
        'add_new_item' => 'Nuovo Tipo Cucina',
        'new_item_name' => 'Nuovo nome Tipo Cucina',
        'separate_items_with_commas' => 'Separare Tipo Cucina con le virgole',
        'add_or_remove_items' => 'Aggiungi o rimuovi Tipo Cucina',
        'choose_from_most_used' => 'Scegli tra i Tipi di Cucina in uso',
        'menu_name' => 'Tipo Cucina',
    );

    register_taxonomy('tipo_cucina','locali',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'tipo-cucina' ),
    ));


    flush_rewrite_rules();
}

add_action( 'init', 'create_ambiente_taxonomies', 0 );
function create_ambiente_taxonomies()
{

    // tassonomia tipologia ambiente

    $labels = array(
        'name' => 'Ambienti',
        'singular_name' => 'Ambiente',
        'search_items' => 'Cerca Ambiente',
        'popular_items' =>  'Ambienti Popolari',
        'all_items' => 'Tutte gli Ambienti' ,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Modifica Ambiente',
        'update_item' => 'Aggiorna Ambiente',
        'add_new_item' => 'Nuovo Ambiente',
        'new_item_name' => 'Nuovo nome Ambiente',
        'separate_items_with_commas' => 'Separare Ambiente con le virgole',
        'add_or_remove_items' => 'Aggiungi o rimuovi Ambiente',
        'choose_from_most_used' => 'Scegli tra gli Ambienti in uso',
        'menu_name' => 'Ambiente',
    );

    register_taxonomy('ambiente','locali',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'ambiente' ),
    ));


    flush_rewrite_rules();

}

add_action( 'init', 'create_servizi_taxonomies', 0 );
function create_servizi_taxonomies()
{

    // tassonomia tipologia ambiente

    $labels = array(
        'name' => 'Servizi',
        'singular_name' => 'Servizio',
        'search_items' => 'Cerca Servizio',
        'popular_items' =>  'Servizi Popolari',
        'all_items' => 'Tutte i Servizi' ,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Modifica Servizio',
        'update_item' => 'Aggiorna Servizio',
        'add_new_item' => 'Nuovo Servizio',
        'new_item_name' => 'Nuovo nome Servizio',
        'separate_items_with_commas' => 'Separare Servizio con le virgole',
        'add_or_remove_items' => 'Aggiungi o rimuovi Servizio',
        'choose_from_most_used' => 'Scegli tra i Servizi in uso',
        'menu_name' => 'Servizi',
    );

    register_taxonomy('servizio','locali',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'servizio' ),
    ));

    flush_rewrite_rules();

}

add_action('rp_search_extra_fields','rp_get_tipologia_taxonomies_list');
function rp_get_tipologia_taxonomies_list(){
    $terms = get_terms("tipologia", array(
        'orderby'    => 'count',
        'hide_empty' => 0) );
    $count = count($terms);
    $items = 0;
    if ( $count > 0 ){
        echo '<select name="rp_search_tipologia" id="rp_search_tipologia_id">';
        foreach ( $terms as $term ) {
            if ( $items == 0) echo '<option value=""> -- Seleziona Tipologia</option>';
            echo '<option value="'. $term->term_id .'">' . $term->name . '</option>';
            $items ++;
        }
        echo "</select>";
    }
}

add_action('rp_search_extra_fields','rp_get_localita_list');
function rp_get_localita_list(){
    global $wpdb;

    $mykey_values = $wpdb->get_col("SELECT meta_value
	FROM $wpdb->postmeta WHERE meta_key = 'rp_scheda_citta_saved' GROUP BY meta_value" );

    $count = count($mykey_values);
    $items = 0;

    if ( $count > 0 ){
        echo '<select name="rp_search_localita" id="rp_search_localita_id">';
        foreach ( $mykey_values as $values ) {
            if ( $items == 0) echo '<option value=""> -- Seleziona Localit&aacute;</option>';
            echo '<option value="'. $values .'">' . $values . '</option>';
            $items++;
        }
        echo "</select>";
    }
}

/**
 * NEXT GEN GALLERY CUSTOMIZATIONS
 **/
function rp_nextgen_gallery_list(){
    global $nggdb, $post;

    $selected = get_post_meta($post->ID,'rp_scheda_gallery',true);
    $sel = "";
    $count = 0;

    if ( is_object($nggdb) ):
        $galleries = $nggdb->find_all_galleries();
        echo '<select class="gallery-list" name="rp_ristoranti_select_gallery" id="rp_ristoranti_select_gallery_id">';
        foreach($galleries as $gallery):
            if ($count == 0)
                echo '<option value="-1">'. __("Seleziona la galleria associata","rp") .'</option>';
            if ( $selected && ($gallery->gid == $selected) )
                $sel = ' selected="selected"';
            echo '<option'. $sel .' value="' . $gallery->gid . '">'. $gallery->name .'</option>';
            $sel = "";
            $count++;
        endforeach;
        echo '</select>';
    else:
        echo '<span>Installare il plugin NextGen Gallery per le gallerie</span>';
    endif;
}


/**
 * GEO MAP CUSTOMIZATION
 */


add_filter( 'wpgeo_point_title', 'rp_wpgeo_point_title' );
add_filter( 'wpgeo_markers', 'rp_terms_wpgeo_markers' );

/**
 * Sovrascrive le informazioni del pin Ristorante
 * @param $title
 * @param $post_id
 * @return string
 */
function rp_wpgeo_point_title( $title, $post_id ) {
    // Add a coordinates to the point title
    $name  = get_the_title($post_id);
    $address = get_post_meta($post_id, 'rp_scheda_indirizzo_saved', true);
    return $name.' - '. $address;
}

/**
 * @param $markers
 * @return array
 */
function rp_terms_wpgeo_markers( $markers ) {

    $args = array(
        'hide_empty' => 0
    );
    $terms = get_terms('tipologia', $args);

    if( $terms ):
        foreach ($terms as $term):
            $markers[] = new WPGeo_Marker(
                str_replace('-','',$term->slug), // Identifier
                $term->name, // Icon name
                'Marker per ' . $term->name, // Icon description
                20, 34, 10, 34, // width, height, anchorx, anchor y
                RP_THEME_IMAGES_URL . '/pin-map/pin-'. str_replace('-','',$term->slug) .'.png', // Icon image
                RP_THEME_IMAGES_URL . '/pin-map/large-marker-shadow.png' // Icon shadow image
            );

        endforeach;
    endif;
    return $markers;


}

/**
 * CUSTOM COLUMNS
 */

/**
 * Colonne da mostrare
 */
add_filter( 'manage_edit-locali_columns', 'rp_edit_locali_columns' ) ;
function rp_edit_locali_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Nome Locale' ),
        'tipologia' => __( 'Tipologia' ),
        'indirizzo' => __( 'Indirizzo' ),
        'registrato' => __( 'Registrato' )
    );

    return $columns;
}

/**
 * Aggiungo contenuto alle colonne
 */
add_action( 'manage_locali_posts_custom_column', 'rp_manage_locali_columns', 10, 2 );
function rp_manage_locali_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        case 'indirizzo' :

            /* Get the post meta. */
            $addr = get_post_meta($post_id,'rp_scheda_indirizzo_saved', true);

            if ( empty( $addr ) )
                echo __( 'Non assegnato' );

            else
                echo $addr;

            break;

        case 'tipologia' :

            /* Get the genres for the post. */
            $terms = get_the_terms( $post_id, 'tipologia' );

            /* If terms were found. */
            if ( !empty( $terms ) ) {

                $out = array();

                foreach ( $terms as $term ) {
                    $out[] = sprintf( '<a href="%s">%s</a>',
                        //Costruisco la URL del link sulla colonna per filtrare per categoria (e.g. tutte le pizzerie, etc...)
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'tipologia' => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'tipologia', 'display' ) )
                    );
                }

                echo join( ', ', $out );
            }

            else {
                _e( 'Nessuna tipologia' );
            }

            break;
        case 'registrato' :
            $reg = get_post_meta($post_id,'rp_scheda_sottoscritto_saved', true);

            if ( empty( $reg ) )
                echo __( 'Non assegnato' );

            else
                echo $reg == 1 ? _e("Abilitato",'rp') : _e("Non abilitato",'rp');
            break;

        default :
            break;
    }
}

/**
 * Imposto quali colonne sono Ordinabili
 */
add_filter( 'manage_edit-locali_sortable_columns', 'rp_locali_sortable_columns' );
function rp_locali_sortable_columns( $columns ) {

    $columns['registrato'] = 'registrato';

    return $columns;
}

/**
 * Imposto i criteri di ordinameto
 */
add_action( 'load-edit.php', 'my_edit_locali_load' );
function rpo_edit_locali_load() {
    add_filter( 'request', 'rp_sort_locali' );
}

function rp_sort_locali( $vars ) {

    if ( isset( $vars['post_type'] ) && 'locali' == $vars['post_type'] ) {

        if ( isset( $vars['orderby'] ) && 'registrato' == $vars['orderby'] ) {

            /* Merge the query vars with our custom variables. */
            $vars = array_merge(
                $vars,
                array(
                    'meta_key' => 'rp_scheda_sottoscritto_saved',
                    'orderby' => 'ASC'
                )
            );
        }
    }

    return $vars;
}
?>