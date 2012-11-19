<?php
/**
 * Created by JetBrains PhpStorp.
 * User: Webeing.net
 * Date: 15/10/12
 * Time: 17:48
 * To change this template use File | Settings | File Templates.
 */
define("RP_THEME_NAME","Ristoranti Piceni");
define("RP_THEME_SHORTNAME","rp");

/**
 * Action fired
 */
add_action('admin_init', 'rp_add_init');
add_action('admin_menu', 'rp_add_admin');

/**
 * Accede alle opzioni base
 * @return array
 */
function rp_get_options(){
    $options = array (
        array(
            "name" => "Opzioni Generali",
            "type" => "section"
        ),
        array(
            "type" => "open"),
        array(
            "name" => "Google Analytics Code",
            "desc" => "You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.",
            "id" => RP_THEME_SHORTNAME."_ga_code",
            "type" => "textarea",
            "std" => ""
        ),
        array(
            "name" => "Default Thumb Image",
            "desc" => "Carica l' immagine di default dei Post del sito",
            "id" => RP_THEME_SHORTNAME."_default_image_option",
            "type" => "html",
            "html" => rp_render_image_attachment_box()
        ),
        array(
            "name" => "Default Header Image",
            "desc" => "Carica l'immagine di default della testata del sito",
            "id" => RP_THEME_SHORTNAME."_default_header_option",
            "type" => "html",
            "html" => rp_render_image_attachment_box('rp_default_header_image','_rp_attached_header_image')
        ),
        array(
            "name" => "Custom Favicon",
            "desc" => "A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image",
            "id" => RP_THEME_SHORTNAME."_favicon",
            "type" => "text",
            "std" => get_bloginfo('url') ."/favicon.ico"
        ),
        array("type" => "close"),

        array(
            "name" => RP_THEME_NAME." Options",
            "type" => "title"
        ),
        array(
            "name" => "Area Top",
            "type" => "section"
        ),
        array(
            "type" => "open"),
        array(
            "name" => "Contenuti in Home page",
            "desc" => "Seleziona quale tipo di contenuti saranno presenti in Home page nella posizione ( A )",
            "id" => RP_THEME_SHORTNAME."_postion_a",
            "type" => "select",
            "options" => array(
                "null"=>"Seleziona",
                "page"=>"Pagine",
                "post"=> "Articoli",
                "widget" => "Widget",
                "text" => "Testo/HTML libero"
            ),
            "std" => "Seleziona"
        ),
        array(
            "name" => "Seleziona il contenuto da visualizzare",
            "desc" => "",
            "id" => RP_THEME_SHORTNAME."_postion_a_content",
            "type" => "post-list",
            "options" => rp_get_all_contents_for(),
            "std" => "Seleziona"
        ),
        array( "type" => "close"),
        array(
            "name" => "Area Middle",
            "type" => "section"
        ),
        array(
            "type" => "open"
        ),
        array( "type" => "close"),
        array(
            "name" => "Area piè di pagina",
            "type" => "section"
        ),
        array( "type" => "open"),
        array(
            "name" => "Footer copyright text",
            "desc" => "Enter text used in the right side of the footer. It can be HTML",
            "id" => RP_THEME_SHORTNAME."_footer_text",
            "type" => "text",
            "std" => ""
        ),
        array( "type" => "close")
    );
    return $options;
}

function dump( $val){
    echo '<pre>';
    var_dump($val);
    echo '</pre>';

}

/**
 * Salva i dati provenienti dall'interfaccia Admin
 */
function rp_add_admin() {
    $options = rp_get_options();

    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                //dump($_REQUEST);
                update_option( $value['id'], $_REQUEST[ $value['id'] ] );
            }
            foreach ($options as $value) {
                if( isset( $_REQUEST[ $value['id'] ] ) ) {
                   if($_REQUEST[$value['id']])
                       update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
                } else {
                    delete_option( $value['id'] );
                }
            }
            rp_upload_image();
            rp_upload_header_image() ;
            //header("Location: admin.php?page=functions.php&saved=true");
            //die;
        }
        else if( 'reset' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option( $value['id'] ); }
            //header("Location: admin.php?page=functions.php&reset=true");
            //die;
        }
    }
    add_menu_page(RP_THEME_NAME, RP_THEME_NAME, 'moderate_comments', basename(__FILE__), 'rp_admin');
}

/**
 * Aggiunge scripts in init
 */
function rp_add_init() {
    $file_dir = get_bloginfo('template_directory');
    wp_enqueue_style("functions", $file_dir."/includes/rp_admin_options.css", false, "1.0", "all");
    wp_enqueue_script("rm_script", $file_dir."/includes/rp_admin_scripts.js", false, "1.0");

}

/**
 * Crea l'interfaccia di amministrazione
 */
function rp_admin() {
    $options = rp_get_options();
    $i=0;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.RP_THEME_NAME.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.RP_THEME_NAME.' settings reset.</strong></p></div>';
    ?>
<div class="wrap rp_wrap">
    <h2>Opzioni <?php echo RP_THEME_NAME; ?></h2>
    <div class="rp_opts">
        <form method="post" enctype="multipart/form-data">

<?php foreach ($options as $value) {
switch ( $value['type'] ) {
    case "open":
        ?>
        <?php break;
    case "close":
        ?>
</div>
</div>
<br />
    <?php break;
    case "title":
        ?>
    <p>Personalizza il tema <?php echo RP_THEME_NAME;?> con le opzioni che trovi qui sotto</p>
    <?php break;
    case 'text':
        ?>
    <div class="rp_input rp_text">
        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
    </div>
    <?php
        break;
    case 'textarea':
        ?>
    <div class="rp_input rp_textarea">
        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
        <textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
    </div>
    <?php
        break;
    case 'select':
        ?>
    <div class="rp_input rp_select">
        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
        <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
            <?php foreach ($value['options'] as $key => $option) {   ?>
            <option value="<?php echo $key ?>" <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
        </select>
        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
    </div>
    <?php
        break;
    case 'post-list':
        ?>
    <div class="rp_input rp_select">
        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
        <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
            <?php foreach ($value['options'] as $option) { ?>
            <option value="<?php echo $option['id']?>" <?php if (get_settings( $value['id'] ) == $option['title']) { echo 'selected="selected"'; } ?>><?php echo $option['title']; ?></option><?php } ?>
        </select>
        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
    </div>
    <?php
        break;
    case "checkbox":
        ?>
    <div class="rp_input rp_checkbox">
        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
        <?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
    </div>
   <?php break;
    case "html" : ?>
    <div class="rp_html rp_input">
        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
        <p id="<?php echo $value['id']; ?>"><?php echo $value['html']; ?></p>
        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
    </div>
   <?php  break;
    case "section":
        $i++;
    ?>
    <div class="rp_section">
    <div class="rp_title"><h3><img src="<?php bloginfo('template_directory')?>/images/trans.gif" class="inactive" alt="""><?php echo $value['name']; ?></h3><span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
    </span><div class="clearfix"></div></div>
    <div class="rp_options">
    <?php break;
    }
        }
        ?>
        <input type="hidden" name="action" value="save" />
        </form>
        <form method="post" enctype="multipart/form-data">
            <p class="submit">
                <input name="reset" type="submit" value="Reset" />
                <input type="hidden" name="action" value="reset" />
            </p>
        </form>
        <div style="font-size:9px; margin-bottom:10px;">Icons: <a href="http://www.woothemes.com/2009/09/woofunction/">WooFunction</a></div>
     </div>
    <?php
    }


/**
 * Preleva i dati da presentare in base al post type
 * @param string $type
 * @return array
 */
function rp_get_all_contents_for($type = "page"){

    $toReturn = array();
    $temp = array();

    $args = array(
        'post_type' => $type,
        'numberposts' => -1,
    );
    $posts = get_posts( $args );


    foreach($posts as $apost):
        $temp['post']['id'] = $apost->ID;
        $temp['post']['title'] = $apost->post_title;
         array_push($toReturn, $temp);
    endforeach;
    return $toReturn;
}


/**
 * Fire Ajax Requests
 * @param string $type
 */
function rp_ajax_contents_for(){
    $type = isset($_POST['data']) ? $_POST['data'] : "post";
    if ( post_type_exists( $type ) ):
        $contents = rp_get_all_contents_for( $type );
        echo rp_render_option($contents);
        die();
    elseif( $type == "widget") :
        echo "";//widget list;
        die();
    elseif( $type == "text") :
        echo rp_render_text_area();
        die();
    else :
        echo "No data found";
        die();
    endif;

}
add_action('wp_ajax_rp_ajax_contents_for', 'rp_ajax_contents_for');

/**
 * Renderizza un contenuto di tipo select/options
 * @param $contents
 */
function rp_render_option($contents){

    if ( is_array($contents) || is_object( $contents )):
        foreach ($contents as $option) :
            if ( $selected == $option['post']['id'] )
                $sel = ' selected="selected"';
        ?>
        <option<?php echo $sel ?> value="<?php echo $option['post']['id']?>"><?php echo $option['post']['title']; ?></option>
<?php
        endforeach;
    endif;

}

/**
 * Renderizza un contenuto di tipo TextArea
 */
function rp_render_text_area(){
    ?>
    <div class="rp_input rp_textarea">
        <label for="rp_option_text_area_top">Testo o HTML</label>
        <textarea name="rp_option_text_area_top" cols="45" rows="34" id=rp_option_text_area_top"></textarea>
        <small>Inserisci Testo o HTML Custom</div>
    </div>
<?php }

/**
 * Renderizza un contenuto di tipo InputBox
 * @return string
 */
function rp_render_image_attachment_box( $image_name = 'rp_default_image', $option_saved="_rp_attached_image"  ) {

    $existing_image_id = get_option( $option_saved );
    $html = "";
    if(is_numeric($existing_image_id)) {

        $html .= '<div>';
        $arr_existing_image = wp_get_attachment_image_src($existing_image_id, 'large');
        $existing_image_id = $arr_existing_image[0];
        $html .= '<img width="200" src="' . $existing_image_id . '" />';
        $html .= '</div>';

    }

    // If there is an existing image, show it
    if($existing_image_id) {

        $html .= '<div>URL Immagine: ' . $existing_image_id . '</div>';

    }

    $html .= 'Upload an image: <input type="file" name="' . $image_name .'" id="' . $image_name .'" />';

    // See if there's a status message to display (we're using this to show errors during the upload process, though we should probably be using the WP_error class)
    $status_message = get_option( '_rp_attached_image_upload_feedback' );

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
function rp_upload_image() {

    // Make sure our flag is in there, otherwise it's an autosave and we should bail.
    if( isset($_REQUEST['rp_manual_save_flag'])) {

        // If the upload field has a file in it
        if(isset($_FILES['rp_default_image']) && ($_FILES['rp_default_image']['size'] > 0)) {

        // Get the type of the uploaded file. This is returned as "type/extension"
        $arr_file_type = wp_check_filetype(basename($_FILES['rp_default_image']['name']));
        $uploaded_file_type = $arr_file_type['type'];

        // Set an array containing a list of acceptable formats
        $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

        $attach_id = 0;

        // If the uploaded file is the right format
        if(in_array($uploaded_file_type, $allowed_file_types)) {

            // Options array for the wp_handle_upload function. 'test_upload' => false
            $upload_overrides = array( 'test_form' => false );

            // Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
            $uploaded_file = wp_handle_upload($_FILES['rp_default_image'], $upload_overrides);


            // If the wp_handle_upload call returned a local path for the image
            if(isset($uploaded_file['file'])) {

                // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                $file_name_and_location = $uploaded_file['file'];

                // Generate a title for the image that'll be used in the media library
                $file_title_for_media_library = 'Ristoranti Piceni Default Thumb';

                // Set up options array to add this file as an attachment
                $attachment = array(
                    'post_mime_type' => $uploaded_file_type,
                    'post_title' => 'Immagine caricata come ' . addslashes($file_title_for_media_library),
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
                $existing_uploaded_image = (int) get_option('_rp_attached_image', true);
                if(is_numeric($existing_uploaded_image)) {
                    wp_delete_attachment($existing_uploaded_image);
                }

                // Now, update the post meta to associate the new image with the post
                update_option('_rp_attached_image',$attach_id);

                // Set the feedback flag to false, since the upload was successful
                $upload_feedback = false;


            } else { // wp_handle_upload returned some kind of error. the return does contain error details, so you can use it here if you want.

                $upload_feedback = 'There was a problem with your upload.';
                update_option('_rp_attached_image',$attach_id);

            }

            } else { // wrong file type

                $upload_feedback = 'Please upload only image files (jpg, gif or png).';
                update_option('_rp_attached_image',$attach_id);

            }

            } else { // No file was passed

                $upload_feedback = false;

            }

            // Update the post meta with any feedback
            update_option('_rp_attached_image_upload_feedback',$upload_feedback);

        return;

    } // End if manual save flag

    return;

}



/**
 * Gestisce un campo upload immagine per la sua memorizzazione in Uploads
 */
function rp_upload_header_image() {

    // Make sure our flag is in there, otherwise it's an autosave and we should bail.
    if( isset($_REQUEST['rp_manual_save_flag'])) {

        // If the upload field has a file in it
        if(isset($_FILES['rp_default_header_image']) && ($_FILES['rp_default_header_image']['size'] > 0)) {

            // Get the type of the uploaded file. This is returned as "type/extension"
            $arr_file_type = wp_check_filetype(basename($_FILES['rp_default_header_image']['name']));
            $uploaded_file_type = $arr_file_type['type'];

            // Set an array containing a list of acceptable formats
            $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

            $attach_id = 0;

            // If the uploaded file is the right format
            if(in_array($uploaded_file_type, $allowed_file_types)) {

                // Options array for the wp_handle_upload function. 'test_upload' => false
                $upload_overrides = array( 'test_form' => false );

                // Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
                $uploaded_file = wp_handle_upload($_FILES['rp_default_header_image'], $upload_overrides);


                // If the wp_handle_upload call returned a local path for the image
                if(isset($uploaded_file['file'])) {

                    // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                    $file_name_and_location = $uploaded_file['file'];

                    // Generate a title for the image that'll be used in the media library
                    $file_title_for_media_library = 'Ristoranti Piceni Default Header';

                    // Set up options array to add this file as an attachment
                    $attachment = array(
                        'post_mime_type' => $uploaded_file_type,
                        'post_title' => 'Immagine caricata ' . addslashes($file_title_for_media_library),
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
                    $existing_uploaded_image = (int) get_option('_rp_attached_header_image', true);
                    if(is_numeric($existing_uploaded_image)) {
                        wp_delete_attachment($existing_uploaded_image);
                    }

                    // Now, update the post meta to associate the new image with the post
                    update_option('_rp_attached_header_image',$attach_id);

                    // Set the feedback flag to false, since the upload was successful
                    $upload_feedback = false;


                } else { // wp_handle_upload returned some kind of error. the return does contain error details, so you can use it here if you want.

                    $upload_feedback = 'There was a problem with your upload.';
                    update_option('_rp_attached_header_image',$attach_id);

                }

            } else { // wrong file type

                $upload_feedback = 'Please upload only image files (jpg, gif or png).';
                update_option('_rp_attached_header_image',$attach_id);

            }

        } else { // No file was passed

            $upload_feedback = false;

        }

        // Update the post meta with any feedback
        update_option('_rp_attached_image_upload_feedback',$upload_feedback);

        return;

    } // End if manual save flag

    return;

}
