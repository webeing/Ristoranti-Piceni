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
			<?php 
				query_posts( 'page_id=568' );
				if ( have_posts() ) : 
				while ( have_posts() ) : the_post();
			 ?>
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php the_content(); ?></p>
						<?php //get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
				
				<?php endwhile; endif; ?>
			</div><!-- #content -->
						
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</section><!-- #container -->
<?php get_footer(); ?>