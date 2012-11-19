<?php
/**
 * Created by Webeing.net
 * User: Webeing.net
 * Date: 24/10/12
 * Time: 18:34
 */
?>
<script type="text/javascript">jQuery(document).ready(function($){
    v = $('#s').val();
    $('#s').focus(function(){
        $(this).val('');
    });
    $('#s').blur(function(){
        if ($(this).val() != "") v = $(this).val();
        $(this).val(v);
    });
});
</script>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
        <input type="text" value="Ricerca" name="s" id="s" />
        <div id="search_extra_fields">
            <label>Cerchi un locale? Perfeziona la ricerca </label>
            <?php do_action('rp_search_extra_fields') ?>
            <input class="btn" type="submit" id="searchsubmit" value="<?php _e('Trova Ristorante','rp') ?>" />
        </div>
    </div>
</form>