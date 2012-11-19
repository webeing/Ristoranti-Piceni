<div id="tabs" class="clear">

    <div id="tabs-info">
        <section id="risto-info">
            <h4 class="ribbon">
                 <?php echo $rp_tipologia = get_the_term_list($post->ID, 'tipologia');?>
            </h4>
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
                <a id="action-ristoratore" class="btn block dark" href="<?php bloginfo('template_url') ?>/sei-un-ristoratore" title="Sei un ristoratore">Sei un ristoratore? <br/>Iscrivi anche il tuo ristorante</a>
            </div>
            <div class="clear"></div>
        </section>





    </div>







</div>