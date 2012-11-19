<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
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
							<?php _e( 'Archivio per eventi', 'rp' ); ?>

						<?php endif; ?>
					</h1>
				</header>

				<?php ristorantipiceni_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */

                ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'archive-eventi' );
					?>

				<?php endwhile; ?>

				<?php ristorantipiceni_content_nav( 'nav-below' ); ?>

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

			<?php endif;
            if ($_GET['past']=='true'):?>
                <a href="<?php bloginfo('url')?>/eventi/" title="Eventi in programma">Eventi in programma</a>
            <?php else: ?>
                <a href="<?php bloginfo('url')?>/eventi/?past=true" title="Eventi passati">Eventi passati</a>
            <?php endif; ?>
            </div><!-- #content -->
                <?php get_sidebar('Sidebar Blog'); ?>
            <div class="clear"></div>
		</section><!-- #container -->

<?php get_footer(); ?>