<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

</div> <!--wrap-->
<footer id="colophon" role="contentinfo">
	<section class="row inner">
		<?php
			/* A sidebar in the footer? Yep. You can can customize
			 * your footer with three columns of widgets.
			 */
			if ( ! is_404() )
				dynamic_sidebar( 'Footerone Sidebar' );
		?>

		<div id="site-generator">
			<?php
            echo get_option('rp_footer_text'); //Stampo i dati delle opzioni per il tema

            do_action( 'ristorantipiceni_credits' );
            ?>
		</div>
	</section>
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>