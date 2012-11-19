<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Webeing.net
 * Date: 22/10/12
 * Time: 11:42
 *
 * Custom Fields Generici applicabili ovunque
 */

define('RP_IMAGE_HEADER_NAME','rp_custom_header_image_id');

add_action( 'add_meta_boxes', 'rp_add_custom_boxes' );
add_action( 'save_post', 'rp_save_custom_options', 1, 2 );
add_action( 'save_post', 'rp_upload_custom_header_image', 99, 2);
add_action( 'post_edit_form_tag', 'rp_add_edit_form_multipart_encoding');


/**
 * Aggiunge il enctype="multipart/form-data al salvataggio
 */
function rp_add_edit_form_multipart_encoding() {

    echo ' enctype="multipart/form-data"';

}

/**
 * Aggiungo il meta box link
 */
function rp_add_custom_boxes() {
    add_meta_box(
        'page_options_id',
        __( 'Opzioni Pagina', 'rp' ),
        'rp_print_custom_box_page',
        'page',
        'normal',
        'high'
    );

}

/**
 * Custom Box per le pagine
 */

function rp_print_custom_box_page( $post ) {

    wp_nonce_field( 'rp_option_page_nonce', 'nonce_option_page' );

    echo '<input id="rp_current_page" name="rp_current_page" type="hidden" value="'. $post->ID .'" />';

    echo rp_render_header_image_attachment_box( $post );

}

/**
 * Salvataggio ctp eventi
 */
function rp_save_custom_options( $post_id, $post ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;


    if ( !wp_verify_nonce( $_POST['nonce_option_page'], 'rp_option_page_nonce' ))
        return;
    //var_dump("Save",$post_id);

    //rp_upload_custom_header_image( $post_id, $post );
}

/**
 * Renderizza un contenuto di tipo InputBox
 * @return string
 */
function rp_render_header_image_attachment_box( $post ) {

    $existing_image_id = get_post_meta( $post->ID, 'rp_custom_header_image_id', true );
    $html = "";
    if(is_numeric($existing_image_id)) {

        $html .= '<div>';
        $arr_existing_image = wp_get_attachment_image_src($existing_image_id, 'slider-feature-secondary');
        $existing_image_id = $arr_existing_image[0];
       // $html .= '<img width="200" src="' . $existing_image_id . '" />';
        $html .= wp_get_attachment_image($existing_image_id,'slider-feature-secondary');
        $html .= '</div>';

    }

    // If there is an existing image, show it
    if($existing_image_id) {

        $html .= '<div>URL Immagine: ' . $existing_image_id . '</div>';

    }

    $html .= 'Immagine di Testata personalizzata: <input type="file" name="' . RP_IMAGE_HEADER_NAME .'" id="' . RP_IMAGE_HEADER_NAME .'" />';

    // See if there's a status message to display (we're using this to show errors during the upload process, though we should probably be using the WP_error class)
    $status_message = get_post_meta( $post->ID, '_rp_attached_image_upload_feedback', true );

    // Show an error message if there is one
    if($status_message) {

        $html .= '<div class="upload_status_message">';
        $html .= $status_message;
        $html .= '</div>';

    }

    // Put in a hidden flag. This helps differentiate between manual saves and auto-saves (in auto-saves, the file wouldn't be passed).
    $html .= '<input type="hidden" name="rp_manual_save_flag" value="true" />';
    return $html;

}

/**
 * Gestisce un campo upload immagine per la sua memorizzazione in Uploads
 */
function rp_upload_custom_header_image( $post_id, $post ) {

    //$current_page_id = $_POST['rp_current_page'];
    update_post_meta( $post_id, '_rp_attached_image_upload_feedback', "" );


    // Make sure our flag is in there, otherwise it's an autosave and we should bail.
    if( ($post->post_type == 'page') && isset($_REQUEST['rp_manual_save_flag'])) {



        // If the upload field has a file in it
        if(isset($_FILES['rp_custom_header_image_id']) && ($_FILES['rp_custom_header_image_id']['size'] > 0)) {

            $upload_feedback = false;


            // Get the type of the uploaded file. This is returned as "type/extension"
            $arr_file_type = wp_check_filetype(basename($_FILES['rp_custom_header_image_id']['name']));
            $uploaded_file_type = $arr_file_type['type'];

            // Set an array containing a list of acceptable formats
            $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

            $attach_id = 0;

            // If the uploaded file is the right format
            if( in_array($uploaded_file_type, $allowed_file_types) ) {

                // Options array for the wp_handle_upload function. 'test_upload' => false
                $upload_overrides = array( 'test_form' => false );

                // Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
                $uploaded_file = wp_handle_upload($_FILES['rp_custom_header_image_id'], $upload_overrides);


                // If the wp_handle_upload call returned a local path for the image
                if(isset($uploaded_file['file'])) {

                    // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                    $file_name_and_location = $uploaded_file['file'];

                    // Generate a title for the image that'll be used in the media library
                    $file_title_for_media_library = 'Ristoranti Piceni Header Thumb';

                    // Set up options array to add this file as an attachment
                    $attachment = array(
                        'post_mime_type' => $uploaded_file_type,
                        'post_title' => 'Uploaded image ' . addslashes($file_title_for_media_library),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );

                    // Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
                    $attach_id = wp_insert_attachment( $attachment, $file_name_and_location );
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
                    wp_update_attachment_metadata($attach_id,  $attach_data);

                    // Before we update the post meta, trash any previously uploaded image for this post.
                    // You might not want this behavior, depending on how you're using the uploaded images.
                    $existing_uploaded_image = (int) get_post_meta( $post_id, 'rp_custom_header_image_id', true );
                    if(is_numeric($existing_uploaded_image)) {
                        wp_delete_attachment($existing_uploaded_image);
                    }

                    // Now, update the post meta to associate the new image with the post
                    $result = update_post_meta($post_id, 'rp_custom_header_image_id',$attach_id);

                    // Set the feedback flag to false, since the upload was successful
                    $upload_feedback = false;


                } else { // wp_handle_upload returned some kind of error. the return does contain error details, so you can use it here if you want.

                    $upload_feedback = 'Errori durante il caricamento.';
                    update_post_meta($post_id, 'rp_custom_header_image_id',$attach_id);

                }

            } else { // wrong file type

                $upload_feedback = 'Please upload only image files (jpg, gif or png).';
                update_post_meta($post_id, 'rp_custom_header_image_id',$attach_id);

            }

        } else { // No file was passed

            $upload_feedback = false;

        }

        // Update the post meta with any feedback
        update_post_meta($post_id, '_rp_attached_image_upload_feedback',$upload_feedback);

        return;

    } // End if manual save flag

    return;

}