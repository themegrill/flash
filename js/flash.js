jQuery( document ).ready(
	function () {

		/**
		 * Onepage nav closing issue on menu item click
		 */
		// Hide nav if screen size <= 980px
		function hideNav(mdmScreen) {
			if (mdmScreen.matches) { // If media query matches
				jQuery( '.main-navigation .menu' ).slideUp( 'slow' );
			} else {
				jQuery( '#site-navigation ul' ).show();
			}
		}

		// Define match media size ( <= 980px )
		var mdmScreen = window.matchMedia( "(max-width: 980px)" );

		// Hide
		hideNav( mdmScreen );

		// Show/hide menu on resize state change
		mdmScreen.addListener( hideNav );

		// Hide nav on Onepage menu item click if screen size <= 980px
		jQuery( '#site-navigation li > a[href*="#"]' ).click(
			function () {
				hideNav( mdmScreen );
			}
		);
		// End Onepage nav

		/**
		 * Search
		 */
		var hideSearchForm = function () {
			jQuery( '.search-wrap .search-box' ).removeClass( 'active' );
		};
		jQuery( '.search-wrap .search-icon' ).on(
			'click',
			function () {
				jQuery( '.search-wrap .search-box' ).toggleClass( 'active' );

				// focus after some time to fix conflict with toggleClass
				setTimeout(
					function () {
						jQuery( '.search-wrap .search-box.active input' ).focus();
					},
					200
				);

				// For esc key press.
				jQuery( document ).on(
					'keyup',
					function (e) {

						// on esc key press.
						if (27 === e.keyCode) {
							// if search box is opened.
							if (jQuery( '.search-wrap .search-box' ).hasClass( 'active' )) {
								hideSearchForm();
							}

						}
					}
				);

				jQuery( document ).on(
					'click.outEvent',
					function (e) {
						if (e.target.closest( '.search-wrap' )) {
							return;
						}

						hideSearchForm();

						// Unbind current click event.
						jQuery( document ).off( 'click.outEvent' );
					}
				);

			}
		);

		/**
		 * Navigation
		 */
		// Append caret icon on menu item with submenu
		jQuery( '.main-navigation .menu-item-has-children' ).append( '<span class="sub-toggle"> <i class="fa fa-angle-down"></i> </span>' );

		// Mobile menu toggle clicking on hamburger icon
		jQuery( '.main-navigation .menu-toggle' ).click(
			function () {
				jQuery( '.main-navigation .menu' ).slideToggle( 'slow' );
			}
		);

		// Mobile submenu toggle on click
		jQuery( '.main-navigation .sub-toggle' ).on(
			'click',
			function () {
				var currentIcon      = jQuery( this ).children( '.fa' );
				var currentSubMenu   = jQuery( this ).parent( 'li' ),
					menuWithChildren = currentSubMenu.siblings( '.menu-item-has-children' );

				// get siblings icons
				var siblingsIcon = menuWithChildren.find( '.fa' );

				currentIcon.toggleClass( 'animate-icon' );

				if (siblingsIcon.hasClass( 'animate-icon' )) {
					siblingsIcon.removeClass( 'animate-icon' );
				}

				menuWithChildren.not( currentSubMenu ).removeClass( 'mobile-menu--slided' ).children( 'ul' ).slideUp( '1000' );
				currentSubMenu.toggleClass( 'mobile-menu--slided' ).children( 'ul' ).slideToggle( '1000' );
			}
		);

		// One Page Nav
		jQuery( window ).load(
			function () {
				var top_offset = jQuery( '#masthead-sticky-wrapper' ).height() - 1;
				jQuery( '#site-navigation' ).onePageNav(
					{
						currentClass: 'current-flash-item',
						changeHash: false,
						scrollSpeed: 1500,
						scrollOffset: top_offset,
						scrollThreshold: 0.5,
						filter: '',
						easing: 'swing',
					}
				);
			}
		);

		// Sticky menu
		if (typeof jQuery.fn.sticky !== 'undefined') {
			var wpAdminBar = jQuery( '#wpadminbar' );
			if (wpAdminBar.length) {
				jQuery( '.header-sticky .site-header' ).sticky( {topSpacing: wpAdminBar.height()} );
			} else {
				jQuery( '.header-sticky .site-header' ).sticky( {topSpacing: 0} );
			}
		}

		/**
		 * Widgets
		 */
		if (typeof jQuery.fn.counterUp !== 'undefined') {
			jQuery( '.counter' ).counterUp(
				{
					delay: 10,
					time: 1000
				}
			);
		}

		// Scroll to Top
		jQuery( document ).ready(
			function () {
				jQuery( '#scroll-up' ).hide();
				jQuery(
					function () {
						jQuery( window ).scroll(
							function () {
								if (jQuery( this ).scrollTop() > 1000) {
									jQuery( '#scroll-up' ).fadeIn();
								} else {
									jQuery( '#scroll-up' ).fadeOut();
								}
							}
						);
						jQuery( 'a#scroll-up' ).click(
							function () {
								jQuery( 'body,html' ).animate(
									{
										scrollTop: 0
									},
									800
								);
								return false;
							}
						);
					}
				);
			}
		);

		// Preloader
		if (jQuery( '#preloader-background' ).length > 0) {
			setTimeout(
				function () {
					jQuery( '#preloader-background' ).hide();
				},
				600
			);
		}

		// Full Screen Slider
		var headerClass  = jQuery( '.site-header' );
		var headerHeight = headerClass.height();
		var windowHeight = jQuery( window ).height();
		var sliderClass  = jQuery( '.tg-slider-widget.full-screen .swiper-container' );

		if (jQuery( 'body' ).hasClass( 'transparent' )) {
			sliderClass.css(
				{
					'height': windowHeight
				}
			);
		} else {
			sliderClass.css(
				{
					'height': windowHeight - headerHeight
				}
			);
		}
	}
);

jQuery( window ).on(
	'load',
	function() {

		/**
		 * Swiper for sliders
		 */
		if (typeof Swiper === 'function') {
			// Main Slider.
			jQuery( '.tg-section.tg-slider-widget' ).each(
				function ( index, element) {
					var container  = jQuery( this ).find( '.swiper-container' );
					var nextButton = jQuery( this ).find( '.swiper-button-next' );
					var prevButton = jQuery( this ).find( '.swiper-button-prev' );

					sliderInstance = "tgsliderinstance-" + index;

					var sliderInstance = new Swiper(
						container,
						{
							paginationClickable: true,
							slidesPerView: 1,
							autoplay: {
								delay: 4000
							},
							speed: 1000,
							loop: true,
							navigation: {
								nextEl: nextButton,
								prevEl: prevButton
							}
						}
					);
					jQuery( this ).on( {
						mouseenter: function() {
							sliderInstance.autoplay.stop();
						},

						mouseleave: function() {
							sliderInstance.autoplay.start();
						}
					} );
					setTimeout( function() {
						sliderInstance.update();
					}, 500 );
				}
			);

			// Testimonial Slider.
			var testimonial_slider = new Swiper(
				'.tg-testimonial-widget .swiper-container',
				{
					pagination: {
						el: '.swiper-pagination',
						clickable: true,
					},
					paginationClickable: true,
					direction: 'horizontal',
					slidesPerView: 2,
					spaceBetween: 30,
					breakpoints: {
						1024: {
							slidesPerView: 2,
							spaceBetween: 30
						},
						768: {
							slidesPerView: 1,
							spaceBetween: 10
						},
						640: {
							slidesPerView: 1,
							spaceBetween: 10
						},
						320: {
							slidesPerView: 1,
							spaceBetween: 10
						}
					}
				}
			);

			// Client Slider.
			var clientlogo_slider = new Swiper(
				'.tg-client-widget .swiper-container',
				{
					slidesPerView: 4,
					autoplay: 1000,
					direction: 'horizontal',
					setWrapperSize: true
				}
			);
		}

		// Isotope.
		if (typeof jQuery.fn.isotope === 'function') {
			var $grid = jQuery( '.grid' ).isotope(
				{
					itemSelector: '.element-item',
					layoutMode: 'fitRows'
				}
			);

			// Filter Functions.
			var filterFns = {
				// show if number is greater than 50
				numberGreaterThan50: function () {
					var number = jQuery( this ).find( '.number' ).text();
					return parseInt( number, 10 ) > 50;
				},
				// Show if name ends with -ium
				ium: function () {
					var name = jQuery( this ).find( '.name' ).text();
					return name.match( /ium$/ );
				}
			};
			// Bind filter button click.
			jQuery( '.filters-button-group' ).on(
				'click',
				'button',
				function () {
					var filterValue = jQuery( this ).attr( 'data-filter' );
					// use filterFn if matches value
					filterValue = filterFns[filterValue] || filterValue;
					$grid.isotope( {filter: filterValue} );
				}
			);
			// Change is-checked class on buttons.
			jQuery( '.button-group' ).each(
				function (i, buttonGroup) {
					var $buttonGroup = jQuery( buttonGroup );
					$buttonGroup.on(
						'click',
						'button',
						function () {
							$buttonGroup.find( '.is-checked' ).removeClass( 'is-checked' );
							jQuery( this ).addClass( 'is-checked' );
						}
					);
				}
			);
		}
	}
);
