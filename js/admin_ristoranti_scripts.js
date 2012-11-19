/******************************************************************************************************************/
//Eventi
/******************************************************************************************************************/
jQuery(document).ready(function($){

    $('#rp_scheda_indirizzo_id').keyup(function(){
       txt = $(this).val();
        txt += ', ' + $('#rp_scheda_citta_id').val();
        $('#wp_geo_search').val(txt);
        $("#search_button_ristoranti_id").click(function(){$('#wp_geo_search_button').trigger('click');})


    });

    $('#rp_scheda_citta_id').keyup(function(){
        txt = $(this).val();
        txt = $('#rp_scheda_indirizzo_id').val() + ', ' + txt;
        $('#wp_geo_search').val(txt);
        $("#search_button_ristoranti_id").click(function(){$('#wp_geo_search_button').trigger('click');})
    });


 });

