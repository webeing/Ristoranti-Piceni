<?php
/**
 * content archivio locali
 */
wp_reset_query();

$rp_term_args = array(
'order' => 'ASC',
'orderby' => 'rand',
'posts_per_page' => -1,
'post_type' => 'locali'
);
?>

<?php query_posts($rp_term_args);?>

    <ul class="list-rp">
    <?php while ( have_posts() ) : the_post(); ?>
    <?php if(get_post_meta(get_the_ID(), 'rp_scheda_sottoscritto_saved', true)==1):?>
        <li class="sottoscritto">
            <a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>"><?php the_title();?></a>
                <span>
                <?php echo get_post_meta( get_the_ID(), 'rp_scheda_indirizzo_saved', true) . ' ';
                    echo get_post_meta( get_the_ID(), 'rp_scheda_citta_saved', true). ' ';
                    echo get_post_meta( get_the_ID(), 'rp_scheda_cap_saved', true). ' ';
                    if(get_post_meta(get_the_ID(), 'rp_scheda_prov_saved', true)){?>
                        - (<?php echo get_post_meta(get_the_ID(), 'rp_scheda_prov_saved', true);?>)
                        <?php } ?>
                </span>
        </li>
        <?php endif;?>
    <?php endwhile;?>
    <?php while ( have_posts() ) : the_post(); ?>
    <?php if(get_post_meta(get_the_ID(), 'rp_scheda_sottoscritto_saved', true)==0):?>
        <li>
            <a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>"><?php the_title();?></a>
                <span>
                <?php echo get_post_meta( get_the_ID(), 'rp_scheda_indirizzo_saved', true). ' ';
                    echo get_post_meta( get_the_ID(), 'rp_scheda_citta_saved', true). ' ';
                    echo get_post_meta( get_the_ID(), 'rp_scheda_cap_saved', true). ' ';
                    if(get_post_meta(get_the_ID(), 'rp_scheda_prov_saved', true)){?>
                        - (<?php echo get_post_meta(get_the_ID(), 'rp_scheda_prov_saved', true);?>)
                        <?php } ?>
                </span>
        </li>
        <?php endif;?>
    <?php endwhile;?>
    </ul>


<?php
wp_reset_query();
?>