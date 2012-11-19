<?php
/**
* Tab Mappa per scheda ristorante
*/
?>


    <?php
    //wpgeo_post_map($_POST['p']);
    //query_post('p=' . $_POST['p'] );
    //var_dump($_GET['p']);
    if ( function_exists( 'wpgeo_map' ) ){
     //while ( have_posts() ) : the_post();

        wpgeo_post_map();

    //endwhile;
    }
    ?>
    <br class="clear"/>
    <a class="btn brown right" href="/mappa-dei-locali/" title="<?php _e('Mappa generale','rp') ?>"><?php _e('Mappa generale &raquo;','rp') ?></a>
    <br class="clear"/>