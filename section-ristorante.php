<?php
/* Template per le schede ristoranti
 */
?>
    <div id="content" class="col-card left" role="main">
          <?php get_template_part( 'ristorante', 'top' );

          if(get_post_meta( $post->ID, 'rp_scheda_sottoscritto_saved', true)==1):
            get_template_part( 'ristorante', 'middle' );
          else:
            get_template_part( 'ristorante', 'middle_no_auth' );
          endif;
          get_template_part( 'ristorante', 'bottom' ); ?>
    </div><!-- #content-->
	<?php get_sidebar('Ristorante'); ?>
	<div class="clear"></div>
    </section>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'rp' ) . '</span>', 'after' => '</div>' ) ); ?>
