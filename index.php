<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Ristoranti Piceni
 */

get_header(); ?>

		<section id="container" class="row">
			<div id="content" role="main" class="col-left left">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

			<?php else : ?>
				<?php wp_redirect( home_url(), 404); ?>

				<?php /*
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Non abbiamo trovato nulla', 'rp' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Spiacente, ma non sono stati trovati risultati. Utilizza la ricerca per trovare quel che cercavi.', 'rp' ); ?></p>
						<?php //get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
				*/ ?>
			<?php endif; ?>

			</div><!-- #content -->
						
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</section><!-- #container -->
<?php get_footer(); ?>