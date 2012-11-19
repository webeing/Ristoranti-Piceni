<?php
/**
 * Funzioni Webeing.net per il sito ristoranti_piceni
 */
add_action('init', 'rp_register_event');
/**
 * Crea il CPT per gli eventi
 */
function rp_register_event() {

    $rp_event_labels = array(
        'name'               => __('Eventi','rp'),
        'singular_name'      => __('Evento','rp'),
        'add_new'            => __('Aggiungi Evento','rp'),
        'add_new_item'       => __('Nuova Evento','rp'),
        'edit_item'          => __('Modifica Evento','rp'),
        'new_item'           => __('Nuovo Evento','rp'),
        'all_items'          => __('Elenco Eventi','rp'),
        'view_item'          => __('Visualizza Evento','rp'),
        'search_items'       => __('Cerca Eventi','rp'),
        'not_found'          => __('Evento non trovato','rp'),
        'not_found_in_trash' => __('Evento non trovato nel cestino','rp'),
    );

    $rp_event_cpt = array(
        'labels'             => $rp_event_labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'eventi/%categorie%', 'with_front' => false),
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array(
            'title',
            'editor',
            'thumbnail'
        ),
    );

    register_post_type('rp_eventi', $rp_event_cpt);

    flush_rewrite_rules();

}


add_filter('post_type_link', 'rp_eventi_custom_post_link', 1, 3);
function rp_eventi_custom_post_link( $post_link, $id = 0 )
{

    $post = get_post($id);
    if ( is_object($post) && $post->post_type == 'rp_eventi' )
    {
        $terms = wp_get_object_terms($post->ID, 'categorie_evento');
        if ($terms)
        {
            //var_dump(str_replace("%tipologia_locale%", $terms[0]->slug, $post_link)); die();
            $post_link = str_replace("%categorie%", $terms[0]->slug, $post_link);
        }
    }
    flush_rewrite_rules();
    return $post_link;

}


add_filter( 'generate_rewrite_rules','rp_eventi_rewrite_rules' );
function rp_eventi_rewrite_rules( $wp_rewrite )
{
    $newrules = array( 'eventi/(.+)/(.+)$' => 'index.php?rp_eventi='.$wp_rewrite->preg_index(2) );
    $newrules += array( 'eventi$' => 'index.php?post_type=rp_eventi');
    $wp_rewrite->rules = $newrules + $wp_rewrite->rules;
}
/**
 * Inizio creazione meta box
 */

add_action( 'add_meta_boxes', 'rp_add_custom_box_event' );
add_action( 'save_post', 'rp_save_event', 99 );

/**
 * Aggiungo il meta box link
 */
function rp_add_custom_box_event() {
    add_meta_box(
        'event_id',
        __( 'Informazioni evento', 'rp' ),
        'rp_print_custom_box_event',
        'rp_eventi',
        'advanced',
        'high'
    );

}

/**
 * Stampo il box link dello slider
 */

function rp_print_custom_box_event( $post ) {

    $rp_value_start_datetime = get_post_meta( $post->ID, 'rp_start_datetime_saved', true);
    $rp_value_end_datetime = get_post_meta( $post->ID, 'rp_end_datetime_saved', true);
    $rp_value_partner_restaurant = get_post_meta( $post->ID, 'rp_partner_restaurant_saved', true);
    $rp_value_check_restaurant_location = get_post_meta( $post->ID, 'rp_check_restaurant_location_saved', true);
    $rp_value_evento_indirizzo = get_post_meta( $post->ID, 'rp_evento_indirizzo_saved', true);
    $rp_value_evento_cap = get_post_meta( $post->ID, 'rp_evento_cap_saved', true);
    $rp_value_evento_citta = get_post_meta( $post->ID, 'rp_evento_citta_saved', true);
    $rp_value_evento_prov = get_post_meta( $post->ID, 'rp_evento_prov_saved', true);

    wp_nonce_field( 'rp_event_nonce', 'nonce_event' );

    $checked ='';
    if ($rp_value_check_restaurant_location == 1){
        $checked = ' checked="checked"';

    }


    echo '<p><label for="rp_start_datetime">';
    _e("Inizio Evento", 'rp_start_datetime' );
    echo '</label> ';
    echo '<input type="text" class="regular-text" name="rp_start_datetime" id="rp_start_datetime_id" value="'.$rp_value_start_datetime.'" />';


    echo '<label for="rp_end_datetime">';
    _e("Fine Evento", 'rp_end_datetime' );
    echo '</label> ';
    echo '<input type="text" class="regular-text" name="rp_end_datetime" id="rp_end_datetime_id" value="'.$rp_value_end_datetime.'" /></p>';

    $args = array(
        'post_type' => 'locali',
        'order'=> 'ASC',
        'orderby' => 'title',
        'numberposts' => -1
    );

    $rp_ristoranti = get_posts( $args );
    echo '<p><label for="rp_partner_restaurant">';
    _e("Ristorante associato all'evento", 'rp_partner_restaurant' );
    echo '</label>';
    echo '<select name="rp_partner_restaurant">';

    $count = 0;
    $selected = ' selected="selected"';
    foreach( $rp_ristoranti as $rp_ristorante ) :


        $rp_ristorante = get_object_vars($rp_ristorante);

        if ($count == 0){
            $sel = ($rp_ristorante["ID"] == $rp_value_partner_restaurant) ?  $selected : "";

            echo '<option value="-1"'. $sel .'>Scegli un ristorante</option>';
        }

        $sel = ($rp_ristorante["ID"] == $rp_value_partner_restaurant) ?  $selected : "";
        echo '<option'. $sel . ' value="' . $rp_ristorante["ID"] . '">' . $rp_ristorante['post_title'].'</option>';

        $count++;

        $rp_scheda_ristorante_lat = get_post_meta($rp_ristorante['ID'],'wp_geo_latitude',true);
        $rp_scheda_ristorante_long = get_post_meta($rp_ristorante['ID'],'wp_geo_longitude',true);
        $rp_scheda_ristorante_map_options = get_post_meta( $rp_ristorante['ID'], 'wp_geo_map_settings', true);


    endforeach;

    echo '</select>';
    echo '<input type="hidden" name="rp_scheda_ristorante_lat" id="rp_scheda_ristorante_lat_id" value='.$rp_scheda_ristorante_lat.' /></p>';
    echo '<input type="hidden" name="rp_scheda_ristorante_long" id="rp_scheda_ristorante_long_id" value='.$rp_scheda_ristorante_long.'  /></p>';
    echo '<input type="hidden" name="rp_scheda_ristorante_zoom" id="rp_scheda_ristorante_zoom_id" value='.$rp_scheda_ristorante_map_options['zoom'].'  /></p>';
    echo '<input type="hidden" name="rp_scheda_ristorante_centre" id="rp_scheda_ristorante_centre_id" value='.$rp_scheda_ristorante_map_options['centre'].'   /></p>';
    echo '<input type="hidden" name="rp_scheda_ristorante_type" id="rp_scheda_ristorante_type_id" value='.$rp_scheda_ristorante_map_options['type'].'  /></p>';


    echo '<p><label for="rp_check_restaurant_location">';
    _e("Usa la location del ristorante", 'rp_check_restaurant_location' );
    echo '</label>';
    echo '<input  class="regular-text" name="rp_check_restaurant_location" id="rp_check_restaurant_location_id" value="1" type="checkbox" '.$checked.' /></p>';

    echo '<p><label for="rp_evento_indirizzo">';
    _e("Indirizzo", 'rp_evento_indirizzo' );
    echo '</label> ';
    echo '<input  class="regular-text" type="text" name="rp_evento_indirizzo" id="rp_evento_indirizzo_id" value="'.$rp_value_evento_indirizzo.'" /></p>';

    echo '<p><label for="rp_evento_cap">';
    _e("Cap", 'rp_evento_cap' );
    echo '</label> ';
    echo '<input class="regular-text" type="text" name="rp_evento_cap" id="rp_evento_cap_id" value="'.$rp_value_evento_cap.'" /></p>';

    echo '<p><label for="rp_evento_citta">';
    _e("Citta", 'rp_evento_citta' );
    echo '</label> ';
    echo '<input class="regular-text" type="text" name="rp_evento_citta" id="rp_evento_citta_id" value="'.$rp_value_evento_citta.'" /></p>';

    echo '<p><label for="rp_evento_prov">';
    _e("Provincia", 'rp_evento_prov' );
    echo '</label> ';
    echo '<input  class="regular-text" type="text" name="rp_evento_prov" id="rp_evento_prov_id" value="'.$rp_value_evento_prov.'" /></p>';
    echo '<input type="button" class="button" value="Cerca" name="search_button_event" id="search_button_evento_id">';

}

/**
 * Salvataggio ctp eventi
 */
function rp_save_event( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;


    if ( !wp_verify_nonce( $_POST['nonce_event'], 'rp_event_nonce' ))
        return;

    //calcolo per la data attuale
    $date = date("d-m-Y H:i:s");
    $currentTime = time($date);
    $timeAfterTwoHour = $currentTime+(60*60)*2;
    if(empty($_POST['rp_start_datetime'])){
        $rp_start_datetime = date("d/m/Y H:i:s",$timeAfterTwoHour);
    } else {
        $rp_start_datetime = $_POST['rp_start_datetime'];

    }

    if(empty($_POST['rp_end_datetime'])){
        $rp_start_datetime1 = explode(" ", $rp_start_datetime);
        $rp_start_datetime2 = explode("/", $rp_start_datetime1[0]);
        $rp_end_datetime = $rp_start_datetime2[0] . '/' . $rp_start_datetime2[1] . '/' . $rp_start_datetime2[2] . ' ' . '23:59:59';

    } else {
        $rp_end_datetime = $_POST['rp_end_datetime'];

    }

    if(isset($_POST['rp_partner_restaurant'])){
    $rp_partner_restaurant = $_POST['rp_partner_restaurant'];
    }
    if(isset($_POST['rp_check_restaurant_location'])){
    $rp_check_restaurant_location = $_POST['rp_check_restaurant_location'];
    }
    if(isset($_POST['rp_evento_indirizzo'])){
    $rp_evento_indirizzo = $_POST['rp_evento_indirizzo'];
    }
    if(isset($_POST['rp_evento_cap'])){
    $rp_evento_cap = $_POST['rp_evento_cap'];
    }
    if(isset($_POST['rp_evento_citta'])){
    $rp_evento_citta = $_POST['rp_evento_citta'];
    }
    if(isset($_POST['rp_evento_prov'])){
    $rp_evento_provincia = $_POST['rp_evento_prov'];
    }

    update_post_meta($post_id,'rp_check_restaurant_location_saved', $rp_check_restaurant_location);
    if($rp_start_datetime)
        update_post_meta($post_id,'rp_start_datetime_saved', $rp_start_datetime);
        $split_time = explode(" ",$rp_start_datetime);
        $split_date = explode("/",$split_time[0]);
        $data_convert = $split_date[1].'/'.$split_date[0].'/'.$split_date[2]. '' . $split_time[1] ;
        update_post_meta($post_id,'rp_start_datetime_compare_saved', strtotime($data_convert));
    if($rp_end_datetime)
        update_post_meta($post_id,'rp_end_datetime_saved', $rp_end_datetime);
        $split_time = explode(" ",$rp_end_datetime);
        $split_date = explode("/",$split_time[0]);
        $data_convert = $split_date[1].'/'.$split_date[0].'/'.$split_date[2]. '' . $split_time[1];
        update_post_meta($post_id,'rp_end_datetime_compare_saved', strtotime($data_convert));

        update_post_meta($post_id,'rp_partner_restaurant_saved', $rp_partner_restaurant);

        update_post_meta($post_id,'rp_evento_indirizzo_saved',$rp_evento_indirizzo);

        update_post_meta($post_id,'rp_evento_cap_saved',$rp_evento_cap);

        update_post_meta($post_id,'rp_evento_citta_saved',$rp_evento_citta);

        update_post_meta($post_id,'rp_evento_prov_saved',$rp_evento_provincia);

    if(isset($_POST['rp_scheda_ristorante_lat'])){
    $rp_scheda_ristorante_lat = $_POST['rp_scheda_ristorante_lat'];
    }

    if(isset($_POST['rp_scheda_ristorante_long'])){
    $rp_scheda_ristorante_long = $_POST['rp_scheda_ristorante_long'];
    }

    $rp_scheda_ristorante_map_options = array(
        'zoom' => $_POST['rp_scheda_ristorante_zoom'],
        'type' => $_POST['rp_scheda_ristorante_type'],
        'centre' => $_POST['rp_scheda_ristorante_centre'],
    );

    if($rp_check_restaurant_location==1){
    update_post_meta($post_id,'wp_geo_latitude', $rp_scheda_ristorante_lat);
    update_post_meta($post_id,'wp_geo_longitude', $rp_scheda_ristorante_long);
    update_post_meta($post_id,'wp_geo_map_settings', $rp_scheda_ristorante_map_options);
    }
    else {
        $rp_lat_evento = get_post_meta($post_id,'wp_geo_latitude',true);
        $rp_long_evento = get_post_meta($post_id,'wp_geo_longitude',true);
        $rp_map_options_evento = get_post_meta($post_id, 'wp_geo_map_settings', true);

        update_post_meta($post_id,'wp_geo_latitude', $rp_lat_evento);
        update_post_meta($post_id,'wp_geo_longitude', $rp_long_evento);
        update_post_meta($post_id,'wp_geo_map_settings', $rp_map_options_evento);

    }
}


add_action( 'init', 'create_categories_event_taxonomies', 0 );
//creo una tassonomia per il CTP eventi
function create_categories_event_taxonomies()
{

    // tassonomia eventi

    $labels = array(
        'name' => 'Categorie Evento',
        'singular_name' => 'Categoria Evento',
        'search_items' => 'Cerca Categoria Evento',
        'popular_items' => 'Popular Categorie Evento',
        'all_items' => 'Tutte le Categorie Evento' ,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Edit Categoria Evento',
        'update_item' => 'Aggiorna Categoria Evento',
        'add_new_item' => 'Aggiungi Nuova Categoria Evento',
        'new_item_name' => 'Nome Nuova Categoria Evento',
        'separate_items_with_commas' => 'Separa Categorie Evento con le virgole',
        'add_or_remove_items' => 'Aggiungi e Rimuovi Categorie Evento',
        'choose_from_most_used' => 'Scegli dalle Categorie Evento più usate',
        'menu_name' => 'Categorie Evento',
    );

    register_taxonomy('categorie_evento','rp_eventi',array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'categorie-evento' ),
    ));

    flush_rewrite_rules();
}



/**
 * Colonne da mostrare
 */
add_filter( 'manage_edit-rp_eventi_columns', 'rp_edit_rp_eventi_columns' ) ;
function rp_edit_rp_eventi_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Nome Evento' ),
        'periodo' => __( 'Periodo' ),
        'categoria' => __( 'Categoria' ),
        'locale' => __( 'Locale Associato' ),
        'location' => __('Location')
    );

    return $columns;
}

/**
 * Aggiungo contenuto alle colonne
 */
add_action( 'manage_rp_eventi_posts_custom_column', 'rp_manage_rp_eventi_columns', 10, 2 );
function rp_manage_rp_eventi_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        case 'periodo' :

            /* Get the post meta. */
            $periodo_start = get_post_meta($post_id,'rp_start_datetime_saved', true);
            $periodo_end = get_post_meta($post_id,'rp_end_datetime_saved', true);
            if ( empty( $periodo_start ) && empty( $periodo_end ))
                echo __( 'Non assegnato' );

            else
                echo 'Dal ' .$periodo_start.' al '.$periodo_end;
            break;

        case 'categoria' :

            /* Get the genres for the post. */
            $terms = get_the_terms( $post_id, 'categorie_evento');

            /* If terms were found. */
            if ( !empty( $terms ) ) {

                $out = array();

                foreach ( $terms as $term ) {
                    $out[] = sprintf( '<a href="%s">%s</a>',
                        //Costruisco la URL del link sulla colonna per filtrare per categoria (e.g. tutte le pizzerie, etc...)
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'categorie_evento' => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'categorie_evento', 'display' ) )
                    );
                }

                echo join( ', ', $out );
            }

            else {
                _e( 'Nessuna categoria' );
            }

            break;

        case 'indirizzo' :

            /* Get the post meta. */
            $addr = get_post_meta($post_id,'rp_evento_indirizzo_saved', true);

            if ( empty( $addr ) )
                echo __( 'Non assegnato' );

            else
                echo $addr;

            break;

        case 'locale' :
            $locale_associato = get_post_meta($post_id,'rp_partner_restaurant_saved', true);
            $check_locale_associato = get_post_meta($post_id,'rp_check_restaurant_location_saved', true);
            if ( $check_locale_associato == 1 )
                echo get_the_title($locale_associato);
            else
                echo _e("Non associato",'rp');
            break;

        default :
            break;
    }
}


/**
 * Imposto quali colonne sono Ordinabili
 */
add_filter( 'manage_edit-rp_eventi_sortable_columns', 'rp_eventi_sortable_columns' );
function rp_eventi_sortable_columns( $columns ) {

    $columns['periodo'] = 'periodo';

    return $columns;
}

/**
 * Imposto i criteri di ordinameto
 */
add_action( 'load-edit.php', 'my_edit_rp_eventi_load' );
function my_edit_rp_eventi_load() {
    add_filter( 'request', 'rp_sort_rp_eventi' );
}

function rp_sort_rp_eventi( $vars ) {

    if ( isset( $vars['post_type'] ) && 'rp_eventi' == $vars['post_type'] ) {

        if ( isset( $vars['orderby'] ) && 'periodo' == $vars['orderby'] ) {

            /* Merge the query vars with our custom variables. */
            $vars = array_merge(
                $vars,
                array(
                    'meta_key' => 'rp_start_datetime_saved',
                    'orderby' => 'ASC'
                )
            );
        }
    }

    return $vars;
}
?>