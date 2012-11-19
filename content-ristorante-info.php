<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<section class="brand-rp row">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			  the_post_thumbnail('slider-thumb-feature', array('class' => 'alignleft'));
			} 
			?>
			<h2 class="title"><?php the_title(); ?></h2>
		</header><!-- .entry-header -->
	
		<div class="entry-content">
			
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	
	</article><!-- #post-<?php the_ID(); ?> -->
	
	<aside id="sidebar-top" class="right">
		<?php dynamic_sidebar('Top Scheda Ristorante'); ?>
	</aside>
	<div class="clear"></div>
</section>