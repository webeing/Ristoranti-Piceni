<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

<section id="container" class="row">
	<div id="content" role="main" class="col-left left">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>
        <?php comments_template( '', true );?>
	</div><!-- #content -->
	<?php get_sidebar(); ?>
	<div class="clear"></div>
</section><!-- #container -->

<?php get_footer(); ?>