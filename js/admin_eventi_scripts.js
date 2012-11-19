/******************************************************************************************************************/
//Eventi
/******************************************************************************************************************/
jQuery(document).ready(function($){

    $('#rp_evento_indirizzo_id').keyup(function(){
       txt = $(this).val();
        txt += ', ' + $('#rp_evento_citta_id').val();
        $('#wp_geo_search').val(txt);
        $("#search_button_evento_id").click(function(){$('#wp_geo_search_button').trigger('click');})


    });

    $('#rp_evento_citta_id').keyup(function(){
        txt = $(this).val();
        txt = $('#rp_evento_indirizzo_id').val() + ', ' + txt;
        $('#wp_geo_search').val(txt);
        $("#search_button_evento_id").click(function(){$('#wp_geo_search_button').trigger('click');})
    });


 });

