<?php 
/*
* The template for displaying section slider
*/
?>

    <!-- start slider -->
    <section id="header-container" class="row">

<?php

if ( (is_home() || is_front_page() ) ){
    $rp_slider_arg = array(
        'post_type'=> 'rp_slider',
        'posts_per_page' => 5,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    // The Query slider
    query_posts( $rp_slider_arg );
    ?>

        <div id="nav-slider">
            <a id="prev" href="#">prev</a>
            <a id="next" href="#">next</a>
        </div>
        <ul id="slider-gallery">
            <?php while ( have_posts() ) : the_post();?>
            <?php get_template_part( 'content', 'slider' ); ?>
            <?php endwhile;
            wp_reset_query(); ?>
        </ul>
<?php } elseif( is_singular('locali') && ( get_post_meta($post->ID,'rp_scheda_sottoscritto_saved',true) == 1 ) ){?>

        <?php
            global $post, $nggdb;
            $gallery_id = get_post_meta($post->ID,'rp_scheda_gallery',true);
            echo do_shortcode('[nggallery id=' . $gallery_id .' template=slider_carousel]');
        ?>
<?php }

elseif(get_post_meta($post->ID,'rp_custom_header_image_id',true)){
    ?>
    <div id="thumb-gallery">
        <?php
           // $thumb_id = get_option('_rp_attached_header_image');
            $default_attr = array(
                'class'	=> "attachment",
            );

            $thumb_id = get_post_meta($post->ID,'rp_custom_header_image_id',true);

            echo wp_get_attachment_image( $thumb_id, 'slider-feature-secondary', $default_attr );
        ?>
    </div>
<?php }

elseif (is_tax(SLUG_EVENTI_NEL_TERRITORIO ) ) { ?>

            <div id="thumb-gallery">
            <img class="attachment-slider-feature-secondary" width="925" height="230" title="Uploaded image Ristoranti Piceni Header Thumb" alt="Uploaded image Ristoranti Piceni Header Thumb" src="<?php bloginfo('url');?>/wp-content/uploads/2012/10/default-thumb-rp.png">
            </div>

<?php } elseif (is_tax(SLUG_EVENTI_SPECIALI)) {?>
            <div id="thumb-gallery">
            <img class="attachment-slider-feature-secondary" width="925" height="230" title="Uploaded image Ristoranti Piceni Header Thumb" alt="Uploaded image Ristoranti Piceni Header Thumb" src="<?php bloginfo('url');?>/wp-content/uploads/2012/10/default-thumb-rp.png">
            </div>
        <?php }

elseif (is_category('blog')) {?>
            <div id="thumb-gallery">
            <img class="attachment-slider-feature-secondary" width="925" height="230" title="Uploaded image Ristoranti Piceni Header Thumb" alt="Uploaded image Ristoranti Piceni Header Thumb" src="<?php bloginfo('url');?>/wp-content/uploads/2012/11/PICENO3.jpg">
            </div>
        <?php }
else{?>
            <div id="thumb-gallery">
            <img class="attachment-slider-feature-secondary" width="925" height="230" title="Uploaded image Ristoranti Piceni Header Thumb" alt="Uploaded image Ristoranti Piceni Header Thumb" src="<?php bloginfo('url');?>/wp-content/uploads/2012/11/PICENO41.jpg">
            </div>
 <?php }?>

    </section>
    <!-- end slider -->
