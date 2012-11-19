<?php
/**
 * The main template file.
 *
* @package WordPress
* @subpackage Ristoranti Piceni
* @since Ristoranti Piceni 1.0
 */
?>
<?php get_header(); ?>

<?php // Add Evidence area Home ?>
<?php get_template_part( 'section', 'evidence-top-home' ); ?>

<?php // Add Evidence area Home ?>
<?php get_template_part( 'section', 'evidence-middle-home' ); ?>

<section id="section-footer" class="row">
	<?php dynamic_sidebar( 'Home Bottom Sidebar' ); ?>
	<div class="clear"></div>
</section>

<?php get_footer(); ?>