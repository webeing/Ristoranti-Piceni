<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('archive-post'); ?>>
	<header class="entry-header">
        <?php the_post_thumbnail('archive-thumb', array('class' => 'alignleft thumb')); ?>
		<h2 class="entry-title title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <time itemprop="dataevento" datetime="<?php echo get_post_meta($post->ID,'rp_start_datetime_saved',true);?>">
            <?php echo get_post_meta($post->ID,'rp_start_datetime_saved',true);?>
        </time>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_excerpt(); ?>
        <br/>
        <a class="btn brown right" href="<?php the_permalink(); ?>" title="Vai a <?php the_title(); ?>">Leggi tutto &raquo;</a>
        <div class="clear"></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
