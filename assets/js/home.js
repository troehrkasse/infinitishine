if(!bus){
    var bus = new Vue();
}

/**
 * Home page scripts
 */
jQuery(document).ready(function($){
   if(!$('body').hasClass('home')) return;

    /**
     * Home page slider
     */
    let settings = {
        slidesToShow: 1,
        slidesToScroll: 1,
        focusOnSelect: true,
        arrows: false,
        autoplay: true,
        dots: true,
        autoplaySpeed: 3200
    };


    const userSettings = $('.home-top-slider').data('settings');
    if(userSettings && typeof userSettings !== 'undefined'){
        settings = Object.assign(settings, userSettings);
    }

    $('.home-top-slider .slides').slick(settings);


  
    $('.frequently-asked-questions .faqs').each(function(){
       var _this = $(this);

       var _slick = _this.slick({
            infinite: false,
            mobileFirst:true,
            slidesToShow: 1,
            slidesToScroll: 1,
            appendArrows:   _this.parent(),
            nextArrow:  "<div class='slider-control right'>"+
                          "<i class='fa fa-chevron-right'></i>"+
                        "</div>",
            prevArrow:  "<div class='slider-control left'>"+
                          "<i class='fa fa-chevron-left'></i>"+
                        "</div>",
            responsive: [
                {
                  breakpoint: APP_VARS.BREAKPOINTS.breakpoint_md,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                  }
                },
                {
                  breakpoint: APP_VARS.BREAKPOINTS.breakpoint_xxl,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                  }
                },
                {
                  breakpoint: APP_VARS.BREAKPOINTS.breakpoint_ssl,
                  settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                  }
                }
            ]
        });
    });
});
