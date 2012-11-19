<?php
/*
Template Name: Scheda Ristorante
*/

get_header(); ?>


<section id="container" class="row">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'section', 'ristorante' ); ?>

		<?php endwhile; // end of the loop. ?>

	<div class="clear"></div>
</section><!-- #container -->

<?php get_footer(); ?>