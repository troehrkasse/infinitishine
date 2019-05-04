/**
 * Check to see if global event bus have already been defined by other vue widgets/apps. 
 * if not, define and instantiate a new bus.
 */
if(!bus){
    var bus = new Vue();
}

jQuery(window).on('load', function(){
  jQuery('body').addClass('loaded');
});

jQuery(document).ready(function($){
    
    $("a.btn-menu").click(function(e){
        $(this).closest('.infinitishine-page-wrapper').toggleClass('off-canvas-expanded');
    });
    
    $(window).scroll(function() {
    if($('header.infinitishine-page-menu-wrapper').length < 1) return false;
    
		if ($(this).scrollTop() > $('header.infinitishine-page-menu-wrapper').position().top ){
			$('header.infinitishine-page-menu-wrapper').addClass("stuck");
		}else{
			$('header.infinitishine-page-menu-wrapper').removeClass("stuck");
		}
	});
});

