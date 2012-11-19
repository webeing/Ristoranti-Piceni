<?php
/**
 * The template used for displaying page content in single.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title title"><?php the_title(); ?></h1>

	</header><!-- .entry-header -->

	<div class="entry-content">
        <span class="meta-info"><?php rp_posted_on();?></span>
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'rp' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
