<?php
/*
 * Template Name: Mappa
 */
get_header();?>

<section id="container" class="row">
	<div id="content" role="main" class="col-left left">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

		<?php endwhile; // end of the loop.
        wp_reset_query();
        $args = array(
            'post_type'=> 'locali',
            'order'    => 'ASC',
            'center' => array(
               'latitude' => '42.8538',
               'longitude' => '13.5766',
            ),
            'zoom'=> 11,
            'height'=> '400',
            'meta_query' => array(
                array(
                    'key' => 'rp_scheda_sottoscritto_saved',
                    'value' => 1,
                    'compare' => '='
                )
            )
        );

    ?>
       <div class="clear"></div>

       <?php  if ( function_exists( 'wpgeo_map' ) ) wpgeo_map($args);
        ?>

   <ul>
       <?php
       query_posts($args);
       while ( have_posts() ) : the_post(); ?>
       <li>
        <h3 class="title"><?php the_title(); ?></h3>
        <span>
            <?php echo get_post_meta( get_the_ID(), 'rp_scheda_indirizzo_saved', true); ?> -
            <?php echo get_post_meta( get_the_ID(), 'rp_scheda_cap_saved', true);?>
            <?php echo get_post_meta( get_the_ID(), 'rp_scheda_citta_saved', true);?>
        </span>
        <a class="btn brown" title="vai alla scheda" href="<?php the_permalink(); ?>"><?php _e( 'Vai alla scheda', 'rp' );?></a>
       </li>
       <?php endwhile;?>
   </ul>


	</div><!-- #content -->

    <?php /*
	<aside id="sidebar" class="right">
		<?php dynamic_sidebar('Sidebar Page'); ?>
	</aside>
	<div class="clear"></div>
</section><!-- #container -->
    */ ?>
<?php get_sidebar('-page'); ?>
    <div class="clear"></div>
</section><!-- #container -->
<?php get_footer(); ?>