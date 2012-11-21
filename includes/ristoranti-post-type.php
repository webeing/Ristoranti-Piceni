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
        'name'               => __('Schede Ristoranti'),
        'singular_name'      => __('Scheda Ristornate'),
        'add_new'            => __('Aggiungi Nuova'),
        'add_new_item'       => __('Nuova'),
        'edit_item'          => __('Modifica'),
        'new_item'           => __('Nuova'),
        'all_items'          => __('Elenco Schede Ristoranti'),
        'view_item'          => __('Visualizza'),
        'search_items'       => __('Cerca'),
        'not_found'          => __('Scheda non trovato'),
        'not_found_in_trash' => __('Scheda non trovato nel cestino'),
    );

    $rp_schede_cpt = array(
        'labels'             => $rp_schede_labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'ristoranti'),
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 4,
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
        ),
    );

    register_post_type('ristoranti', $rp_schede_cpt);

}
?>
<?php
/**
 * Inizio creazione meta box info prodotto
 */

/**
 * Box Info Ristoranti
 */
add_action( 'add_meta_boxes', 'rp_box_info_ristoranti' );
function rp_print_box_info_ristoranti( $post ) {

/*
    $rp_ingredienti = get_post_meta( $post->ID, 'rp_products_ingredienti', true);
    $rp_valori_nutrizionali = get_post_meta( $post->ID, 'rp_products_valori_nutrizionali', true);
    wp_nonce_field( 'rp_info_products_nonce', 'nonce_info_products' );


    echo '<p><b><label for="rp_ingredienti">';
    	_e("Indirizzo", 'rp_ingredenti' );
    echo '</label></b>';
    wp_editor( $rp_ingredienti, 'rp_ingredienti', $settings = array('textarea_rows' => get_option('default_post_edit_rows', 100)));
    echo '<br class="clear" /></p>';

    echo '<p><b><label for="rp_valori_nutrizionali">';
    _e("Inserire i valori nutrizionali", 'rp_valori_nutrizionali' );
    echo '</label></b> ';
    wp_editor( $rp_valori_nutrizionali, 'rp_valori_nutrizionali', $settings = array('textarea_rows' => get_option('default_post_edit_rows', 100)));
    echo '<br class="clear" /></p>';
    */
}

/**
 * Aggiungo il meta box 
 */
add_action( 'init', 'create_ristoranti_taxonomies', 0 );
function rp_box_info_ristoranti() {
    add_meta_box(
        'info_products_id',
        __( 'Informazioni prodotto', 'ristorantipiceni' ),
        'rp_box_info_ristoranti',
        'rristoranti'
    );

}


/**
 * Salvataggio ingredienti e valori nutrizionali
 */
add_action( 'save_post', 'rp_save_info_ristoranti' );	
//Taxonomy Definition
function rp_save_info_ristoranti( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;


    if ( !wp_verify_nonce( $_POST['nonce_info_products'], 'rp_info_products_nonce' ))
        return;

    $rp_ingredienti = $_POST['rp_ingredienti'];
    $rp_valori_nutrizionali = $_POST['rp_valori_nutrizionali'];

    update_post_meta($post_id,'rp_products_ingredienti', $rp_ingredienti);
    update_post_meta($post_id,'rp_products_valori_nutrizionali', $rp_valori_nutrizionali);

}


//creo una tassonomia per il CTP prodotto
function create_ristoranti_taxonomies()
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
        'menu_name' => 'Tipologie Ristoranti',
    );

    register_taxonomy('tipologia','ristoranti',array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'tipologia' ),
    ));
}
?>