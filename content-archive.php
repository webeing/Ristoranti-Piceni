<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('archive-post'); ?>>
	<header class="entry-header">
        <?php the_post_thumbnail('archive-thumb', array('class' => 'alignleft thumb')); ?>
		<h2 class="entry-title title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	</header><!-- .entry-header -->

	<div class="entry-content">
        <span class="meta-info"><?php rp_posted_on();?></span>
		<?php the_excerpt(); ?>

        <a class="btn brown right" href="<?php the_permalink(); ?>" title="Vai a <?php the_title(); ?>">Leggi tutto &raquo;</a>
        <div class="clear"></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
