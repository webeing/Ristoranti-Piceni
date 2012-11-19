/******************************************************************************************************************/
// SLIDER
/******************************************************************************************************************/
jQuery(document).ready(function($){
    $('#slider-gallery li').not(':first-child').hide();
	 $('#slider-gallery').delay(3000).fadeIn(1000, function() {

         $('#slider-gallery').cycle({
             fx:     'scrollLeft',
             speed:  500,
             timeout: 4000,
             pause:   1,
             next:   '#next',
             prev:   '#prev'
         });
    });

/*
* Purtroppo tutta la generazione delle tab adesso avviene qui, per ovviare al bug noto tra UI e Google Maps.
* Vedere in Functions.php la parte relativa
* $( "#risto-tabs" ).tabs();
*/
    $('#latest-blog .news-service')
        .before('<div id="nav-blog">')
        .cycle({
            fx:     'fade',
            speed:  'fast',
            pause: 1,
            timeout: 3000,
            pager:  '#nav-blog'
    });

    $("#map-link").click(function(){
        $('#map-tab').trigger('click');})

    /*$('#dialog-service-rp').dialog({
        autoOpen: false,
        modal: true
    });
   
    $('#service-rp').click(function() {
        $('#dialog-service-rp').dialog('open');
        return false;
    });
	*/

	$('#service-rp').click(function() {
	    $('#dialog-service-rp').slideToggle('slow');
        return false;
	});

    $('#recover-rp').click(function() {
        $('#dialog-recover-rp').slideToggle('slow');
        return false;
    });

    function mycarousel_initCallback(carousel)
    {
        // Disable autoscrolling if the user clicks the prev or next button.
        carousel.buttonNext.bind('click', function() {
            carousel.startAuto(0);
        });

        carousel.buttonPrev.bind('click', function() {
            carousel.startAuto(0);
        });

        // Pause autoscrolling if the user moves with the cursor over the clip.
        carousel.clip.hover(function() {
            carousel.stopAuto();
        }, function() {
            carousel.startAuto();
        });
    };
    if (jQuery.isFunction(jQuery.fn.jcarousel)){
        $('.ngg-thumbnail-carousel-list').jcarousel({
        scroll:1,
        auto: 5,
        wrap: 'circular',
        initCallback: mycarousel_initCallback
       });
    }
    $('.fancybox').fancybox();
    $('.entry-content img').fancybox();

    $('#s').click(function(){
        $('#search_extra_fields').slideToggle();
        return false;
    });

});
