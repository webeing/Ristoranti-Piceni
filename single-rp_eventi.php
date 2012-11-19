<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

<section id="container" class="row">
    <div id="content" role="main" class="col-left left">

        <?php while ( have_posts() ) : the_post(); ?>

        <?php echo  get_template_part( 'content', 'single_evento' ); ?>

        <?php endwhile; // end of the loop. ?>

    </div><!-- #content -->
    <?php get_sidebar('page'); ?>
    <div class="clear"></div>
</section><!-- #container -->

<?php get_footer(); ?>