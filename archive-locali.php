<?php
/**
 * The template for displaying tutti i locali
 */

get_header(); ?>

<section id="container" class="row">
    <div id="content" role="main" class="col-left left">

        <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php if ( is_day() ) : ?>
                <?php printf( __( 'Daily Archives: %s', 'rp' ), '<span>' . get_the_date() . '</span>' ); ?>
                <?php elseif ( is_month() ) : ?>
                <?php printf( __( 'Monthly Archives: %s', 'rp' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'rp' ) ) . '</span>' ); ?>
                <?php elseif ( is_year() ) : ?>
                <?php printf( __( 'Yearly Archives: %s', 'rp' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'rp' ) ) . '</span>' ); ?>
                <?php else : ?>
                <?php _e( 'Tutti i locali', 'rp' ); ?>

                <?php endif; ?>
            </h1>
        </header>
            <?php
            get_template_part( 'content', 'archive-locali' );
            ?>
        <?php else : ?>

        <article id="post-0" class="post no-results not-found">
            <header class="entry-header">
                <h1 class="entry-title"><?php _e( 'Non Trovato', 'rp' ); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <p><?php _e( 'Spiacente, non ci sono contenuti per questo argomento', 'rp' ); ?></p>
                <?php get_search_form(); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-0 -->

        <?php endif;?>
    </div><!-- #content -->
    <?php get_sidebar('Sidebar Blog'); ?>
    <div class="clear"></div>
</section><!-- #container -->

<?php get_footer(); ?>