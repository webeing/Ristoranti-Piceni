<?php
/**
 * The template for displaying content in the section-slider.php template
 **/
?>
<li class="type-slide">
	<div class="single-slide">
		<a href="#" title="">
            <?php $default_attr = array(
            'alt'	=> get_the_title(),
            'title'	=> get_the_title()
            );
            the_post_thumbnail( 'slider-feature', $default_attr );?>
		</a>
    <?php $rp_spunta = get_post_meta(get_the_ID(), "rp_slider_check", true);

    if ($rp_spunta==1){?>
		<div class="claim-slide <?php echo get_post_meta(get_the_ID(), "rp_align", true); ?>">
			<?php the_content(); ?>
            <br class="clear"/>
			<a class="btn" href="<?php echo get_post_meta(get_the_ID(), "rp_slider_link", true);?>"><?php echo get_post_meta(get_the_ID(), "rp_slider_label_link", true);?></a>
		</div>
    <?php } ?>
	</div>
</li>



