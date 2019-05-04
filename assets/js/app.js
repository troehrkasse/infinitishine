jQuery('document').ready(function ($) {
  if (!$('body').hasClass('archive')) return;

  // make it work
});

/**
 * Check to see if global event bus have already been defined by other vue widgets/apps. 
 * if not, define and instantiate a new bus.
 */
if (!bus) {
  var bus = new Vue();
}

var vueAwesomeSearchMobile = new Vue({
  el: '#awesome-search-app-mobile',

  data: function data() {
    return {
      placeholderText: 'Search greenhouses, resources and accessories'
    };
  },

  created: function created() {
    var self = this;

    bus.$on('onAwesomeSearchSubmitted', function (event) {
      self.onSearchSubmitted(event);
    });
    bus.$on('onAwesomeSearchSelected', function (args) {
      self.onSearchSelected(args);
    });
  },

  methods: {
    onSearchSubmitted: function onSearchSubmitted(event) {
      var el = jQuery(event.target);
      if (el.closest('#awesome-search-app-mobile').length <= 0) return event;

      var term = el.children('input').val();
      if (term.length > 0) window.location.href = BN_VARS.SITE_URL + '?s=' + term;
    },
    onSearchSelected: function onSearchSelected(args) {
      var ele = jQuery(args.event.target);

      if (ele.closest('#awesome-search-app-mobile').length <= 0) return args;

      if (!args.item) return args;

      window.location.href = args.item.link;
    }
  },

  components: {}
});
jQuery(document).ready(function ($) {
  if (!$('body').hasClass('single-product')) return;

  jQuery('.variations select').each(function (selectIndex, selectElement) {
    var select = jQuery(selectElement);
    buildSelectReplacements(selectElement);

    select.parent().on('click', '.radioControl', function () {
      var selectedValue,
          currentlyChecked = jQuery(this).hasClass('checked');
      jQuery(this).parent().parent().find('.radioControl').removeClass('checked');
      if (!currentlyChecked) {
        jQuery(this).addClass('checked');
        selectedValue = jQuery(this).data('value');
      } else {
        selectedValue = '';
      }

      select.val(selectedValue);
      select.find('option').each(function () {
        jQuery(this).prop('checked', jQuery(this).val() == selectedValue ? true : false);
      });
      select.trigger('change');
    });
    jQuery('.reset_variations').on('mouseup', function () {
      jQuery('.radioControl.checked').removeClass('checked');
    });
  });

  jQuery('.variations_form').on('woocommerce_update_variation_values', function () {
    selectValues = {};
    jQuery('.variations_form select').each(function (selectIndex, selectElement) {
      var id = jQuery(this).attr('id');
      selectValues[id] = jQuery(this).val();
      jQuery(this).parent().find('label').remove();

      //Rebuild Select Replacement Spans
      buildSelectReplacements(selectElement);

      //Reactivate Selectd Values
      jQuery(this).parent().find('span').each(function () {
        if (selectValues[id] == jQuery(this).data('value')) {
          jQuery(this).addClass('checked');
        }
      });
    });
  });

  $('.product-gallery > .infinitishine-slider').each(function () {
    var _this = $(this);

    var _slick = _this.slick({
      infinite: true,
      mobileFirst: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      focusOnSelect: true,
      asNavFor: _this.closest('.product-gallery-wrapper').find('.product-gallery-nav > .infinitishine-slider'),
      appendArrows: _this.parent(),
      nextArrow: "<div class='slider-control right'>" + "<i class='fa fa-chevron-right'></i>" + "</div>",
      prevArrow: "<div class='slider-control left'>" + "<i class='fa fa-chevron-left'></i>" + "</div>"
    });
  });

  $('.product-gallery-nav > .infinitishine-slider').each(function () {
    var _this = $(this);

    var _slick = _this.slick({
      infinite: true,
      mobileFirst: true,
      slidesToShow: 10,
      slidesToScroll: 1,
      focusOnSelect: true,
      asNavFor: _this.closest('.product-gallery-wrapper').find('.product-gallery > .infinitishine-slider'),
      appendArrows: false,
      responsive: [{
        breakpoint: APP_VARS.BREAKPOINTS.breakpoint_lg,
        settings: {
          slidesToShow: 10,
          slidesToScroll: 1
        }
      }, {
        breakpoint: APP_VARS.BREAKPOINTS.breakpoint_sm,
        settings: {
          slidesToShow: 10,
          slidesToScroll: 1
        }
      }]
    });
  });

  $('.related-products > .gallery').each(function () {
    var _this = $(this);

    var _slick = _this.slick({
      infinite: false,
      mobileFirst: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      focusOnSelect: true,
      appendArrows: _this.closest('.related-products-wrapper'),
      nextArrow: "<div class='slider-control right'>" + "<i class='fa fa-chevron-right'></i>" + "</div>",
      prevArrow: "<div class='slider-control left'>" + "<i class='fa fa-chevron-left'></i>" + "</div>",
      responsive: [{
        breakpoint: APP_VARS.BREAKPOINTS.breakpoint_sm,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }, {
        breakpoint: APP_VARS.BREAKPOINTS.breakpoint_lg,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      }, {
        breakpoint: APP_VARS.BREAKPOINTS.breakpoint_sl,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      }]
    });
  });
});

function buildSelectReplacements(selectElement) {
  var select = jQuery(selectElement);
  var container = select.parent().hasClass('radioSelectContainer') ? select.parent() : jQuery("<div class='radioSelectContainer' />");
  select.after(select.parent().hasClass('radioSelectContainer') ? '' : container);
  container.addClass(select.attr('id'));
  container.append(select);

  console.log(container);

  select.find('option').each(function (optionIndex, optionElement) {
    if (jQuery(this).val() == "") return;
    var label = jQuery("<label />");
    container.append(label);

    jQuery("<span class='radioControl' data-value='" + jQuery(this).val() + "'>" + jQuery(this).text() + "</span>").appendTo(label);
  });
}
/**
 * Check order status via api
 */
// TODO pass as arg
var controller_url = 'https://infinitishine.com/wp-json/status';

jQuery('document').ready(function ($) {
  $('#order-status-button').click(function () {
    var orderNumber = parseInt($('#order-status-input').val(), 10);
    if (!isNaN(orderNumber)) {
      jQuery.get(controller_url + '/status?order_number=' + orderNumber, function (response) {
        $('#order-status-output').html(response);
      });
    } else {
      alert('Please enter a valid order number');
    }
  });
});
/**
 * Check to see if global event bus have already been defined by other vue widgets/apps. 
 * if not, define and instantiate a new bus.
 */
if (!bus) {
  var bus = new Vue();
}

jQuery(window).on('load', function () {
  jQuery('body').addClass('loaded');
});

jQuery(document).ready(function ($) {

  $("a.btn-menu").click(function (e) {
    $(this).closest('.infinitishine-page-wrapper').toggleClass('off-canvas-expanded');
  });

  $(window).scroll(function () {
    if ($('header.infinitishine-page-menu-wrapper').length < 1) return false;

    if ($(this).scrollTop() > $('header.infinitishine-page-menu-wrapper').position().top) {
      $('header.infinitishine-page-menu-wrapper').addClass("stuck");
    } else {
      $('header.infinitishine-page-menu-wrapper').removeClass("stuck");
    }
  });
});