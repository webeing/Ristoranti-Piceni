<?php
/**
 * The template used for displaying Custom Post Type "Ristorante" *
 */

$default_attr = array(
    'alt' => get_the_title(),
    'title'=> get_the_title()
);
?>

    <div id="logo" class="left">
        <?php // the_post_thumbnail( 'small-thumb', $default_attr);?>
        <?php the_post_thumbnail('thumb-logo', $default_attr); ?>
    </div>
    <div class="left info-top">
        <h2 class="title">
            <?php the_title();?>
        </h2>
        <div id="indirizzo">
            <?php echo get_post_meta( $post->ID, 'rp_scheda_indirizzo_saved', true);?>
            <?php echo get_post_meta( $post->ID, 'rp_scheda_citta_saved', true);?>
            - (<?php echo get_post_meta( $post->ID, 'rp_scheda_prov_saved', true);?>)
        </div>
        <div class="clear"></div>
    </div>