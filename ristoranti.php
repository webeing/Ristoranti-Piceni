<?php
/*
Template Name: Ristoranti
*/

get_header(); ?>
<?php // Add Slider Home ?>
<?php get_template_part( 'section', 'slider' ); ?>

<section id="container" class="row">
	<div id="content" role="main" class="col-left left">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
	<aside id="sidebar" class="right">
		<?php dynamic_sidebar('Sidebar Page'); ?>
	</aside>
	<div class="clear"></div>
</section><!-- #container -->

<?php get_footer(); ?>