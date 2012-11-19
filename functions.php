<?php
/**
 * Ristoranti Piceni functions and definitions
 *
 *
 * @package WordPress
 * @subpackage Ristorantipiceni
 * @since Ristoranti Piceni 1.0
 */
/**
 * Tell WordPress to run ristorantipiceni_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'ristorantipiceni_setup' );

if ( ! function_exists( 'ristorantipiceni_setup' ) ):
function ristorantipiceni_setup() {

	// This theme uses wp_nav_menu() in one location
	register_nav_menu( 'primary', __( 'Primary Menu', 'rp' ) );
	register_nav_menu( 'static', __( 'Static Menu', 'rp' ) );
	register_nav_menu( 'social', __( 'Social Menu', 'rp' ) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );
    add_post_type_support('page', 'excerpt');


    // We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( 200, 130, true );

	// Add Ristoranti piceni's custom image sizes.
	// Used for large feature (slider) images.
    add_image_size( 'archive-thumb', 150,150,true);
	add_image_size( 'slider-feature', 940, 400, true );
    add_image_size( 'slider-feature-secondary', 940, 230, true );
	// Used for featured card restaurant carousel header.
	add_image_size( 'slider-thumb-feature', 230, 230, true );
	// Used for thumbnail small.
	add_image_size( 'small-thumb', 60, 60, true );
    add_image_size( 'thumb-logo', 200, 200, true );
    /**
     * Include Ristoranti Post Type and Taxonomies
     */
    include_once TEMPLATEPATH . "/includes/rp_init.php";
    /**
     * Include Ristoranti Post Type and Taxonomies
     */
    include_once TEMPLATEPATH . "/includes/rp_locali_cpt.php";
    /**
     * CTP slider
     */
    include_once TEMPLATEPATH . "/includes/rp_slider_cpt.php";
    /**
     * CTP eventi
     */
    include_once TEMPLATEPATH . "/includes/rp_eventi_cpt.php";
    /**
     * Custom Fields
     */
    include_once TEMPLATEPATH . "/includes/rp_custom_fields.php";
    /**
    * Theme opions
    */
    include_once TEMPLATEPATH . "/includes/rp_theme_options.php";
    /**
     * Widgets
     */
    include_once TEMPLATEPATH . "/includes/widgets.php";
    /**
     * Ajax Transactions
     */
    include_once TEMPLATEPATH . "/includes/rp_ajax.php";


}
endif; // ristorantipiceni_setup

add_action('admin_init', 'rp_admin_access');
function rp_admin_access() {
    if (is_admin() && !(current_user_can( 'administrator' ) || current_user_can('editor')) && ($_SERVER['REQUEST_URI'] != '/wp-admin/admin-ajax.php')) {
        wp_redirect(home_url());
        exit();
    }
}

add_action('init','rp_init');
function rp_init(){

    wp_localize_script( 'rp_ajax', 'rp_ajax_data', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'template_url' => get_bloginfo('url')
    ));

    //Disabilito accesso backend per i non admin e editor
/*
    if ( is_admin() && ! (current_user_can( 'administrator' ) || current_user_can('editor')) ) {
        global $facebook;
        $user = $facebook->getUser();
        if ($user) {
            $user_profile = $facebook->api('/me');
            $current_facebook = $user_profile['id'];
            $users = get_users(array('meta_key' => 'id_facebook', 'meta_value' => $current_facebook));
            wp_clear_auth_cookie( $users[0]->ID );
        }
        wp_redirect( home_url() );
        exit;
    } */
}

/**
 * @return string
 * Rimuove riferimenti a Wordpress in meta-informazioni
 */
function rp_remove_version() {
    return '';
}
add_filter('the_generator', 'rp_remove_version');

/**
 * @param $content
 * @return bool
 * Rimuove la barra admin per gli utenti non amministratori
 */

function rp_remove_admin_bar($content) {
    return ((current_user_can( 'administrator' ) || current_user_can('editor'))) ? $content : false;
}
add_filter( 'show_admin_bar' , 'rp_remove_admin_bar');




#add_filter('logout_url', 'rp_logout_redirect');
/**
 * @param $logout_url
 * @param $redirect
 * @return mixed
 *
 * Reindirizza gli utenti alla Home una volta fatto il logout
 */
function rp_logout_redirect($logout_url, $redirect) {
    wp_clear_auth_cookie();

    return site_url();
}

/**
 * Sets the post excerpt length to 40 words.
 */
function ristorantipiceni_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'ristorantipiceni_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function ristorantipiceni_continue_reading_link() {
	return ' <a class="btn" href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'rp' ) . '</a>';
}
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function ristorantipiceni_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'ristorantipiceni_page_menu_args' );

/**
 * Init Widgets
 */
function ristorantipiceni_widgets_init() {

	//register_widget( 'Ristoranti_Piceni_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Home Top Left', 'rp' ),
		'id' => 'evidence-left-top-home',
        'description' => __( 'Sidebar per area top home "mangiagratis"', 'rp' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s left">',
		'after_widget' => "</section>",
		'before_title' => '<h2 class="widget-title title">',
		'after_title' => '</h2>',
	) );

    register_sidebar( array(
        'name' => __( 'Home Top Right', 'rp' ),
        'id' => 'evidence-right-top-home',
        'description' => __( 'Sidebar per area top home "Aggiungi ristorante"', 'rp' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s right">',
        'after_widget' => "</section>",
        'before_title' => '<h2 class="widget-title title">',
        'after_title' => '</h2>',
    ) );

	register_sidebar( array(
		'name' => __( 'Home Special Event', 'rp' ),
		'id' => 'special-events-home',
		'description' => __( 'Sidebar per aggregazione eventi in home', 'rp' ),
		'before_widget' => '<section class="left side" id="special-events">',
        'after_widget' => '</section>',
		'before_title' => '<header><h2 class="title">',
		'after_title' => '</h2></header>',
	) );

	register_sidebar( array(
		'name' => __( 'Home Bottom Sidebar', 'rp' ),
		'id' => 'info-bottom',
		'description' => __( 'Area bottom, per info utili in homepage. Box previsti con dimensione 1/3', 'rp' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s box">',
		'after_widget' => "</div>",
		'before_title' => '<h2 class="widget-title title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footerone Sidebar', 'rp' ),
		'id' => 'bigfooter',
		'description' => __( 'Area footer widget', 'rp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s box-min">',
		'after_widget' => "</section>",
		'before_title' => '<h3 class="widget-title title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Page', 'rp' ),
		'id' => 'sidebar-page',
		'description' => __( 'Sidebar prevista per le pagine statiche', 'rp' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Sidebar Blog', 'rp' ),
		'id' => 'sidebar-blog',
		'description' => __( 'Sidebar prevista per le aree dinamiche del sito "blog"', 'rp' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Top Scheda Ristorante', 'rp' ),
		'id' => 'sidebar-rp-top',
		'description' => __( 'Sidebar prevista per la parte top delle schede ristorante parte TOP', 'rp' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Sidebar Scheda Ristorante', 'rp' ),
		'id' => 'sidebar-rp-scheda',
		'description' => __( 'Sidebar prevista per le schede ristorante  parte CONTENT', 'rp' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'ristorantipiceni_widgets_init' );

if ( ! function_exists( 'ristorantipiceni_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function ristorantipiceni_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
            <?php if(is_tax( 'categorie_evento' )){ ?>
            <div class="nav-previous"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Precedente', 'rp' ) ); ?></div>
            <div class="nav-next"><?php next_posts_link( __( 'Successivo <span class="meta-nav">&rarr;</span>', 'rp' ) ); ?></div>
            <?php } elseif (is_post_type_archive( 'rp_locali' )){?>
            <div class="nav-previous"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Scopri altri', 'rp' ) ); ?></div>
            <div class="nav-next"><?php next_posts_link( __( 'Indietro <span class="meta-nav">&rarr;</span>', 'rp' ) ); ?></div>
            <?php } else {?>
    <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Precedente', 'rp' ) ); ?></div>
    <div class="nav-next"><?php previous_posts_link( __( 'Successivo <span class="meta-nav">&rarr;</span>', 'rp' ) ); ?></div>
    <?php } ?>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // ristorantipiceni_content_nav

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 */
function ristorantipiceni_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'ristorantipiceni_body_classes' );


/**
* Add custom script
*/
function rp_scripts() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.js');
    wp_enqueue_script( 'jquery' );
    wp_deregister_script( 'jquery-ui-core' );
    wp_register_script( 'jquery-ui-core', get_template_directory_uri() . '/js/jquery-ui.js', 'jquery', '', 'true');
    wp_enqueue_script( 'jquery-ui-core' );
    wp_register_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.js', 'jquery', '', 'true');
    wp_enqueue_script( 'easing' );
    wp_register_script('fancybox', get_template_directory_uri() . '/js/fancybox/source/jquery.fancybox.pack.js', 'jquery', '', 'true');
    wp_enqueue_script('fancybox');
    wp_register_script('cycle', get_template_directory_uri() . '/js/cycle.js', 'jquery', '', 'true');
    wp_enqueue_script('cycle');
    wp_register_script('general', get_template_directory_uri() . '/js/general.js', 'jquery', '', 'true');
    wp_enqueue_script('general');

    if( is_page(RP_LOGIN_URL_SLUG) || is_page(RP_REGISTER_URL_SLUG) || is_author() ){
        wp_register_script( 'rp-facebook', get_template_directory_uri() . '/js/rp_facebook.js');
        wp_enqueue_script( 'rp-facebook' );
    }

    wp_register_script( 'rp-ajax', get_template_directory_uri() . '/js/rp_ajax.js');
    wp_enqueue_script( 'rp-ajax' );

    //Aggiungo dati customizzati al file Javascript rp_ajax.js
    wp_localize_script( 'rp-facebook', 'rp_ajax_data', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'template_url' => get_bloginfo('template_url')
    ));

    wp_localize_script( 'rp-ajax', 'rp_ajax_data', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'template_url' => get_bloginfo('template_url')
    ));

    wp_localize_script( 'general', 'general_data', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'template_url' => get_bloginfo('url'),
            'template_includes' => get_bloginfo('template_url') . "/includes"
        ));

    wp_register_style( 'fancybox-style', get_template_directory_uri() . '/js/fancybox/source/jquery.fancybox.css');
    wp_enqueue_style( 'fancybox-style' );
    wp_register_style( 'jquery-ui-style', get_template_directory_uri() . '/js/jquery-ui/jquery-ui.css');
    wp_enqueue_style( 'jquery-ui-style' );

    if(get_post_type() == "locali"):
        wp_register_script('carousel', get_template_directory_uri() . '/js/carousel.js', 'jquery', '', 'true');
        wp_enqueue_script('carousel');
    endif;
    
}
add_action('wp_enqueue_scripts', 'rp_scripts');

function rp_admin_scripts() {
    wp_register_script( 'jquery-ui-datepicker', '','jquery','','true');
    wp_enqueue_script('jquery-ui-datepicker');

    wp_register_script( 'jquery-ui-slider','','jquery','','true');
    wp_enqueue_script('jquery-ui-slider');

    wp_register_script( 'timepicker', get_template_directory_uri() . '/js/timepicker.js','jquery','','true');
    wp_enqueue_script( 'timepicker' );

    wp_register_script( 'admin-scripts', get_template_directory_uri() . '/js/admin_scripts.js','jquery','','true');
    wp_enqueue_script( 'admin-scripts' );

    if(get_post_type() == "locali"):
        wp_register_script( 'admin-ristoranti-scripts', get_template_directory_uri() . '/js/admin_ristoranti_scripts.js','jquery','','true');
        wp_enqueue_script( 'admin-ristoranti-scripts' );
    endif;

    if(get_post_type() == "rp_eventi"):
        wp_register_script( 'admin-eventi-scripts', get_template_directory_uri() . '/js/admin_eventi_scripts.js','jquery','','true');
        wp_enqueue_script( 'admin-eventi-scripts' );
        wp_register_style( 'jquery-ui-style', get_template_directory_uri() . '/js/jquery-ui/jquery-ui.css');
        wp_enqueue_style( 'jquery-ui-style' );
    endif;
}
add_action('admin_enqueue_scripts', 'rp_admin_scripts');


//hook per la query archivio eventi
add_action( 'pre_get_posts', 'rp_date_archive' );
function rp_date_archive($query){

    if( ($query->is_tax( 'categorie_evento' ) || $query->is_post_type_archive( 'rp_eventi' ) ) && !is_admin()){
        $time = time();
        if($_GET['past']=='true'){
        $meta = array(
                array(
                    'key' => 'rp_end_datetime_compare_saved',
                    'value' => $time,
                    'compare' => '<'
                )
            );
        } else{

        $meta = array(
            array(
                'key' => 'rp_end_datetime_compare_saved',
                'value' => $time,
                'compare' => '>='
            )
        );
        }
    $query->set('meta_query', $meta);
    $query->query_vars['meta_key']= 'rp_start_datetime_compare_saved';
    $query->query_vars['orderby'] = 'meta_value';
    $query->query_vars['order'] = 'ASC';

    }

    //query per la ricerca

    elseif (is_search()){
    $tipologia = $_GET['rp_search_tipologia'];
    $localita = $_GET['rp_search_localita'];

     if($localita):
        $meta_search = array(
            array(
                'key' => 'rp_scheda_citta_saved',
                'value' => $localita,
                'compare' => '='
            )
        );
         $query->set('meta_query',$meta_search);
     endif;
     if($tipologia):
        $meta_tax = array(
         array(
             'taxonomy' => 'tipologia',
             'field' => 'id',
             'terms' => $tipologia
         )
        );


        $query->set('tax_query',$meta_tax);
     endif;

        $query->query_vars['order'] = 'DESC';
        $query->query_vars['post_type'] = array('locali','nav_menu_item');


    }

    return $query;

}
//imposta la stringa della ricerca con un valore anche se è vuota
add_filter( 'request', 'rp_request_filter' );
function rp_request_filter( $query_vars ) {
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }
    return $query_vars;
}

add_filter( 'post_thumbnail_html', 'rp_default_thumb', 10, 5 );
/**
 * @param $html
 * @param $post_id
 * @param $post_thumbnail_id
 * @param $size
 * @param $attr
 * @return string
 */
function rp_default_thumb( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    $width = "";
    $height =  "";

    #var_dump($attr);
    $a = "";
    foreach($attr as $key => $val){
        $a .=  ' '. $key . '="' . $val . '"';
    }

    if( '' == $html ) {
        global $_wp_additional_image_sizes;
        $dimensions = '';
        if ( is_array( $size ) ){
            $width = $size[0];
            $height = $size[1];
        }
        else{
            if( isset( $_wp_additional_image_sizes[$size] ) ) {
                $width = $_wp_additional_image_sizes[$size]['width'];
                $height = $_wp_additional_image_sizes[$size]['height'];
            }
        }
        $dimensions = 'width="'.$width.'" height="'.$height.'" ';
        $html = '<img src="http://placehold.it/'.$width.'x'.$height.'"'. $a .' />';
    }
    return $html;
}


/**
 * Imposta immagine di default per il post (caricata tra le opzioni del tema)
 * Vedi 'rp_default_image' tra le opzioni del tema rp_theme_options.php
 */
add_action('save_post','rp_default_thumb_form_options');
function rp_default_thumb_form_options($post_id){

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    $default = get_option('_rp_attached_image');
    $curr = get_post_thumbnail_id($post_id);


    if ( !has_post_thumbnail() && ( ( $default == $curr) || $curr == "" ) ){
        set_post_thumbnail( $post_id, $default );
       // var_dump($curr, $default); die();

    }
}

if ( ! function_exists( 'rp_comment' ) ) :
function rp_comment( $comment, $args, $depth ){
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
            ?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'rp' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'rp' ), '<span class="edit-link">', '</span>' ); ?></p>
                <?php
            break;
        default :
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <?php
                            $avatar_size = 68;
                            if ( '0' != $comment->comment_parent )
                                $avatar_size = 39;

                            echo get_avatar( $comment, $avatar_size );

                            /* translators: 1: comment author, 2: date and time */
                            printf( __( '%1$s on %2$s <span class="says">said:</span>', 'rp' ),
                                sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                                sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    /* translators: 1: date, 2: time */
                                    sprintf( __( '%1$s at %2$s', 'rp' ), get_comment_date(), get_comment_time() )
                                )
                            );
                            ?>

                            <?php edit_comment_link( __( 'Edit', 'rp' ), '<span class="edit-link">', '</span>' ); ?>
                        </div><!-- .comment-author .vcard -->

                        <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'rp' ); ?></em>
                        <br />
                        <?php endif; ?>

                    </footer>

                    <div class="comment-content"><?php comment_text(); ?></div>

                    <div class="reply">
                        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'rp' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div><!-- .reply -->
                </article><!-- #comment-## -->

            <?php
            break;
    endswitch;
}
endif;



if ( ! function_exists( 'rp_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     * Create your own twentyeleven_posted_on to override in a child theme
     *
     * @since Twenty Eleven 1.0
     */
    function rp_posted_on() {
        printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'rp' ),
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'rp' ), get_the_author() ) ),
            get_the_author()
        );
    }
endif;


/**
 * Aggiunge Meta Tag per facebook
 */
add_action('wp_head','rp_add_facebook_metatag');
function rp_add_facebook_metatag() {

    global $post;
    if( is_singular() ):
        $thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'small-thumb' );
        echo '<meta property="og:image" content="' . $thumbnail_url[0] . '"/>';
        echo '<meta property="og:title" content="' . $post->post_title . '"/>';
    endif;

}


add_action('wp_head','rp_socials_init');
function rp_socials_init() {
    ?>

    <!-- Inserisci questa chiamata di rendering dove ritieni appropriato -->
    <script type="text/javascript">
        window.___gcfg = {lang: 'it'};

        (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
    </script>

    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php 
	if( !(is_page(RP_LOGIN_URL_SLUG) || is_page(RP_REGISTER_URL_SLUG) || is_author()) ){

	?>
    <script>
    var appId = <?php echo RP_FACEBOOK_APP_ID ?> ;
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1&appId=" + appId;
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
<?php
	}
}

add_action('the_content','rp_add_socials',1);
function rp_add_socials($content) {
    global $post;

    $title = get_the_title($post->ID);
    $perm = get_permalink($post->ID);

    if ( is_singular() && (!is_page()) ):
    $html = <<< HTML
        <div class="social-share">
            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="it" data-text="{$title}" data-hashtags="Ristoranti Piceni" data-count="horizontal" data-url="{$perm}" > </a>
            <div class="g-plusone" data-size="medium" data-annotation="none" data-href="{$perm}"></div>
            <div class="fb-like" data-href="{$perm}" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
        </div>
HTML;
    endif;
    return $content . $html;
}

add_action('init', 'rp_author_base');
/**
 * Personalizza lo slug della pagina autore
 */
function rp_author_base() {
    global $wp_rewrite;
    $author_slug = 'profilo'; // change slug name
    $wp_rewrite->author_base = $author_slug;
    $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base. '/%author%';
}

add_action('get_header','rp_check_user_status');
/**
 * Check user status
 */
function rp_check_user_status(){
    //Current Wordpress User
    global $user_ID;
    global $facebook;
    global $wpdb;

    if(is_author() || is_page(RP_LOGIN_URL_SLUG) || is_page(RP_REGISTER_URL_SLUG)):


        $register_url = site_url() . "/" . RP_REGISTER_URL_SLUG;

        // Get Facebook User ID
        $user = $facebook->getUser();


        if ($user) { //utente loggato facebook
            try {
                // Sono autenticato
                $user_profile = $facebook->api('/me');

                //Loggaro dsu WP?
                if ( $user_ID ){
                    //var_dump(get_author_posts_url( $user_ID ));


                    if ( get_the_author_meta('id_facebook',$user_ID) != $user_profile['id'] ){
                        $user = null;
                        echo 'Il profilo ha già un utente Facebook associato. Operazioni non possibile, contattare un amministratore';
                        exit();

                    }
                    elseif ( get_the_author_meta('id_facebook',$user_ID) == "" ){
                        update_usermeta( $user_ID, 'id_facebook', $user_profile['id']);
                    }

                    if(!is_author()){
                        wp_redirect( get_author_posts_url( $user_ID ));
                        exit();
                    }
                }
                else{
                    //$current_facebook = $_POST['id_facebook'];
                    //$email = $wpdb->escape($user_profile['email']);
                    $current_facebook = $user_profile['id'];

                    //$user_register_id = email_exists($email);
                    $users = get_users(array('meta_key' => 'id_facebook', 'meta_value' => $current_facebook));
                    if (count($users) == 1){

                    //if ( $user_register_id ){
                        wp_set_auth_cookie( $users[0]->ID );
                        if(!is_author()){
                            wp_redirect(get_author_posts_url( $users[0]->ID ));
                            exit();
                        }
                    }
                    else {
                        if(!is_page(RP_REGISTER_URL_SLUG)){
                        wp_redirect( $register_url );
                        exit();
                        }

                    }
                }

            } catch (FacebookApiException $e) {
                //non sono autenticato
                $user = null;
                wp_redirect( $register_url );
                exit();
            }
        }
        else {
            if( $user_ID ){


                if(!is_author()){
                    wp_redirect( get_author_posts_url( $user_ID ));
                    exit();
                }


            }

        }

    endif;
}


/**
 * @param $content
 * @param $gmap
 * @return string
 *
 * Carica la mappa nelle tab
 * Purtroppo tutta la generazione delle tab adesso avviene qui, per ovviare al bug noto tra UI e Google Maps
 *
 */
function rp_wpgeo_map_js_preoverlays( $content, $gmap ) {

    $js = "";
    if( !is_admin() and is_singular('locali') ):

    $js = <<< JS

    var rp_map = {$gmap}

	$( "#risto-tabs" ).tabs({
        show: function(e, ui) {
                if (ui.index == 1) {
                    google.maps.Event.trigger(rp_map, "resize");
                }
            }
        }).find('#tabslist').fadeIn(1500);

JS;

    endif;
    return $content.$js;
}
add_filter( 'wpgeo_map_js_preoverlays', 'rp_wpgeo_map_js_preoverlays', 10, 2 );


/**
* Custom logo page login.php wp
*/

function rp_custom_login_logo() {
    echo '<style type="text/css">
        .login #login h1 a { background-image:url('.get_bloginfo('template_directory').'/images/ristorantipiceni-logo.png) !important; background-size: 100% auto; height: 100px; }
    </style>';
}

add_action('login_head', 'rp_custom_login_logo');




add_action( 'show_user_profile', 'id_fb_profile_fields' );
add_action( 'edit_user_profile', 'id_fb_profile_fields' );

function id_fb_profile_fields( $user ) {
    ?>

<h3>ID Facebook</h3>

<table class="form-table">

    <tr>
        <th><label for="id_facebook">ID Facebook</label></th>

        <td>
            <input type="text" name="id_facebook" id="id_facebook" value="<?php echo esc_attr( get_the_author_meta( 'id_facebook', $user->ID ) ); ?>" class="regular-text" /><br />

        </td>
    </tr>

</table>
<?php }
?>