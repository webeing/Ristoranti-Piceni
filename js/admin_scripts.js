/******************************************************************************************************************/
// SLIDER
/******************************************************************************************************************/
jQuery(document).ready(function(){
    /*
    jQuery( "#rp_start_datetime_id" ).datetimepicker({
        dateFormat: 'dd/mm/yy',
        defaultDate: "+1d",
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            jQuery( "#rp_end_datetime_id" ).datetimepicker( "option", "minDate", selectedDate );
        }
    });
    jQuery( "#rp_end_datetime_id" ).datepicker({
        dateFormat: 'dd/mm/yy',
        defaultDate: "+1d",
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            jQuery( "#rp_start_datetime_id" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
    */
    jQuery('#rp_start_datetime_id').datetimepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function( selectedDate ) {
            jQuery( "#rp_end_datetime_id" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    jQuery('#rp_end_datetime_id').datetimepicker({
        dateFormat: 'dd/mm/yy',
        onSelect: function( selectedDate ) {
            jQuery( "#rp_start_datetime_id" ).datepicker( "option", "maxDate", selectedDate );
        }
    });

 });

