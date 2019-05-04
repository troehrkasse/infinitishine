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
        jQuery(this).prop('checked', (jQuery(this).val() == selectedValue) ? true : false);
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
      nextArrow: "<div class='slider-control right'>" +
      "<i class='fa fa-chevron-right'></i>" +
      "</div>",
      prevArrow: "<div class='slider-control left'>" +
      "<i class='fa fa-chevron-left'></i>" +
      "</div>",
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
      responsive: [
        {
          breakpoint: APP_VARS.BREAKPOINTS.breakpoint_lg,
          settings: {
            slidesToShow: 10,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: APP_VARS.BREAKPOINTS.breakpoint_sm,
          settings: {
            slidesToShow: 10,
            slidesToScroll: 1
          }
        }
      ]
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
      nextArrow: "<div class='slider-control right'>" +
      "<i class='fa fa-chevron-right'></i>" +
      "</div>",
      prevArrow: "<div class='slider-control left'>" +
      "<i class='fa fa-chevron-left'></i>" +
      "</div>",
      responsive: [
        {
          breakpoint: APP_VARS.BREAKPOINTS.breakpoint_sm,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: APP_VARS.BREAKPOINTS.breakpoint_lg,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          }
        },
        {
          breakpoint: APP_VARS.BREAKPOINTS.breakpoint_sl,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4
          }
        }
      ]
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