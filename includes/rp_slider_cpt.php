<?php
/**
 * Funzioni Webeing.net per il sito rp.it
 */

add_action('init', 'rp_register_slider');

/**
 * Crea il CPT slider
 */
function rp_register_slider() {

    $rp_slider_labels = array(
        'name'               => __('Slider','rp'),
        'singular_name'      => __('Slider','rp'),
        'add_new'            => __('Aggiungi Slider','rp'),
        'add_new_item'       => __('Nuova Slider','rp'),
        'edit_item'          => __('Modifica Slider','rp'),
        'new_item'           => __('Nuova Slider','rp'),
        'all_items'          => __('Elenco Slider','rp'),
        'view_item'          => __('Visualizza Slider','rp'),
        'search_items'       => __('Cerca Slider','rp'),
        'not_found'          => __('Slider non trovata','rp'),
        'not_found_in_trash' => __('Slider non trovata nel cestino','rp'


        ),
    );

    $rp_slider_cpt = array(
        'labels'             => $rp_slider_labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'slider'),
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => 5,
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'custom-fields',
            'page-attributes'
        ),
    );

    register_post_type('rp_slider', $rp_slider_cpt);

    flush_rewrite_rules();
}
?>
<?php
/**
 * Inizio creazione meta box
 */

add_action( 'add_meta_boxes', 'rp_add_custom_box_link' );



add_action( 'save_post', 'rp_save_slider' );

/**
 * Aggiungo il meta box link
 */
function rp_add_custom_box_link() {
    add_meta_box(
        'slider_link_id',
        __( 'Link slider', 'rp' ),
        'rp_print_custom_box',
        'rp_slider'
    );

}

/**
 * Stampo il box link dello slider
 */
function rp_print_custom_box( $post ) {

    $rp_value_link_slider = get_post_meta( $post->ID, 'rp_slider_link', true);

    $rp_check_slider = get_post_meta( $post->ID, 'rp_slider_check', true);

    $rp_value_label_link_slider = get_post_meta( $post->ID, 'rp_slider_label_link', true);

    $rp_value_align = get_post_meta( $post->ID, 'rp_align', true);

    wp_nonce_field( 'rp_slider_nonce', 'nonce_slider' );
    $checked ='';
    if ($rp_check_slider == 1){
        $checked = ' checked="checked"';
    }


    echo '<p><label for="rp_label_spunta">';
    _e("Inserisci link", 'rp_label_spunta' );
    echo '</label>';
    echo '<input name="slider_check" id="slider_check" value="1" type="checkbox" '.$checked.'></p>';
    echo '<p><label for="rp_link_slider_name">';
    _e("Link slider content", 'rp_link_slider' );
    echo '</label> ';
    echo '<input type="text" id="rp_link_slider_id" name="rp_link_slider_name" value="'.$rp_value_link_slider.'" size="25" /></p>';
    echo '<p><label for="rp_label_link_slider">';
    _e("Label per il link nello slider", 'rp_label_link_slider' );
    echo '</label> ';
    echo '<input type="text" id="rp_label_link_slider_id" name="rp_label_link_slider" value="'.$rp_value_label_link_slider.'" size="25" /></p>';
    echo '<p><label for="rp_align">';
    _e("Allinea testo", 'rp_align' );
    echo '</label>';
    if ($rp_value_align=='left'){

        echo '<select name="rp_align" id="rp_align"><option value="left" selected = "selected">Sinistra</option><option value="right">Destra</option></p>';
    }
    if($rp_value_align=='right'){
        echo '<select name="rp_align" id="rp_align"><option value="left">Sinistra</option><option value="right" selected = "selected">Destra</option></p>';

    }
    else {
        echo '<select name="rp_align" id="rp_align"><option value="left" selected = "selected">Sinistra</option><option value="right">Destra</option></p>';

    }
    echo '</select>';
}

/**
 * Salvataggio slider
 */
function rp_save_slider( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;


    if ( !wp_verify_nonce( $_POST['nonce_slider'], 'rp_slider_nonce' ))
        return;

    if(isset($_POST['slider_check'])){
    $rp_slider_check = $_POST['slider_check'];
    }
    if(isset($_POST['rp_link_slider_name'])){
    $rp_slider_link_name = $_POST['rp_link_slider_name'];
    }
    if(isset($_POST['rp_label_link_slider'])){
    $rp_label_link_slider = $_POST['rp_label_link_slider'];
    }
    if(isset($_POST['rp_align'])){
    $rp_align = $_POST['rp_align'];
    }

        update_post_meta($post_id,'rp_slider_check', $rp_slider_check);

        update_post_meta($post_id,'rp_slider_link', $rp_slider_link_name);

        update_post_meta($post_id,'rp_slider_label_link', $rp_label_link_slider);

        update_post_meta($post_id,'rp_align', $rp_align);
}

?>