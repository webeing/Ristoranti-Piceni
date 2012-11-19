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
            <?php
                $txt = "Ricerca ";
                $term = get_term_by('id',$_GET['rp_search_tipologia'],'tipologia',ARRAY_A);
                if ($_GET['s'] && $_GET['s']!="Ricerca") $txt .= " per '" . $_GET['s'] . "'";
                if ($_GET['rp_search_tipologia']) $txt .= " (in " . $term['name'] . ") ";
                if ($_GET['rp_search_localita']) $txt .= " a " . $_GET['rp_search_localita'];

            ?>

				<header class="page-header">
					<h1 class="page-title"><?php echo $txt ?></h1>
				</header>

				<?php ristorantipiceni_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
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
						<h1 class="entry-title"><?php _e( 'Nessun risultato per la ricerca', 'rp' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rp' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
                <?php get_sidebar('Sidebar Blog'); ?>
            <div class="clear"></div>
		</section><!-- #container -->

<?php get_footer(); ?>