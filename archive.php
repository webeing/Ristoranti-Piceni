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
						<?php if ( is_day() ) : //Archivio per giorno ?>
							<?php printf( __( 'Daily Archives: %s', 'rp' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : //Archivio per mese?>
							<?php printf( __( 'Monthly Archives: %s', 'rp' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'rp' ) ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : //Archivio per anno?>
							<?php printf( __( 'Yearly Archives: %s', 'rp' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'rp' ) ) . '</span>' );
                        elseif(isset($wp_query->query_vars['post_type']) && ($wp_query->query_vars['post_type'] != "") ): //Archivio per i Post Types (Deprecato)
                            $value = $wp_query->query_vars['post_type'];
                            printf( __( 'Archivio per %s', 'rp' ),"<strong>" . ucwords(str_replace( '-', ' ', $value ) . "</strong>"));

                       else :

                            //Non siamo in nesseuno dei casi precedenti, controllo la tassononomia per valutare se sono in un evento
                            if( isset($wp_query->query_vars['taxonomy'])) :
                                $value = get_query_var($wp_query->query_vars['taxonomy']);
                                if($value==SLUG_EVENTI_NEL_TERRITORIO){
                                $term = "<strong>I prossimi eventi in Provincia</strong>";
                                }
                                elseif($value==SLUG_EVENTI_SPECIALI){
                                $term = "<strong>Scopri le serate organizzate dai locali</strong>";
                                }
                                else{
                                $term = " Archivio <strong>" . ucwords( str_replace( '-', ' ', $value ) ). "</strong>";
                                }


                            elseif(isset($wp_query->query_vars['category_name'])):
                                $value = $wp_query->query_vars['category_name'];
                                $term = "<strong>" . ucwords( str_replace( '-', ' ', $value ) ). "</strong>";

                            else :
                                $term = "Archivio <strong>Blog</strong>";
                            endif;

                        _e( $term, 'rp' );

                        ?>


						<?php endif; ?>
					</h1>
				</header>

				<?php ristorantipiceni_content_nav( 'nav-above' ); ?>
				<br class="clear"/>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
                        if($wp_query->query_vars['category_name']=="blog"):
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */

                        get_template_part( 'content', 'archive' );
                    else:
                        get_template_part( 'content', 'archive-eventi' );
                    endif;

					?>

				<?php endwhile; ?>

				<br class="clear"/>
				<?php ristorantipiceni_content_nav( 'nav-below' ); ?>
				<br class="clear"/>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Non ci sono ancora elementi da visualizzare', 'rp' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
                        <p><?php _e( 'Spiacente, non ci sono contenuti per questo argomento', 'rp' ); ?></p>
                        <?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
                <?php get_sidebar('Sidebar Blog'); ?>
            <div class="clear"></div>
		</section><!-- #container -->
<?php get_footer(); ?>