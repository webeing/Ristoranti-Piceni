<?php 
/*
* The template for displaying middle section home
*/
?>

<!-- start area evidence-top -->
<section id="evidence-top" class="row">
	<div id="mangia-gratis" class="left">
        <?php //dynamic_sidebar('Home Top Left'); ?>
        <?php
        $element_option = get_option('rp_postion_a_content');
        $element_option_type = get_option('rp_postion_a');
        if ( is_numeric($element_option)  ) :
            $args = array (
                'p'=>$element_option,
                'post_type'=>$element_option_type
            );
            query_posts($args);

            if (have_posts()) : while (have_posts()) : the_post();
                ?>

                <h2 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <div class="content">
                    <?php the_post_thumbnail('', array('class' => 'alignleft')); ?>
                    <?php the_excerpt(); ?>
                    <br class="clear"/>
                    <?php /*<a class="btn right" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Scopri come fare &raquo;</a>
                    */ ?>
                    <div class="clear"></div>
                </div>

                <?php endwhile; endif; wp_reset_query();

        else:
            //@todo Contemplare gli altri casi, ad esempio Widget e Testo/HTML libero
        endif;
        ?>

		<div class="clear"></div>
		<?php /*
        <section class="newsletter">
			<p class="left">Se vuoi rimanere sempre informato sulla nostre iniziative e promozioni vantaggiose, <strong>iscriviti alla newsletter</strong>!</p>
			<form class="right" action="#">
				<fieldset>
					<label for="nl">Indirizzo e-mail</label>
					<input id="nl" type="text" class="text" value="">
					<input type="submit" class="submit btn" value="Iscriviti ora &raquo;">
				</fieldset>
				<a title="privacy" href="#"><small>Condizioni e privacy</small></a>
			</form>
		</section>
        */ ?>
	</div>
	
	<div id="add-restourant" class="right">
        <?php dynamic_sidebar('Home Top Right'); ?>
	</div>
	<div class="clear"></div>
</section>
<!-- end area evidence-top -->