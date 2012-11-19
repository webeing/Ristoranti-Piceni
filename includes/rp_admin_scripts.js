/**
 * Created with JetBrains PhpStorm.
 * User: Webeing.net
 * Date: 16/10/12
 * Time: 09:45
 * To change this template use File | Settings | File Templates.
 */
jQuery(document).ready(function(){
    jQuery('.rp_options').slideUp();
    jQuery('.rp_section h3').click(function(){
        if(jQuery(this).parent().next('.rp_options').css('display')==='none')
        {	
            jQuery(this).removeClass('inactive').addClass('active').children('img').removeClass('inactive').addClass('active');
        }
        else
        {	
            jQuery(this).removeClass('active').addClass('inactive').children('img').removeClass('active').addClass('inactive');
        }
        jQuery(this).parent().next('.rp_options').slideToggle('slow');
    });

    jQuery('#rp_postion_a').change(function(){
        var value = jQuery(this).val();
        jQuery.post(
            ajaxurl,
            {
                'action':'rp_ajax_contents_for',
                'data': value
            },
            function(response){
                if ( value == "page" || value == "post" )
                    jQuery('#rp_postion_a_content').html(response);
                else
                    jQuery('#rp_postion_a_content').parent().html(response);
            }
        );
    });
});
