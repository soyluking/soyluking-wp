var thb_easing = [0.75, 0, 0.175, 1];

// Accordion

;(function ($, window, undefined){
  'use strict';

  $.fn.foundationAccordion = function (options) {
  	
    $('.accordion', this).each(function() {
    	var that = $(this),
    			active = ( !(that.data('active-tab')) ? 1 : that.data('active-tab'));
    	
    	that.find('li').eq(active -1).addClass('active');
    	
    	that.find('li').on('click.fndtn', function () {
    		var p = $(this).parent(),
    				flyout = $(this).children('.content').first(),
    				active = p.data('active');
    	  $('.content', p).not(flyout).slideUp(400, $.bez(thb_easing), function() {
    	  	$(this).parent('li').removeClass('active'); //changed this
    	  });
    	  flyout.slideDown({ 
    	  	duration: '400',
    	  	easing: $.bez(thb_easing)
    	  }).parent('li').addClass('active');
    	});
    });

  };

})( jQuery, this );

// Alerts

;(function ($, window, undefined) {
  'use strict';
  
  $.fn.foundationAlerts = function (options) {
    var settings = $.extend({
      callback: $.noop
    }, options);
    
    $(document).on("click", ".notification-box a.close", function (e) {
      e.preventDefault();
      $(this).closest(".notification-box").fadeOut(function () {
        $(this).remove();
        // Do something else after the alert closes
        settings.callback();
      });
    });
    
  };

})(jQuery, this);


// Tabs

;(function ($, window, undefined) {
  'use strict';

  $.fn.foundationTabs = function (options) {

    var settings = $.extend({
      callback: $.noop
    }, options);

    var activateTab = function ($tab) {
      var $activeTab = $tab.closest('dl').find('dd.active'),
          target = $tab.children('a').attr("href"),
          hasHash = /^#/.test(target),
          contentLocation = '';

      if (hasHash) {
        contentLocation = target + 'Tab';

        // Strip off the current url that IE adds
        contentLocation = contentLocation.replace(/^.+#/, '#');

        //Show Tab Content
        $(contentLocation).closest('.tabs-content').children('li').removeClass('active').hide();
        $(contentLocation).css('display', 'block').addClass('active');
      }

      //Make Tab Active
      $activeTab.removeClass('active');
      $tab.addClass('active');
    };

    $(document).on('click.fndtn', 'dl.tabs dd a', function (event){
      activateTab($(this).parent('dd'));
    });

	$(document).find('dl.tabs').each(function() {
		activateTab($(this).find('dd:eq(0)'));
	});
  };

})(jQuery, this);

jQuery(document).ready(function($) {
	
	$.fn.foundationAlerts					? $(document).foundationAlerts() : null;
	$.fn.foundationAccordion			? $(document).foundationAccordion() : null;
	$.fn.foundationTabs						? $(document).foundationTabs() : null;

});

/*
 * Viewport - jQuery selectors for finding elements in viewport
 *
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *  http://www.appelsiini.net/projects/viewport
 *
 */
(function($) {
    
    $.belowthefold = function(element, settings) {
        var fold = $(window).height() + $(window).scrollTop();
        return fold <= $(element).offset().top - settings.threshold;
    };

    $.abovethetop = function(element, settings) {
        var top = $(window).scrollTop();
        return top >= $(element).offset().top + $(element).height() - settings.threshold;
    };
    
    $.rightofscreen = function(element, settings) {
        var fold = $(window).width() + $(window).scrollLeft();
        return fold <= $(element).offset().left - settings.threshold;
    };
    
    $.leftofscreen = function(element, settings) {
        var left = $(window).scrollLeft();
        return left >= $(element).offset().left + $(element).width() - settings.threshold;
    };
    
    $.inviewport = function(element, settings) {
        return !$.rightofscreen(element, settings) && !$.leftofscreen(element, settings) && !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
    };
    
    $.extend($.expr[':'], {
        "below-the-fold": function(a, i, m) {
            return $.belowthefold(a, {threshold : 0});
        },
        "above-the-top": function(a, i, m) {
            return $.abovethetop(a, {threshold : 0});
        },
        "left-of-screen": function(a, i, m) {
            return $.leftofscreen(a, {threshold : 0});
        },
        "right-of-screen": function(a, i, m) {
            return $.rightofscreen(a, {threshold : 0});
        },
        "in-viewport": function(a, i, m) {
            return $.inviewport(a, {threshold : 0});
        }
    });

    
})(jQuery);

// Images Loaded
(function(c,q){var m="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";c.fn.imagesLoaded=function(f){function n(){var b=c(j),a=c(h);d&&(h.length?d.reject(e,b,a):d.resolve(e));c.isFunction(f)&&f.call(g,e,b,a)}function p(b){k(b.target,"error"===b.type)}function k(b,a){b.src===m||-1!==c.inArray(b,l)||(l.push(b),a?h.push(b):j.push(b),c.data(b,"imagesLoaded",{isBroken:a,src:b.src}),r&&d.notifyWith(c(b),[a,e,c(j),c(h)]),e.length===l.length&&(setTimeout(n),e.unbind(".imagesLoaded",
p)))}var g=this,d=c.isFunction(c.Deferred)?c.Deferred():0,r=c.isFunction(d.notify),e=g.find("img").add(g.filter("img")),l=[],j=[],h=[];c.isPlainObject(f)&&c.each(f,function(b,a){if("callback"===b)f=a;else if(d)d[b](a)});e.length?e.bind("load.imagesLoaded error.imagesLoaded",p).each(function(b,a){var d=a.src,e=c.data(a,"imagesLoaded");if(e&&e.src===d)k(a,e.isBroken);else if(a.complete&&a.naturalWidth!==q)k(a,0===a.naturalWidth||0===a.naturalHeight);else if(a.readyState||a.complete)a.src=m,a.src=d}):
n();return d?d.promise(g):g}})(jQuery);

/*! waitForImages jQuery Plugin 2014-10-27 */
!function(a){var b="waitForImages";a.waitForImages={hasImageProperties:["backgroundImage","listStyleImage","borderImage","borderCornerImage","cursor"]},a.expr[":"].uncached=function(b){if(!a(b).is('img[src][src!=""]'))return!1;var c=new Image;return c.src=b.src,!c.complete},a.fn.waitForImages=function(c,d,e){var f=0,g=0;if(a.isPlainObject(arguments[0])&&(e=arguments[0].waitForAll,d=arguments[0].each,c=arguments[0].finished),c=c||a.noop,d=d||a.noop,e=!!e,!a.isFunction(c)||!a.isFunction(d))throw new TypeError("An invalid callback was supplied.");return this.each(function(){var h=a(this),i=[],j=a.waitForImages.hasImageProperties||[],k=/url\(\s*(['"]?)(.*?)\1\s*\)/g;e?h.find("*").addBack().each(function(){var b=a(this);b.is("img:uncached")&&i.push({src:b.attr("src"),element:b[0]}),a.each(j,function(a,c){var d,e=b.css(c);if(!e)return!0;for(;d=k.exec(e);)i.push({src:d[2],element:b[0]})})}):h.find("img:uncached").each(function(){i.push({src:this.src,element:this})}),f=i.length,g=0,0===f&&c.call(h[0]),a.each(i,function(e,i){var j=new Image,k="load."+b+" error."+b;a(j).on(k,function l(b){return g++,d.call(i.element,g,f,"load"==b.type),a(this).off(k,l),g==f?(c.call(h[0]),!1):void 0}),j.src=i.src})})}}(jQuery);

/*!
 * Bez @VERSION
 * http://github.com/rdallasgray/bez
 * 
 * A plugin to convert CSS3 cubic-bezier co-ordinates to jQuery-compatible easing functions
 * 
 * With thanks to Nikolay Nemshilov for clarification on the cubic-bezier maths
 * See http://st-on-it.blogspot.com/2011/05/calculating-cubic-bezier-function.html
 * 
 * Copyright @YEAR Robert Dallas Gray. All rights reserved.
 * Provided under the FreeBSD license: https://github.com/rdallasgray/bez/blob/master/LICENSE.txt
*/
jQuery.extend({ bez: function(coOrdArray) {
	var encodedFuncName = "bez_" + jQuery.makeArray(arguments).join("_").replace(/\./g, "p");
	if (typeof jQuery.easing[encodedFuncName] !== "function") {
		var	polyBez = function(p1, p2) {
			var A = [null, null], B = [null, null], C = [null, null],
				bezCoOrd = function(t, ax) {
					C[ax] = 3 * p1[ax], B[ax] = 3 * (p2[ax] - p1[ax]) - C[ax], A[ax] = 1 - C[ax] - B[ax];
					return t * (C[ax] + t * (B[ax] + t * A[ax]));
				},
				xDeriv = function(t) {
					return C[0] + t * (2 * B[0] + 3 * A[0] * t);
				},
				xForT = function(t) {
					var x = t, i = 0, z;
					while (++i < 14) {
						z = bezCoOrd(x, 0) - t;
						if (Math.abs(z) < 1e-3) break;
						x -= z / xDeriv(x);
					}
					return x;
				};
				return function(t) {
					return bezCoOrd(xForT(t), 1);
				}
		};
		jQuery.easing[encodedFuncName] = function(x, t, b, c, d) {
			return c * polyBez([coOrdArray[0], coOrdArray[1]], [coOrdArray[2], coOrdArray[3]])(t/d) + b;
		}
	}
	return encodedFuncName;
}});

/**
* jquery.matchHeight-min.js v0.5.1
* http://brm.io/jquery-match-height/
* License: MIT
*/
(function(b){b.fn.matchHeight=function(a){if("remove"===a){var d=this;this.css("height","");b.each(b.fn.matchHeight._groups,function(b,a){a.elements=a.elements.not(d)});return this}if(1>=this.length)return this;a="undefined"!==typeof a?a:!0;b.fn.matchHeight._groups.push({elements:this,byRow:a});b.fn.matchHeight._apply(this,a);return this};b.fn.matchHeight._apply=function(a,d){var c=b(a),e=[c];d&&(c.css({display:"block","padding-top":"0","padding-bottom":"0","border-top":"0","border-bottom":"0",height:"100px"}),
e=k(c),c.css({display:"","padding-top":"","padding-bottom":"","border-top":"","border-bottom":"",height:""}));b.each(e,function(a,c){var d=b(c),e=0;d.each(function(){var a=b(this);a.css({display:"block",height:""});a.outerHeight(!1)>e&&(e=a.outerHeight(!1));a.css({display:""})});d.each(function(){var a=b(this),c=0;"border-box"!==a.css("box-sizing")&&(c+=g(a.css("border-top-width"))+g(a.css("border-bottom-width")),c+=g(a.css("padding-top"))+g(a.css("padding-bottom")));a.css("height",e-c)})});return this};
b.fn.matchHeight._applyDataApi=function(){var a={};b("[data-match-height], [data-mh]").each(function(){var d=b(this),c=d.attr("data-match-height");a[c]=c in a?a[c].add(d):d});b.each(a,function(){this.matchHeight(!0)})};b.fn.matchHeight._groups=[];b.fn.matchHeight._throttle=80;var h=-1,f=-1;b.fn.matchHeight._update=function(a){if(a&&"resize"===a.type){a=b(window).width();if(a===h)return;h=a}-1===f&&(f=setTimeout(function(){b.each(b.fn.matchHeight._groups,function(){b.fn.matchHeight._apply(this.elements,
this.byRow)});f=-1},b.fn.matchHeight._throttle))};b(b.fn.matchHeight._applyDataApi);b(window).bind("load resize orientationchange",b.fn.matchHeight._update);var k=function(a){var d=null,c=[];b(a).each(function(){var a=b(this),f=a.offset().top-g(a.css("margin-top")),h=0<c.length?c[c.length-1]:null;null===h?c.push(a):1>=Math.floor(Math.abs(d-f))?c[c.length-1]=h.add(a):c.push(a);d=f});return c},g=function(a){return parseFloat(a)||0}})(jQuery);

/*!
 * Variations Plugin
 */
;(function ( $, window, document, undefined ) {

	$.fn.wc_variation_form = function () {

		$.fn.wc_variation_form.find_matching_variations = function( product_variations, settings ) {
			var matching = [];

			for ( var i = 0; i < product_variations.length; i++ ) {
				var variation = product_variations[i];
				var variation_id = variation.variation_id;

				if ( $.fn.wc_variation_form.variations_match( variation.attributes, settings ) ) {
					matching.push( variation );
				}
			}

			return matching;
		};

		$.fn.wc_variation_form.variations_match = function( attrs1, attrs2 ) {
			var match = true;

			for ( var attr_name in attrs1 ) {
				if ( attrs1.hasOwnProperty( attr_name ) ) {
					var val1 = attrs1[ attr_name ];
					var val2 = attrs2[ attr_name ];

					if ( val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2 ) {
						match = false;
					}
				}
			}

			return match;
		};

		// Unbind any existing events
		this.unbind( 'check_variations update_variation_values found_variation' );
		this.find( '.reset_variations' ).unbind( 'click' );
		this.find( '.variations select' ).unbind( 'change focusin' );

		// Bind events
		$form = this

			// On clicking the reset variation button
			.on( 'click', '.reset_variations', function( event ) {

				$( this ).closest( '.variations_form' ).find( '.variations select' ).val( '' ).change();

				var $sku = $( this ).closest( '.product' ).find( '.sku' ),
					$weight = $( this ).closest( '.product' ).find( '.product_weight' ),
					$dimensions = $( this ).closest( '.product' ).find( '.product_dimensions' );

				if ( $sku.attr( 'data-o_sku' ) )
					$sku.text( $sku.attr( 'data-o_sku' ) );

				if ( $weight.attr( 'data-o_weight' ) )
					$weight.text( $weight.attr( 'data-o_weight' ) );

				if ( $dimensions.attr( 'data-o_dimensions' ) )
					$dimensions.text( $dimensions.attr( 'data-o_dimensions' ) );

				return false;
			} )

			// Upon changing an option
			.on( 'change', '.variations select', function( event ) {

				$variation_form = $( this ).closest( '.variations_form' );
				$variation_form.find( 'input[name=variation_id]' ).val( '' ).change();

				$variation_form
					.trigger( 'woocommerce_variation_select_change' )
					.trigger( 'check_variations', [ '', false ] );

				$( this ).blur();

				if( $().uniform && $.isFunction( $.uniform.update ) ) {
					$.uniform.update();
				}

			} )

			// Upon gaining focus
			.on( 'focusin touchstart', '.variations select', function( event ) {

				$variation_form = $( this ).closest( '.variations_form' );

				$variation_form
					.trigger( 'woocommerce_variation_select_focusin' )
					.trigger( 'check_variations', [ $( this ).attr( 'name' ), true ] );

			} )

			// Check variations
			.on( 'check_variations', function( event, exclude, focus ) {
				var all_set = true,
					any_set = false,
					showing_variation = false,
					current_settings = {},
					$variation_form = $( this ),
					$reset_variations = $variation_form.find( '.reset_variations' );

				$variation_form.find( '.variations select' ).each( function() {

					if ( $( this ).val().length === 0 ) {
						all_set = false;
					} else {
						any_set = true;
					}

					if ( exclude && $( this ).attr( 'name' ) === exclude ) {

						all_set = false;
						current_settings[$( this ).attr( 'name' )] = '';

					} else {

						// Encode entities
						value = $( this ).val();

						// Add to settings array
						current_settings[ $( this ).attr( 'name' ) ] = value;
					}

				});

				var product_id = parseInt( $variation_form.data( 'product_id' ) ),
					all_variations = $variation_form.data( 'product_variations' );

				// Fallback to window property if not set - backwards compat
				if ( ! all_variations )
					all_variations = window.product_variations.product_id;
				if ( ! all_variations )
					all_variations = window.product_variations;
				if ( ! all_variations )
					all_variations = window['product_variations_' + product_id ];

				var matching_variations = $.fn.wc_variation_form.find_matching_variations( all_variations, current_settings );

				if ( all_set ) {

					var variation = matching_variations.shift();

					if ( variation ) {

						// Found - set ID
						$variation_form
							.find( 'input[name=variation_id]' )
							.val( variation.variation_id )
							.change();

						$variation_form.trigger( 'found_variation', [ variation ] );

					} else {

						// Nothing found - reset fields
						$variation_form.find( '.variations select' ).val( '' );

						if ( ! focus )
							$variation_form.trigger( 'reset_image' );

						alert( wc_add_to_cart_variation_params.i18n_no_matching_variations_text );

					}

				} else {

					$variation_form.trigger( 'update_variation_values', [ matching_variations ] );

					if ( ! focus )
						$variation_form.trigger( 'reset_image' );

					if ( ! exclude ) {
						$variation_form.find( '.single_variation_wrap' ).slideUp( 200 );
					}

				}

				if ( any_set ) {

					if ( $reset_variations.css( 'visibility' ) === 'hidden' )
						$reset_variations.css( 'visibility', 'visible' ).hide().fadeIn();

				} else {

					$reset_variations.css( 'visibility', 'hidden' );

				}

			} )

			// Reset product image
			.on( 'reset_image', function( event ) {

				var $product = $(this).closest( '.product' ),
					$product_img = $product.find( 'div.images img:eq(0)' ),
					$product_link = $product.find( 'div.images a.zoom:eq(0)' ),
					o_src = $product_img.attr( 'data-o_src' ),
					o_title = $product_img.attr( 'data-o_title' ),
					o_alt = $product_img.attr( 'data-o_alt' ),
					o_href = $product_link.attr( 'data-o_href' );

				if ( o_src !== undefined ) {
					$product_img
						.attr( 'src', o_src );
				}

				if ( o_href !== undefined ) {
					$product_link
						.attr( 'href', o_href );
				}

				if ( o_title !== undefined ) {
					$product_img
						.attr( 'title', o_title );
					$product_link
						.attr( 'title', o_title );
				}

				if ( o_alt !== undefined ) {
					$product_img
						.attr( 'alt', o_alt );
				}
			} )

			// Disable option fields that are unavaiable for current set of attributes
			.on( 'update_variation_values', function( event, variations ) {

				$variation_form = $( this ).closest( '.variations_form' );

				// Loop through selects and disable/enable options based on selections
				$variation_form.find( '.variations select' ).each( function( index, el ) {

					current_attr_select = $( el );

					// Reset options
					if ( ! current_attr_select.data( 'attribute_options' ) )
						current_attr_select.data( 'attribute_options', current_attr_select.find( 'option:gt(0)' ).get() );

					current_attr_select.find( 'option:gt(0)' ).remove();
					current_attr_select.append( current_attr_select.data( 'attribute_options' ) );
					current_attr_select.find( 'option:gt(0)' ).removeClass( 'active' );

					// Get name
					var current_attr_name = current_attr_select.attr( 'name' );

					// Loop through variations
					for ( var num in variations ) {

						if ( typeof( variations[ num ] ) != 'undefined' ) {

							var attributes = variations[ num ].attributes;

							for ( var attr_name in attributes ) {
								if ( attributes.hasOwnProperty( attr_name ) ) {
									var attr_val = attributes[ attr_name ];

									if ( attr_name == current_attr_name ) {

										if ( attr_val ) {

											// Decode entities
											attr_val = $( '<div/>' ).html( attr_val ).text();

											// Add slashes
											attr_val = attr_val.replace( /'/g, "\\'" );
											attr_val = attr_val.replace( /"/g, "\\\"" );

											// Compare the meerkat
											current_attr_select.find( 'option[value="' + attr_val + '"]' ).addClass( 'active' );

										} else {

											current_attr_select.find( 'option:gt(0)' ).addClass( 'active' );

										}
									}
								}
							}
						}
					}

					// Detach inactive
					current_attr_select.find( 'option:gt(0):not(.active)' ).remove();

				});

				// Custom event for when variations have been updated
				$variation_form.trigger( 'woocommerce_update_variation_values' );

			} )

			// Show single variation details (price, stock, image)
			.on( 'found_variation', function( event, variation ) {
				var $variation_form = $( this ),
					$product = $( this ).closest( '.product' ),
					$product_img = $product.find( 'div.images img:eq(0)' ),
					$product_link = $product.find( 'div.images a.zoom:eq(0)' ),
					o_src = $product_img.attr( 'data-o_src' ),
					o_title = $product_img.attr( 'data-o_title' ),
					o_alt = $product_img.attr( 'data-o_alt' ),
					o_href = $product_link.attr( 'data-o_href' ),
					variation_image = variation.image_src,
					variation_link  = variation.image_link,
					variation_title = variation.image_title,
					variation_alt = variation.image_alt;

				$variation_form.find( '.variations_button' ).show();
				$variation_form.find( '.single_variation' ).html( variation.price_html + variation.availability_html );

				if ( o_src === undefined ) {
					o_src = ( ! $product_img.attr( 'src' ) ) ? '' : $product_img.attr( 'src' );
					$product_img.attr( 'data-o_src', o_src );
				}

				if ( o_href === undefined ) {
					o_href = ( ! $product_link.attr( 'href' ) ) ? '' : $product_link.attr( 'href' );
					$product_link.attr( 'data-o_href', o_href );
				}

				if ( o_title === undefined ) {
					o_title = ( ! $product_img.attr( 'title' ) ) ? '' : $product_img.attr( 'title' );
					$product_img.attr( 'data-o_title', o_title );
				}

				if ( o_alt === undefined ) {
					o_alt = ( ! $product_img.attr( 'alt' ) ) ? '' : $product_img.attr( 'alt' );
					$product_img.attr( 'data-o_alt', o_alt );
				}

				if ( variation_image && variation_image.length > 1 ) {
					$product_img
						.attr( 'src', variation_image )
						.attr( 'alt', variation_alt )
						.attr( 'title', variation_title );
					$product_link
						.attr( 'href', variation_link )
						.attr( 'title', variation_title );
				} else {
					$product_img
						.attr( 'src', o_src )
						.attr( 'alt', o_alt )
						.attr( 'title', o_title );
					$product_link
						.attr( 'href', o_href )
						.attr( 'title', o_title );
				}

				var $single_variation_wrap = $variation_form.find( '.single_variation_wrap' ),
					$sku = $product.find( '.product_meta' ).find( '.sku' ),
					$weight = $product.find( '.product_weight' ),
					$dimensions = $product.find( '.product_dimensions' );

				if ( ! $sku.attr( 'data-o_sku' ) )
					$sku.attr( 'data-o_sku', $sku.text() );

				if ( ! $weight.attr( 'data-o_weight' ) )
					$weight.attr( 'data-o_weight', $weight.text() );

				if ( ! $dimensions.attr( 'data-o_dimensions' ) )
					$dimensions.attr( 'data-o_dimensions', $dimensions.text() );

				if ( variation.sku ) {
					$sku.text( variation.sku );
				} else {
					$sku.text( $sku.attr( 'data-o_sku' ) );
				}

				if ( variation.weight ) {
					$weight.text( variation.weight );
				} else {
					$weight.text( $weight.attr( 'data-o_weight' ) );
				}

				if ( variation.dimensions ) {
					$dimensions.text( variation.dimensions );
				} else {
					$dimensions.text( $dimensions.attr( 'data-o_dimensions' ) );
				}

				$single_variation_wrap.find( '.quantity' ).show();

				if ( ! variation.is_purchasable || ! variation.is_in_stock || ! variation.variation_is_visible ) {
					$variation_form.find( '.variations_button' ).hide();
				}

				if ( ! variation.variation_is_visible ) {
					$variation_form.find( '.single_variation' ).html( '<p>' + wc_add_to_cart_variation_params.i18n_unavailable_text + '</p>' );
				}

				if ( variation.min_qty )
					$single_variation_wrap.find( 'input[name=quantity]' ).attr( 'min', variation.min_qty ).val( variation.min_qty );
				else
					$single_variation_wrap.find( 'input[name=quantity]' ).removeAttr( 'min' );

				if ( variation.max_qty )
					$single_variation_wrap.find( 'input[name=quantity]' ).attr( 'max', variation.max_qty );
				else
					$single_variation_wrap.find( 'input[name=quantity]' ).removeAttr( 'max' );

				if ( variation.is_sold_individually === 'yes' ) {
					$single_variation_wrap.find( 'input[name=quantity]' ).val( '1' );
					$single_variation_wrap.find( '.quantity' ).hide();
				}

				$single_variation_wrap.slideDown( 200 ).trigger( 'show_variation', [ variation ] );

			});

		$form.trigger( 'wc_variation_form' );

		return $form;
	};

	$( function() {

		// wc_add_to_cart_variation_params is required to continue, ensure the object exists
		if ( typeof wc_add_to_cart_variation_params === 'undefined' )
			return false;

		$( '.variations_form' ).wc_variation_form();
		$( '.variations_form .variations select' ).change();
	});

})( jQuery, window, document );

/*
Firefox super responsive scroll (c) Keith Clark - MIT Licensed
*/
(function(doc) {

  var root = doc.documentElement;

  // Not ideal, but better than UA sniffing.
  if ("MozAppearance" in root.style) {

    // determine the vertical scrollbar width
    var scrollbarWidth = root.clientWidth;
    root.style.overflow = "scroll";
    scrollbarWidth -= root.clientWidth;
    root.style.overflow = "";
    
    // create a synthetic scroll event
    var scrollEvent = doc.createEvent("UIEvent")
    scrollEvent.initEvent("scroll", true, true);
    
    // event dispatcher
    function scrollHandler() {
      doc.dispatchEvent(scrollEvent)
    }

    // detect mouse events in the document scrollbar track
    doc.addEventListener("mousedown", function(e) {
      if (e.clientX > root.clientWidth - scrollbarWidth) {
        doc.addEventListener("mousemove", scrollHandler, false);
        doc.addEventListener("mouseup", function() {
          doc.removeEventListener("mouseup", arguments.callee, false);
          doc.removeEventListener("mousemove", scrollHandler, false);
        }, false)
      }
    }, false)

    // override mouse wheel behaviour.
    doc.addEventListener("DOMMouseScroll", function(e) {
      // Don't disable hot key behaviours
      if (!e.ctrlKey && !e.shiftKey) {
        root.scrollTop += e.detail * 16;
        scrollHandler.call(this, e);
        e.preventDefault()
      }
    }, false)
 
  }
})(document);

 /*!
  * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
  * http://cherne.net/brian/resources/jquery.hoverIntent.html
  *
  * You may use hoverIntent under the terms of the MIT license.
  * Copyright 2007, 2013 Brian Cherne
  */
 (function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery);