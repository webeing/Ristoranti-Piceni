<div id="risto-tabs" class="clear">
    <ul id="tabslist">
        <li><a href="#tabs-info">Info</a></li>
        <li><a id="map-tab" href="#tabs-mappa">Mappa</a></li>
        <li><a href="#tabs-menu">Menu</a></li>
        <li><a href="#tabs-serate-speciali">Serate Speciali</a></li>
        <?php if(get_post_meta( $post->ID, 'rp_scheda_prenotazione_saved', true)==1):?>
        <li><a href="#tabs-prenotazione">Prenotazioni</a></li>
        <?php endif;?>
    </ul>
    <div id="tabs-info">
        <section id="risto-info">
            <?php  $rp_termine_scheda = wp_get_post_terms( $post->ID, 'tipologia',array("fields" => "all"));
            //echo $rp_tipologia = get_the_term_list($post->ID, 'tipologia');
            ?>
            <h4 class="ribbon <?php echo $rp_termine_scheda[0]->slug ?>"><span><?php echo $rp_termine_scheda[0]->name ?></span></h4>
            <div class="left">
                <h2 id="title-tab-info" class="title"><?php the_title();?></h2>
                <div id="indirizzo-tab-info">
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_indirizzo_saved', true);?>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_citta_saved', true);?>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_cap_saved', true);?>
                    - (<?php echo get_post_meta( $post->ID, 'rp_scheda_prov_saved', true);?>)
                </div>
                <div id="telefono-tab-info">
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_tel_saved', true);?>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_cel_saved', true);?>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_fax_saved', true);?>
                </div>
                <div id="mail-tab-info">
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_mail_saved', true);?>
                </div>
                <div id="sito-tab-info">
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_sito_saved', true);?>
                </div>

            </div><!--/left -->
            <div class="right">
                <a id="map-link" href="#tabs-mappa" title="Vai alla mappa del locale <?php the_title(); ?>">
                    <img src="<?php bloginfo('template_url') ?>/images/map-link-img.png" alt="Vai alla mappa del locale <?php the_title(); ?>"/>
                </a>
                <div class="clear"></div>
                <ul id="social-tab-info">
                    <?php if(get_post_meta( $post->ID, 'rp_scheda_facebook_saved', true)):?>
                    <li class="facebook-rp"><a href="<?php echo get_post_meta( $post->ID, 'rp_scheda_facebook_saved', true);?>" target="_blank" title="Segui <?php the_title(); ?> su Facebook" target="_blank"></a></li>
                    <?php endif; ?>
                    <?php if(get_post_meta( $post->ID, 'rp_scheda_twitter_saved', true)):?>
                    <li class="twitter-rp"><a href="<?php echo get_post_meta( $post->ID, 'rp_scheda_twitter_saved', true);?>" target="_blank" title="Segui <?php the_title(); ?> su Twitter" target="_blank"></a></li>
                    <?php endif; ?>
                    <?php if(get_post_meta( $post->ID, 'rp_scheda_google_saved', true)):?>
                    <li class="google-rp"><a href="<?php echo get_post_meta( $post->ID, 'rp_scheda_google_saved', true);?>" target="_blank" title="Segui <?php the_title(); ?> su Google+" target="_blank"></a></li>
                    <?php endif; ?>
                    <?php if(get_post_meta( $post->ID, 'rp_scheda_youtube_saved', true)):?>
                    <li class="youtube-rp"><a href="<?php echo get_post_meta( $post->ID, 'rp_scheda_youtube_saved', true);?>" target="_blank" title="Segui <?php the_title();?> su Youtube"  target="_blank"></a></li>
                    <?php endif; ?>
                    <?php if(get_post_meta( $post->ID, 'rp_scheda_instagram_saved', true)):?>
                    <li class="instagram-rp"><a href="<?php echo get_post_meta( $post->ID, 'rp_scheda_instagram_saved', true);?>" target="_blank" title="Segui <?the_title(); ?> su Instagram" target="_blank"></a></li>
                    <?php endif; ?>
                    <?php if(get_post_meta( $post->ID, 'rp_scheda_skype_saved', true)):?>
                    <li class="skype-rp"><a href="<?php echo get_post_meta( $post->ID, 'rp_scheda_skype_saved', true);?>" target="_blank" title="Contatta <?php the_title(); ?> su Skype" target="_blank"></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="clear"></div>
        </section>
        <section id="info-type" class="meta">
            <div id="tipo-rp">
                <h4 class="title"><?php _e('Tipo di cucina', 'rp') ?></h4>
                <ul>
                    <?php echo get_the_term_list($post->ID,'tipo_cucina', '<li>', '</li><li>', '</li>');?>
                </ul>
            </div>
            <div id="ambiente-rp">
                <h4 class="title"><?php _e('Ambiente', 'rp') ?></h4>
                <ul>
                    <?php echo get_the_term_list($post->ID,'ambiente', '<li>', '</li><li>', '</li>');?>

                </ul>
            </div>
            <br class="clear"/>
        </section>
        <section id="coperto-tab-info">
            <ul>
                <li><span class="title"><?php _e( 'Coperti totali: ', 'rp' );?></span>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_coperti_totali_saved', true);?></li>
                <li><span class="title"><?php   _e( 'Coperti estivi: ', 'rp' );?></span>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_coperti_estivi_saved', true);?></li>
                <br class="clear"/>
            </ul>
        </section>
        <section id="prezzo-menu-tab-info">
            <ul>
                <li><span class="title">
                    <?php  _e( 'Prezzo medio menu: ', 'rp' );?>
                    </span>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_prezzo_medio_menu_saved', true);?></li>
            </ul>
        </section>
        <section id="chiusura">
            <ul>
                <li><span class="title"><?php _e( 'Chiusura settimanale: ', 'rp' );?></span>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_chiusura_settimanale_saved', true);?></li>
                <li><span class="title"><?php   _e( 'Chiusura per ferie: ', 'rp' );?></span>
                    <?php echo get_post_meta( $post->ID, 'rp_scheda_chiusura_per_ferie_saved', true);?></li>
            </ul>
        </section>
        <br class="clear"/>
        <h2 class="title"><?php   _e( 'Il Locale', 'rp' );?></h2><br class="clear"/>
        <div id="content-tab-info">
            <?php echo the_content();?>
        </div>
        <br class="clear"/>
        <a id="service-rp" class="btn brown" href="#dialog-service-rp" title="<?php _e('Scopri i servizi... ', 'rp') ;?>"><img src="<?php bloginfo('template_url') ?>/images/info.png" alt="<?php _e('Scopri i servizi... ', 'rp') ;?>"/> <?php  _e( 'Scopri i servizi... ', 'rp' ) ;?></a>
        <div id="dialog-service-rp">
            <ul>
                <?php $rp_terms = wp_get_post_terms($post->ID, 'servizio');
                    if(count($rp_terms)>0){
                    foreach ( $rp_terms as $rp_term){
                        ?>
                               <li>
                                <img src="<?php bloginfo('template_url') ?>/images/services/<?php echo $rp_term->name; ?>.png"/>
                                <a rel="<?php echo $rp_term->name; ?>" href="<?php bloginfo('url') ?>/servizio/<?php echo $rp_term->name; ?>/"><?php echo $rp_term->name; ?></a>
                               </li>
                    <?php }
                    } else {?>
                                <?php _e( 'Nessun servizio specificato', 'rp' );?>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div id="tabs-menu">
        <?php
        $menu_content = apply_filters( 'the_content', get_post_meta( $post->ID, 'rp_info_menu_saved', true));
        echo $menu_content;?>
    </div>

    <div id="tabs-mappa">

        <?php include_once TEMPLATEPATH . "/includes/mappa.php"; ?>
    </div>

    <?php
    $rp_args = array(

        'order' => 'DESC',
        'posts_per_page' => -1,
        'post_type' => 'rp_eventi',
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie_evento',
                'field' => 'term_id',
                'terms' => RP_EVENTI_SPECIALI_ID
            )
        )
    );
    ?>

    <div id="tabs-serate-speciali">
        <?php
        query_posts($rp_args);

        $rp_id_ristorante = $post->ID;
        ristorantipiceni_content_nav( 'nav-above' );

        while ( have_posts() ) : the_post();


            if(get_post_meta(get_the_ID(),'rp_partner_restaurant_saved',true)==$rp_id_ristorante):
                get_template_part( 'content', 'archive-eventi' );
            endif;

        endwhile;

        ristorantipiceni_content_nav( 'nav-below' );
        wp_reset_query();
        ?>

    </div>
    <?php if(get_post_meta( $post->ID, 'rp_scheda_prenotazione_saved', true)==1):?>
    <div id="tabs-prenotazione">

        <?php
        echo do_shortcode('[contact-form-7 id="376" title="Prenotazioni"]'); ?>
    </div>
    <?php endif;?>
</div>