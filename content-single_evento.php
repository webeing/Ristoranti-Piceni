<?php
/**
 * The template used for displaying page content in single-rp_eventi.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> xmlns="http://www.w3.org/1999/html">
	<header class="entry-header">
        <div id="foto_evento" class="alignleft">
            <?php
            $default_attr = array(
                'alt' => get_the_title()
            );
            the_post_thumbnail( 'slider-thumb-feature', $default_attr );
            ?>
        </div>
		<h2 class="entry-title"><?php the_title(); ?></h2>

        <ul class="info-date left">
            <?php if(get_post_meta($post->ID,'rp_start_datetime_saved',true)){ ?>
            <li><span class="data">dal: </span>
                <time class="data_value">
                    <?php echo get_post_meta($post->ID,'rp_start_datetime_saved',true);?>
                </time>
            </li>
            <?php } ?>
            <?php if(get_post_meta($post->ID,'rp_end_datetime_saved',true)){ ?>
            <li><span class="data">al: </span>
                <time class="data_value">
                    <?php echo get_post_meta($post->ID,'rp_end_datetime_saved',true);?>
                </time>
            </li>
            <?php } ?>
            <br class="clear"/>
        </ul>
        <div class="info-luogo left">
            <?php $rp_id_ristorante = get_post_meta($post->ID,'rp_partner_restaurant_saved',true);
            if (get_post_meta($rp_id_ristorante,'rp_scheda_indirizzo_saved',true)){?>
            Luogo: <?php echo get_post_meta($rp_id_ristorante,'rp_scheda_indirizzo_saved',true);
            ?> - <?php echo get_post_meta($rp_id_ristorante,'rp_scheda_citta_saved',true);?> (<?php echo get_post_meta( $rp_id_ristorante, 'rp_scheda_prov_saved', true);?>)
            <br/>Presso: <a href="<?php echo get_permalink( $rp_id_ristorante ); ?>" title="<?php echo get_the_title( $rp_id_ristorante ); ?>"><?php echo get_the_title( $rp_id_ristorante ); ?></a>
            <?php }?>

            <?php if (get_post_meta($post->ID,'rp_evento_indirizzo_saved',true)){?>
                Luogo: <?php echo get_post_meta($post->ID,'rp_evento_indirizzo_saved',true);
                ?> - <?php echo get_post_meta($post->ID,'rp_evento_citta_saved',true);?> (<?php echo get_post_meta( $post->ID, 'rp_evento_prov_saved', true);?>)
                <?php }?>
        </div>
    </header><!-- .entry-header -->


        <?php if ( function_exists( 'wpgeo_post_map' ) ) wpgeo_post_map(); ?>


    <div class="entry-content clear">
        <?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'rp' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
