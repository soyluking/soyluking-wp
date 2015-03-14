var favicon;
(function ($, window, _) {
	'use strict';
    
    var lastTime = 0,
        vendors = ['ms', 'moz', 'webkit', 'o'];
	
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
    }
 
    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
    }
 
    if (!window.cancelAnimationFrame){
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
    }
    
	var $doc = $(document),
		win = $(window),
		Modernizr = window.Modernizr,
		AnimationsArray = [],
		thb_easing = [0.25, 0.1, 0.25, 1];

	
	window.SITE = {
		init: function() {
			var self = this,
				obj;
			var content = $('#wrapper'),
				pl = content.find('>.preloader'),
				count = $('body').data('cart-count');
			favicon = new Favico({
				bgColor : '#151515',
				textColor : '#fff'
			});
			favicon.badge(count);
			content.waitForImages(function() {
				
				TweenMax.to(pl, 1, { autoAlpha:0, ease: Quart.easeOut, onComplete: function() { pl.css('display', 'none'); }});
				
				for (var obj in self) {
					if ( self.hasOwnProperty(obj)) {
						var _method =  self[obj];
						if ( _method.selector !== undefined && _method.init !== undefined ) {
							if ( $(_method.selector).length > 0 ) {
								_method.init();
							}
						}
					}
				}
			});
			
		},
		SmoothScroll: {
			selector: '.smooth_scroll',
			init: function() {
				smoothScroll();
			}
		},
		reverseAnimations: {
			start: function(container) {
				var out = _.difference(AnimationsArray, container);
				for (var i = 0; i < out.length; ++i) {
					if (out[i].progress() > 0) {
						out[i].timeScale(1.6).reverse();
						$('#quick_cart').data('toggled', false);
						$('.mobile-toggle').data('toggled', false);
						$('#quick_search').data('toggled', false);
					}
				}
			}
		},
		menu: {
			selector: '#mobile-menu',
			init: function() {
				
				var menu = $('#mobile-menu'),
					items = menu.find('.mobile-menu>li,.menu-footer p, .select-wrapper'),
					toggle = $('.mobile-toggle'), 
					span = toggle.find('span'),
					cc = menu.find('.spacer'),
					inner = menu.find('.menu-container'),
					tlMainNav = new TimelineLite({ paused: true, onStart: function() { menu.css('display', 'block'); }, onComplete: function() { window.SITE.customScroll.init(); }, onReverseComplete: function() { menu.css('display', 'none'); } }),
					toggleHover = new TimelineLite({ paused: true }),
					close = $('.panel-close');
				
				AnimationsArray.push(tlMainNav);
				AnimationsArray.push(toggleHover);
				tlMainNav
					.add(TweenLite.to(menu, 0.5, {autoAlpha:1, ease: Quart.easeOut}))
					.add(TweenLite.to(inner, 0.5, {x: 0, ease: Quart.easeOut}))
					.staggerFrom(items, items.length * 0.1, { x: "50", opacity:0, ease: Quart.easeOut}, 0.10);
				
				toggleHover
					.add(TweenLite.to(span, 0.5, {x:'0%', ease: Quart.easeOut}))
					.add(TweenLite.to(toggle.find('div'), 0.5, {rotation:90, ease: Quart.easeOut}))
					.add(TweenLite.to(span.eq(0), 0.2, {y: '-2', ease: Quart.easeOut}))
					.add(TweenLite.to(span.eq(2), 0.2, {y: '2', ease: Quart.easeOut}), "-=0.2");
				
				toggle.hover(function() {
					if (!toggle.data('toggled')) {
						toggleHover.restart();
					}
				}, function() {
					if (!toggle.data('toggled')) {
						toggleHover.reverse();
					}
				}).on('click',function() {
					if(!toggle.data('toggled')) {
						window.SITE.reverseAnimations.start([tlMainNav,toggleHover]);
						tlMainNav.timeScale(1).restart();
						toggle.data('toggled', true);
					} else {
						tlMainNav.timeScale(1.6).reverse();
						toggle.data('toggled', false);
					}
					return false;
				});
				
				
				cc.add(close).on('click', function() {
					tlMainNav.timeScale(1.6).reverse();
					toggleHover.reverse();
					toggle.data('toggled', false);
				});
			}
		},
		search: {
			selector: '#quick_search',
			init: function() {
				var base = this,
					container = $(base.selector),
					target = $('#searchpopup'),
					cc = target.find('.spacer'),
					el = target.find('p, input'),
					searchMain = new TimelineLite({ paused: true, onStart: function() { target.css('display', 'block'); }, onReverseComplete: function() { target.css('display', 'none'); } });
				
				AnimationsArray.push(searchMain);
				searchMain
					.add(TweenLite.to(target, 0.5, {autoAlpha:1, ease: Quart.easeOut}))
					.staggerFrom(el, 0.2, { y: "50", opacity:0, ease: Quart.easeOut}, 0.10);
				
				container.on('click',function() {
					if(!container.data('toggled')) {
						window.SITE.reverseAnimations.start([searchMain]);
						searchMain.timeScale(1).restart();
						container.data('toggled', true);
					} else {
						searchMain.timeScale(1.6).reverse();
						container.data('toggled', false);
					}
					return false;
				});
				
				cc.on('click', function() {
					searchMain.timeScale(1.6).reverse();
					container.data('toggled', false);
				});
			}
		},
		quickCart: {
			selector: '#quick_cart',
			start: function() {
				
				var init = $('#quick_cart').data('init'),
					close = $('.panel-close');
				
				window.toggleHover = new TimelineMax({ paused: true }),
				window.MainCart = new TimelineMax({ paused: true, onStart: function() { $('#side-cart').css('display', 'block'); }, onComplete: function() { window.SITE.customScroll.init(); }, onReverseComplete: function() { $('#side-cart').css('display', 'none'); } });
					
				AnimationsArray.push(window.MainCart);
				AnimationsArray.push(window.toggleHover);
				
				window.MainCart
					.add(TweenLite.to($('#side-cart'), 0.5, {autoAlpha:1, ease: Quart.easeOut}))
					.add(TweenLite.to($('#side-cart').find('#cart-container'), 0.5, {x: 0, ease: Quart.easeOut}))
					.add(TweenMax.staggerFrom($('#side-cart').find('.item'), $('#side-cart').find('.item').length * 0.1, { y: "50", opacity:0, ease: Quart.easeOut}, 0.1));
				
				window.toggleHover
					.add(TweenLite.to($('#quick_cart').find('.handle'), 0.3, {y:'-3px', ease: Quart.easeOut}));
				
				if(!init) {
					$('#quick_cart').data('init', true);
					$('#quick_cart').hover(function() {
						if (!$('#quick_cart').data('toggled')) {
							window.toggleHover.play();
						}
					}, function() {
						if (!$('#quick_cart').data('toggled')) {
							window.toggleHover.reverse();
						}
					}).on('click',function() {
						if(!$('#quick_cart').data('toggled')) {
							window.SITE.reverseAnimations.start([window.MainCart,window.toggleHover]);
							window.MainCart.timeScale(1).play();
							$('#quick_cart').data('toggled', true);
						} else {
							window.MainCart.timeScale(1.6).reverse();
							$('#quick_cart').data('toggled', false);
						}
						return false;
					});
				}
				$('#side-cart').find('.spacer').add(close).on('click', function() {
					window.MainCart.timeScale(1.6).reverse();
					window.toggleHover.reverse();
					$('#quick_cart').data('toggled', false);
					return false;
				});
			}
		},
		overlay: {
			selector: '.overlay-effect .overlay',
			init: function(el) {
				var base = this,
					container = $(base.selector),
					target = el ? el.find(base.selector) : container;

				target.each(function() {
					var _this = $(this),
						overlayInner = _this.find('.child'),
						overlayHover = new TimelineLite({ paused: true }),
						line = overlayInner.find('hr');
					
					TweenLite.set(overlayInner, {opacity: 0, y:50});
					
					overlayHover
						.add(TweenLite.to(_this, 0.3, {opacity:1, top:10, left:10, right: 10, bottom: 10, ease: Quart.easeOut}))
						.add(TweenMax.staggerTo(overlayInner,0.3, { y: 0, opacity:1, ease: Quart.easeOut}, 0.15))
						.add(TweenLite.to(line ,0.15, { scaleX:1, ease: Quart.easeOut}), "-=0.25");
					
					_this.hoverIntent(function() {
						overlayHover.timeScale(1).play();
					}, function() {
						overlayHover.timeScale(1.6).reverse();
					});
				});
			}
		},
		portfolioHeight: {
			selector: '.horizontal, .vertical',
			init: function(el) {
				var base = this,
					container = $(base.selector);
				
				base.control(container);
				
				win.scroll(_.debounce(function(){
					base.control(container);
				}, 50));
				win.resize(_.debounce(function(){
					base.control(container);
				}, 50));
			},
			control: function(el) {
				var h = $('.header'),
					a = $('#wpadminbar'),
					ah = (a ? a.outerHeight() : 0),
					f = ($('.footer-fixed').length ? $('#footer').outerHeight() : 0);
					
				el.filter('.horizontal').each(function() {
					var _this = $(this),
						article = _this.find('.post'),
						height = (win.height() - h.outerHeight() - ah - f) / 2;

					article.height(height);
					
				});
				
				el.filter('.vertical').each(function() {
					var _this = $(this),
						article = _this.find('.post'),
						height = win.height() - h.outerHeight() - ah - f;
						
					article.height(height);
					
				});
			}
		},
		textStyle: {
			selector: '.portfolio-text-style, .portfolio-text-style-2, .post.style5',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				TweenLite.set(container, {autoAlpha: 0, x:100});
				
				base.control(container);
				
				win.scroll(_.debounce(function(){
					base.control(container);
				}, 50));
				win.resize(_.debounce(function(){
					base.control(container);
				}, 50));
			},
			control: function(el) {
				var off = 0.1,
					k = 0,
					l = el.length;
				
				el.filter(':in-viewport').each(function () {
					var _this = $(this);
					if(_this.css('opacity') === '0'){
						TweenLite.to(_this, off * l, { delay: k * off, x: 0, autoAlpha:1, ease: Quart.easeOut});
						k++;
					}
				});
			}
		},
		singlePortfolio: {
			selector: '.portfolio_nav',
			init: function() {
				
				var nav = $('.portfolio_nav').find('a');

				nav.each(function() {
					var _this = $(this),
						overlayInner = _this.find('.overlay'),
						overlayEl = _this.find('span'),
						overlayHover = new TimelineLite({ paused: true });
					
					TweenLite.set(overlayInner, {opacity: 0});
					TweenLite.set(overlayEl, {opacity: 0, y:20});
					
					overlayHover
						.add(TweenLite.to(overlayInner, 0.25, {opacity:1, ease: Quart.easeOut}))
						.add(TweenMax.staggerTo(overlayEl,0.25, { y: 0, opacity:1, ease: Quart.easeOut}, 0.1));
					
					_this.hover(function() {
						overlayHover.timeScale(1).restart();
					}, function() {
						overlayHover.timeScale(1.6).reverse();
					});
				});
			}
		},
		skrollr: {
			selector: 'body',
			init: function() {
				var main = $('div[role="main"]');
				
				if (main.find('[data-top-bottom]').length > 0) {
					main.waitForImages(function() {
						var s = skrollr.init({
							forceHeight: false,
							easing: 'outCubic',
							mobileCheck: function() {
								return false;
							}
						});
					});
				}
				
			}
		},
		navDropdown: {
			selector: '.sf-menu',
			init: function() {
				var base = this,
					container = $(base.selector),
					parents = container.find('li.menu-item-has-children>a');
				
					
				parents.on('click', function(){
					var _this = $(this);
					parents.not(this).removeClass('active').next('.sub-menu').slideUp();						
					if (!_this.hasClass('active')) {
						_this.addClass('active').next('.sub-menu').slideDown();
					} else {
						_this.removeClass('active').next('.sub-menu').slideUp();
					}
					return false;
				});
					
			}
		},
		fullMenuDropdown: {
			selector: '.full-menu',
			init: function() {
				var base = this,
					container = $(base.selector),
					item = container.find('>li.menu-item-has-children');
					
				item.each(function() {
					var that = $(this),
							offset = that.offset(),
							dropdown = that.find('>.sub-menu, >.thb_mega_menu_holder'),
							children = that.find('li.menu-item-has-children');

					that.hoverIntent(
						function () {
							that.addClass('sfHover');
							dropdown.fadeIn();
							$(this).find('>a').addClass('active');
						},
						function () {
							that.removeClass('sfHover');
							dropdown.hide();
							$(this).find('>a').removeClass('active');
						}
					);
					
					children.hoverIntent(
						function () {
							that.addClass('sfHover');
							$(this).find('>.sub-menu').fadeIn();
							$(this).find('>a').addClass('active');
							
						},
						function () {
							that.removeClass('sfHover');
							$(this).find('>.sub-menu').hide();
							$(this).find('>a').removeClass('active');
						}
					);
				});
					
			}
		},
		fullHeightContent: {
			selector: '.full-height-content',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				base.control(container);
				
				win.resize(_.debounce(function(){
					base.control(container);
				}, 50));
				
			},
			control: function(container) {
				var h = $('.header'),
					a = $('#wpadminbar'),
					f = $('.footer-fixed'),
					ah = (a ? a.outerHeight() : 0),
					fh = (f.length ? $('#footer').outerHeight() : 0),
					is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
				
				container.each(function() {
					var _this = $(this),
						height = win.height() - h.outerHeight() - ah - fh;
					
					if (!is_firefox) {
						_this.css('min-height',height);
					} else {
						_this.css('height',height);
					}
				});
			}
		},
		carousel: {
			selector: '.owl',
			init: function() {
				var base = this,
						container = $(base.selector);
						
				container.each(function() {
					var that = $(this),
						columns = that.data('columns'),
						center = (that.data('center') === true ? true : false),
						navigation = (that.data('navigation') === true ? true : false),
						autoplay = (that.data('autoplay') === false ? false : true),
						pagination = (that.data('pagination') === true ? true : false),
						autowidth = (that.data('autowidth') === true ? true : false),
						bgcheck = (that.data('bgcheck') ? that.data('bgcheck') : false),
						loop = (that.data('autowidth') === true ? false : true);
					
					that.owlCarousel({
						//Basic Speeds
						slideSpeed : 1000,
						paginationSpeed : 1000,
						rewindSpeed : 1000,
						
						//Autoplay
						autoPlay : autoplay,
						goToFirst : true,
						stopOnHover: true,
						
						// Navigation
						navigation : navigation,
						navigationText : ['',''],
						pagination : pagination,
						paginationNumbers: false,
						// Responsive
						responsive: true,
						items : columns,
						itemsDesktop: false,
						itemsDesktopSmall : [980,(columns < 3 ? columns : 3)],
						itemsTablet: [768,(columns < 2 ? columns : 2)],
						itemsMobile : [479,1],
						itemsScaleUp : false,
					});
				});
			}
		},
		toggle: {
			selector: '.toggle .title',
			init: function() {
				var base = this,
				container = $(base.selector);
				container.each(function() {
					var that = $(this);
					that.on('click', function() {
					
						if (that.hasClass('toggled')) {
							that.removeClass("toggled").closest('.toggle').find('.inner').slideUp(200);
						} else {
							that.addClass("toggled").closest('.toggle').find('.inner').slideDown(200);
						}
						
					});
				});
			}
		},
		masonry: {
			selector: '.masonry',
			init: function() {
				var base = this,
				container = $(base.selector);
								
				container.each(function() {
					var that = $(this),
						el = that.children('.item'),
						loadmore = $(that.data('loadmore')),
						filters = that.find('.filters'),
						org = [],
						page = 1;
					
					TweenLite.set(el, {opacity: 0, y:100});
					that.imagesLoaded(function() {
						that.isotope({
							itemSelector : '.item',
							transitionDuration : 0,
							masonry: {
								columnWidth: '.grid-sizer'
							}
						}).isotope( 'once', 'layoutComplete', function(i,l) {
							org = _.pluck(l, 'element');
						});
						that.isotope('layout');
						win.scroll(_.debounce(function(){
							if (that.is(':in-viewport')) {
								TweenMax.staggerTo(org, 1, { y: 0, opacity:1, ease: Quart.easeOut}, 0.25);
							}
						}, 50)).trigger('scroll');
						
						loadmore.on('click', function(){
							var text = loadmore.text(),
								type = loadmore.data('type'),
								loading = loadmore.data('loading'),
								nomore = loadmore.data('nomore'),
								initial = loadmore.data('initial'),
								categories = loadmore.data('categories'),
								count = loadmore.data('count'),
								style = loadmore.data('masonry');
							
							loadmore.text(loading).addClass('loading');
							
							$.post( themeajax.url, { 
							
									action: 'thb_ajax',
									count : count,
									type : type,
									initial : initial,
									style : style,
									categories : categories,
									page : page++
									
							}, function(data){
								
								var d = $.parseHTML($.trim(data)),
									l = d ? d.length : 0;
									
								if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
									data = '';
									loadmore.text(nomore).removeClass('loading').off('click');
								} else {
									$(d).appendTo(that).hide().imagesLoaded(function() {
										$(d).show();
										that.isotope( 'appended', $(d) );
										that.isotope('layout');
										TweenMax.set($(d), {opacity: 0, y:100});
										TweenMax.staggerTo($(d), l*0.25, { y: 0, opacity:1, ease: Quart.easeOut, onComplete: window.SITE.overlay.init($(d))}, 0.25);
									});
									
									if (l < count){
										loadmore.text(nomore).removeClass('loading');
									} else {
										loadmore.text(text).removeClass('loading');
									}
								}
								
							});
							return false;
						});
					});
					
					if (filters.length) {
						var c = filters.find('.thb-toggle'),
							li = filters.find('li'),
							li_l = li.length,
							a = filters.find('a:not(.thb-toggle)'),
							tl = new TimelineMax({paused:true});
							
						tl
							.to(c, 0.1, { x:"-100%", ease:Quart.easeOut})
							.to(filters, 0, { className:"+=active", ease:Quart.easeOut})
							.delay(0.25)
							.to(filters, 0.2, { y: "0", ease:Quart.easeOut})
							.staggerFromTo(li, (0.1 * li_l), { y: -20, opacity:0, ease: Quart.easeOut},{ y: 0, opacity:1, ease: Quart.easeOut}, 0.1);
						
						c.on('click',function(){
								tl.timeScale(1).restart();
							return false;
						});
						
						a.on('click',function(){
							var _this = $(this),
								selector = _this.attr('data-filter');
								a.removeClass('active');
								_this.addClass('active');
							
							that.isotope( 'once', 'layoutComplete',function(x,y) {
								var iso_in = _.pluck(y, 'element'),
									iso_out = _.difference(_.pluck(x.items, 'element'), iso_in),
									iso_ani = new TimelineMax({ onComplete: function() { 
											tl.timeScale(1.6).reverse();
									}});
								
								TweenLite.set(iso_in, {opacity: 0, y:100});	
								
								iso_ani
									.staggerTo(iso_out, (0.1 * iso_out.length), { y: 100, autoAlpha:0, ease: Quart.easeOut }, 0.1, false, function() {
										TweenMax.set(iso_out,{display:'none'});
									})
									.staggerTo(iso_in, (0.1 * iso_in.length), { y: 0, autoAlpha:1, ease: Quart.easeOut }, 0.1);
									
								
							});
							that.isotope({ filter: selector });
							
							return false;
						});
					}
				});
			}
		},
		grid: {
			selector: '.grid',
			init: function() {
				var base = this,
				container = $(base.selector);
								
				container.each(function() {
					var that = $(this);
					
					
					win.load(function() {
						that.isotope({
							masonry: {
								columnWidth: '.grid-sizer'
							},
							itemSelector : '.item',
							transitionDuration : '0.5s'
						});
					});
				});
			}
		},
		shareThisArticle: {
			selector: '#share-post-link',
			init: function() {
				var base = this,
					container = $(base.selector),
					fb = container.data('fb'),
					tw = container.data('tw'),
					pi = container.data('pi'),
					li  = container.data('li'),
					gp  = container.data('gp'),
					temp = '',
					target = $('.share_container'),
					cc = target.find('.spacer'),
					shareMain = new TimelineLite({ paused: true, onStart: function() { target.css('display', 'block'); }, onReverseComplete: function() { target.css('display', 'none'); } });
				
				if (fb) {
					temp += '<a href="#" class="boxed-icon facebook"><i class="fa fa-facebook"></i></a> ';
				}
				if (tw) {
					temp += '<a href="#" class="boxed-icon twitter"><i class="fa fa-twitter"></i></a> ';
				}
				if (pi) {
					temp += '<a href="#" class="boxed-icon pinterest"><i class="fa fa-pinterest"></i></a> ';
				}
				if (li) {
					temp += '<a href="#" class="boxed-icon linkedin"><i class="fa fa-linkedin"></i></a> ';
				}
				if (gp) {
					temp += '<a href="#" class="boxed-icon google-plus"><i class="fa fa-google-plus"></i></a> ';
				}
				target.find('.placeholder').sharrre({
					share: {
						facebook: fb,
						twitter: tw,
						pinterest: pi,
						linkedin: li
					},
					buttons: {
						pinterest: {
							media: target.find(".placeholder").data("media")
						}
					},
					urlCurl: $('body').data('sharrreurl'),
					template: temp,
					enableHover: false,
					enableTracking: false,
					render: function(api){
						$(api.element).on('click', '.twitter', function() {
							api.openPopup('twitter');
						});
						$(api.element).on('click', '.facebook', function() {
							api.openPopup('facebook');
						});
						$(api.element).on('click', '.pinterest', function() {
							api.openPopup('pinterest');
						});
						$(api.element).on('click', '.linkedin', function() {
							api.openPopup('linkedin');
						});
						$(api.element).on('click', '.google-plus', function() {
							api.openPopup('googlePlus');
						});
						var el = target.find('h6, .boxed-icon');
						AnimationsArray.push(shareMain);
						
						shareMain
							.add(TweenLite.to(target, 0.5, {autoAlpha:1, ease: Quart.easeOut}))
							.staggerFrom(el, el.length * 0.1, { y: "50", opacity:0, ease: Quart.easeOut}, 0.1);
						
						container.on('click',function() {
							
							
							window.SITE.reverseAnimations.start([shareMain]);
							shareMain.timeScale(1).restart();
							return false;
						});
						
						cc.on('click', function() {
							shareMain.timeScale(1.6).reverse();
						});
					}
				});
			}
		},
		parallax_bg: {
			selector: 'body',
			init: function() {
				var base = this,
					container = $(base.selector);
				if(!Modernizr.touch){ 
					$.stellar({
						horizontalScrolling: false,
						verticalOffset: 40
					});
				}
			}
		},
		customScroll: {
			selector: '.custom_scroll',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				container.each(function() {
					var that = $(this);
					that.perfectScrollbar({
						wheelPropagation: false,
						suppressScrollX: true
					});
				});
				
				win.resize(function() {
					base.resize(container);
				});
			},
			resize: function(container) {
				container.perfectScrollbar('update');
			}
		},
		wpml: {
			selector: '#thb_language_selector',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				container.on('change', function () {
					var url = $(this).val(); // get selected value
					if (url) { // require a URL
						window.location = url; // redirect
					}
					return false;
				});
			}
		},
		shop: {
			selector: '.products .product',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				container.each(function() {
					var that = $(this);
					
					that
					.find('.add_to_cart_button').on('click', function() {
						if ($(this).data('added-text') !== '') {
							$(this).text($(this).data('added-text'));
						}
					});
					
				}); // each
	
			}
		},
		variations: {
			selector: '.variations_form input[name=variation_id]',
			init: function() {
				var base = this,
					container = $(base.selector),
					org = $('.single-price.single_variation').html();
				
				container.on('change', _.debounce(function(){ 
					
						var that = $(this),
							val = that.val(),
							phtml,
							images = $('#product-images');
						
						setTimeout(function(){
							if (val) {
								phtml = that.parents('.variations_form').find('.single_variation span.price').html();
							} else {
								phtml = org;	
							}
							$('.price.single_variation').html(phtml);
						}, 100);
					
					
						if ($('.variations_form').length) {
							var variations = [],
								values;
							$('.variations_form').find('select').each(function(){
								variations.push(this.value);
							});
							values = variations.join(",");
							var v = ($('.variations_form select option:selected').val()),
								i = images.find('figure[data-variation="'+values+'"]').parents('.owl-item:not(.cloned)').index(),
								owl = images.data('owlCarousel');
							
							images.trigger("owl.goTo", i);
						}
					
					
				}, 50));
			}
		},
		reviews: {
			selector: '#reviews',
			init: function() {
				var base = this,
						container = $(base.selector);

				container.on( 'click', 'p.stars a', function(){
					var that = $(this);
					
					setTimeout(function(){ that.prevAll().addClass('active'); }, 10);
				});
			}
		},
		checkout: {
			selector: '.woocommerce-checkout',
			init: function() {
				
				$('#createaccount', '#checkout_login').on('click', function() {
					$('#checkout_register', '#checkout_login').slideToggle();
					return false;
				});

				$('#ship-to-different-address-checkbox').on('change', function() {
					$('.shipping_address').slideToggle('slow', function() {
						if($('.shipping_address').is(':hidden')) {
							$('form.checkout .shipping_address').find('p.form-row').removeClass('woocommerce-invalid-required-field');
						}
					});
					$('body').trigger( 'country_to_state_changed');
					return false;
				});
			}
		},
		loginregister: {
			selector: '#customer_login',
			init: function() {
				var base = this,
					container = $(base.selector),
					login = container.find('.login-section.first'),
					register = container.find('.login-section.second'),
					line = register.find('.line'),
					or = register.find('.or'),
					lrMain = new TimelineLite();
				
				TweenLite.set([login,register,line,or], {opacity: 0});
				TweenLite.set(login, {x: -100});
				TweenLite.set(register, {x: 100});
				TweenLite.set(line, {scaleY: 0});
				TweenLite.set(or, {scaleY: 0});
				lrMain
					.to(login, 0.5, {opacity:1, x: 0, ease: Quart.easeOut})
					.to(register, 0.5, {opacity:1, x: 0, ease: Quart.easeOut})
					.set(line, {opacity:1})
					.to(line, 0.5, {scaleY: 1, ease: Quart.easeOut})
					.to(or, 0.5, {opacity:1, scale: 1, ease: Quart.easeOut});
			}
		},
		myaccount: {
			selector: '#my-account-nav',
			init: function() {
				var base = this,
					container = $(base.selector),
					links = container.find('a'),
					li = container.find('li'),
					tabs = $('.tab-pane');
				
				links.on('click', function() {
					var that = $(this),
						target = $(that.attr('href'));
					
					li.removeClass('active');
					that.parent('li').addClass('active');
					tabs.removeClass('active').hide(0, function() {
						target.addClass('active').show();
						
						window.SITE.fullHeightContent.init();
					});
					win.trigger('resize');
					return false;
				});
			}
		},
		shopSidebar: {
			selector: '.woo.sidebar .widget.woocommerce',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				container.each(function() {
					var that = $(this),
							t = that.find('>h6');
					
					t.append($('<span/>')).on('click', function() {
						t.toggleClass('active');
						t.next().animate({
							height: "toggle",
							opacity: "toggle"
						}, 300);
						$('.woo.sidebar').find('.custom_scroll').perfectScrollbar('update');
					});
				});
			}
		},
		parsley: {
			selector: '.comment-form, .wpcf7-form',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				if ($.fn.parsley) {
					container.parsley();
				}
			}
		},
		commentToggle: {
			selector: '#commenttoggle',
			init: function() {
				var base = this,
						container = $(base.selector),
						respond = $('#respond'),
						parent = respond.find('#comment_parent');
				
				container.on('click', function() {
					respond.slideToggle();
					return false;
				});
			}	
		},
		floatLabel: {
			selector: '.placeholder',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				container.floatlabel({
					slideInput: false
				});
			}	
		},
		contact: {
			selector: '.google_map',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				container.each(function() {
					var that = $(this),
						mapzoom = that.data('map-zoom'),
						maplat = that.data('map-center-lat'),
						maplong = that.data('map-center-long'),
						pinlatlong = that.data('latlong'),
						pinimage = that.data('pin-image'),
						style = that.data('map-style'),
						mapstyle,
						expand = that.next('.expand'),
						tw = that.width();
					
					expand.toggle(function() {
						var w = that.parents('.post-content').width();
						
						that.parents('.contact_map').css('overflow', 'visible');
						TweenLite.to(that,2, { width: w, marginRight: 0, ease: Quart.easeOut});
						return false;
					},function() {
						TweenLite.to(that,2, { width: tw, marginRight: '-200%', ease: Quart.easeOut, onComplete: function() {
								that.parents('.contact_map').css('overflow', 'hidden');
							}
						});
						return false;
					});
					switch(style) {
						case 0:
							break;
						case 1:
							mapstyle = [{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#5f94ff"},{"lightness":26},{"gamma":5.86}]},{},{"featureType":"road.highway","stylers":[{"weight":0.6},{"saturation":-85},{"lightness":61}]},{"featureType":"road"},{},{"featureType":"landscape","stylers":[{"hue":"#0066ff"},{"saturation":74},{"lightness":100}]}];
							break;
						case 2:
							mapstyle = [{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]}];
							break;
						case 3:
							mapstyle = [{"featureType":"poi","stylers":[{"visibility":"off"}]},{"stylers":[{"saturation":-70},{"lightness":37},{"gamma":1.15}]},{"elementType":"labels","stylers":[{"gamma":0.26},{"visibility":"off"}]},{"featureType":"road","stylers":[{"lightness":0},{"saturation":0},{"hue":"#ffffff"},{"gamma":0}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"lightness":50},{"saturation":0},{"hue":"#ffffff"}]},{"featureType":"administrative.province","stylers":[{"visibility":"on"},{"lightness":-50}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"lightness":20}]}];
							break;
						case 4:
							mapstyle = [{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}];
							break;
						case 5:
							mapstyle = [{"featureType":"landscape","stylers":[{"hue":"#F1FF00"},{"saturation":-27.4},{"lightness":9.4},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#0099FF"},{"saturation":-20},{"lightness":36.4},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#00FF4F"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FFB300"},{"saturation":-38},{"lightness":11.2},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00B6FF"},{"saturation":4.2},{"lightness":-63.4},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#9FFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]}];
							break;
						case 6:
							mapstyle = [{"stylers":[{"hue":"#2c3e50"},{"saturation":250}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":50},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}];
							break;
						case 7:
							mapstyle = [{"stylers":[{"hue":"#16a085"},{"saturation":0}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}];
							break;
						case 8:
							mapstyle = [{"featureType":"all","stylers":[{"hue":"#0000b0"},{"invert_lightness":"true"},{"saturation":-30}]}];
							break;
					}
					var centerlatLng = new google.maps.LatLng(maplat,maplong);
					
					var mapOptions = {
						center: centerlatLng,
						styles: mapstyle,
						zoom: mapzoom,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						scrollwheel: false,
						panControl: false,
						zoomControl: false,
						mapTypeControl: false,
						scaleControl: false,
						streetViewControl: false
					};
					
					var map = new google.maps.Map(that[0], mapOptions);
					
					google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
						if(pinimage.length > 0) {
							var pinimageLoad = new Image();
							pinimageLoad.src = pinimage;
							
							$(pinimageLoad).load(function(){
								base.setMarkers(map, pinlatlong, pinimage);
							});
						}
						else {
							base.setMarkers(map, pinlatlong, pinimage);
						}
					});
				});
			},
			setMarkers: function(map, pinlatlong, pinimage) {
				var infoWindows = [];
				
				function showPin (i) {
					var latlong_array = pinlatlong[i].lat_long.split(','),
							marker = new google.maps.Marker({
													position: new google.maps.LatLng(latlong_array[0],latlong_array[1]),
													map: map,
													animation: google.maps.Animation.DROP,
													icon: pinimage,
													optimized: false
											}),
						contentString = '<div class="marker-info-win">'+
						'<img src="'+pinlatlong[i].image+'" class="image" />' +
						'<div class="marker-inner-win">'+
						'<h1 class="marker-heading">'+pinlatlong[i].title+'</h1>'+
						'<p>'+pinlatlong[i].information+'</p>'+ 
						'</div></div>';
					
					// info windows 
					var infowindow = new InfoBox({
						alignBottom: true,
						content: contentString,
						disableAutoPan: false,
						maxWidth: 380,
						closeBoxMargin: "10px 10px 10px 10px",
						closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
						pixelOffset: new google.maps.Size(-193, -41),
						zIndex: null,
						infoBoxClearance: new google.maps.Size(1, 1)
					});
					infoWindows.push(infowindow);
					
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infoWindows[i].open(map, this);
						};
					})(marker, i));
				}
				
				for (var i = 0; i + 1 <= pinlatlong.length; i++) {  
					setTimeout(showPin, i * 250, i);
				}
			}
		},
		equalHeights: {
			selector: '[data-equal]',
			init: function() {
				var base = this,
						container = $(base.selector);
				container.each(function(){
					var that = $(this),
							children = that.data("equal");
							
					that.waitForImages(function() {
						that.find(children).matchHeight(true);
					});
					 
				});
				
				$('.shipping-calculator-button').on('click', function() {
					setTimeout(function () {
						base.init();
					}, 800);
				});
			}
		},
		animation: {
			selector: '#wrapper .animation',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				base.control(container);
				
				win.scroll(function(){
					base.control(container);
				});
			},
			control: function(element) {
				var t = -1;


				element.filter(':in-viewport').each(function () {
					var that = $(this);
						t++;
					
					setTimeout(function () {
						that.addClass("animate");
					}, 200 * t);
					
				});
			}
		},
		favicon: {
			selector: 'body',
			init: function() {
				var base = this,
					container = $(base.selector),
					count = container.data('cart-count');
				favicon = new Favico({
						bgColor : '#e25842',
						textColor : '#fff'
				});
				favicon.badge(count);
			}
		},
		galleryShortcode: {
			selector: '.gallery',
			init: function() {
				var base = this,
					container = $(base.selector);
					
				container.each(function() { 
					var _this = $(this);
					_this.find('a')
						.addClass('fresco')
						.attr('data-fresco-group', _this.attr('id'));
				});
			}
		},
		toBottom: {
			selector: '.mouse_scroll',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				container.each(function() {
					var _this = $(this);
						
					
					_this.on('click', function(){
						var p = _this.parents('.row'),
							h = p.height();
						TweenMax.to(window, 1, {scrollTo:{y: p.scrollTop() + h }, ease:Quart.easeOut});
						return false;
					});
				});
			}
		},
		toTop: {
			selector: '#scroll_totop',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				container.on('click', function(){
					TweenMax.to(window, win.height() / 1000, {scrollTo:{y:0}, ease:Quart.easeOut});
					return false;
				});
				win.scroll(_.debounce(function(){
					base.control();
				}, 50));
			},
			control: function() {
				var base = this,
					container = $(base.selector);
					
				if (($doc.height() - (win.scrollTop() + win.height())) < 300) {
					TweenMax.to(container, 0.2, { autoAlpha:1, ease: Quart.easeOut });
				} else {
					TweenMax.to(container, 0.2, { autoAlpha:0, ease: Quart.easeOut });
				}
			}
		},
		styleSwitcher: {
			selector: '#style-switcher',
			init: function() {
				var base = this,
						container = $(base.selector),
						toggle = container.find('.style-toggle'),
						onoffswitch = container.find('.switch');
				
						toggle.on('click', function() {
							container.add($(this)).toggleClass('active');
							return false;
						});
						
						onoffswitch.each(function() {
							var that = $(this);
									
							that.find('a').on('click', function() {
								var dataclass = $(this).data('class');
								
								that.find('a').removeClass('active');
								$(this).addClass('active');
								
								if ($(this).parents('ul').data('name') === 'boxed') {
									$(document.body).removeClass('boxed');
									$(document.body).addClass(dataclass);
								}
								if ($(this).parents('ul').data('name') === 'header_grid') {
									$('.header .row, #subheader .row').removeClass('notgrid');
									$('.header .row, #subheader .row').addClass(dataclass);
								}
								return false;
							});
						});
				
				var style = $('<style type="text/css" id="theme_color" />').appendTo('head');
				container.find('.first').minicolors({
					defaultValue: $('.first').data('default'),
					change: function(hex) {
						style.html('.content404 figure, [class^="tag-link"]:hover, #side-cart .buttons a:last-child, .post .post-content .portfolio-text-style-2:hover, .product-information .single_add_to_cart_button, #my-account #my-account-nav li.active, .price_slider .ui-slider-range, .demo_store, .your-order-header .status, .btn.accent, .button.accent, input[type=submit].accent, .thb_tabs .tabs dd a:after, .thb_tabs .tabs li a:after, .thb_tour .tabs dd a:after, .thb_tour .tabs li a:after, .post .post-content .iconbox.type2 > span, .highlight.accent { background:'+hex+'; } .custom_check:checked + .custom_label:before, [class^="tag-link"]:hover, .post .post-content .portfolio-text-style-2:hover, .product-information .single_add_to_cart_button, #my-account #my-account-nav li.active, .price_slider .ui-slider-handle, .product-category > a:after, .chosen-container.chosen-with-drop .chosen-single, .chosen-container .chosen-drop, .btn.accent, .button.accent, input[type=submit].accent,.notification-box.success{ border-color: '+hex+'; } a:hover, .post .post-meta ul li a, .post .post-title a:hover, .widget ul.menu .current-menu-item > a, .widget.widget_recent_entries ul li .url, .widget.widget_recent_comments ul li .url, .widget.woocommerce.widget_layered_nav ul li .count, .pagination .page-numbers.current, .mobile-menu > li.current-menu-item > a, .mobile-menu > li.sfHover > a, .mobile-menu > li > a:hover, .mobile-menu ul.sub-menu li a:hover, #comments #reply-title small, .post .post-content .filters li h6 a:hover, .post .post-content .filters li h6 a.active, .product_meta p a, .shopping_bag tbody tr td.order-status.Approved, .shopping_bag tbody tr td.product-name .posted_in a, .shopping_bag tbody tr td.product-quantity .wishlist-in-stock, .shopping_bag.order_table tbody tr td h6, .price_slider_amount .button, .price_slider_amount .button:hover, .termscontainer a, ul.accordion > li.active div.title, .tabs .active a, .tabs .active a:hover, .thb_tabs .tabs dd.active a, .thb_tabs .tabs li.active a, .thb_tour .tabs dd.active a, .thb_tour .tabs li.active a, .notification-box a, .notification-box.success .content, .notification-box.success .icon { color: '+hex+'; }');	
					}
				});
			}
		}
	};
	
	// on Resize & Scroll
	win.resize(function() {
		
	});
	win.scroll(function(){
	});
	
	$doc.ready(function() {
		window.SITE.init();
	});

})(jQuery, this, _);