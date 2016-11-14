jQuery(document).ready(function() {

	jQuery('.main-navigation .menu-toggle').on('click', function() {
		jQuery('.main-navigation .menu').slideToggle('slow');
	});

	jQuery('.main-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-angle-down"></i> </span>');

	jQuery('.main-navigation .sub-toggle').on('click', function() {
		jQuery(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
	});

	jQuery('.search-wrap .search-icon').on('click', function() {
		jQuery('.search-wrap .search-box').toggleClass('active');
	});

	if ( typeof jQuery.fn.counterUp !== 'undefined' ) {
		jQuery('.counter').counterUp({
			delay: 10,
			time: 1000
		});
	}

	// Scroll to Top
	jQuery(document).ready(function(){
		jQuery('#scroll-up').hide();
		jQuery(function () {
			jQuery(window).scroll(function () {
				if (jQuery(this).scrollTop() > 1000) {
					jQuery('#scroll-up').fadeIn();
				} else {
					jQuery('#scroll-up').fadeOut();
				}
			});
			jQuery('a#scroll-up').click(function () {
				jQuery('body,html').animate({
					scrollTop: 0
				}, 800);
				return false;
			});
		});
	});

	// One Page Nav
	jQuery(window).load(function() {
	    var top_offset = jQuery('#masthead-sticky-wrapper').height() - 1;
		jQuery('#site-navigation').onePageNav({
		    currentClass: 'current-flash-item',
		    changeHash: false,
		    scrollSpeed: 1500,
		    scrollOffset: top_offset,
		    scrollThreshold: 0.5,
		    filter: '',
		    easing: 'swing',
		    begin: function() {
		        //I get fired when the animation is starting
		    },
		    end: function() {
		        //I get fired when the animation is ending
		    },
		    scrollChange: function() {
		        //I get fired when you enter a section and I pass the list item of the section
		    }
		});
	});

	// Sticky menu
	if(typeof jQuery.fn.sticky !== 'undefined'){
		var wpAdminBar = jQuery('#wpadminbar');
		if (wpAdminBar.length) {
			jQuery('.header-sticky .site-header').sticky({topSpacing:wpAdminBar.height()});
		} else {
			jQuery('.header-sticky .site-header').sticky({topSpacing:0});
		}
	}


	// Preloader
	if(jQuery('#preloader-background').length > 0) {
		setTimeout(function(){jQuery('#preloader-background').hide();}, 600);
	}
});

jQuery(window).load(function() {
	if(typeof Swiper === 'function'){
		//SWIPER SLIDER
		var main_slider = new Swiper ('.tg-slider-widget .swiper-container', {
			paginationClickable: true,
			slidesPerView: 1,
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev'
		});
		//TESTIMONIAL SLIDER
		var testimonial_slider = new Swiper ('.tg-testimonial-widget .swiper-container', {
			pagination: '.swiper-pagination',
			paginationClickable: true,
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
		});
		//client SLIDER
		var clientlogo_slider = new Swiper ('.tg-client-widget .swiper-container', {
			paginationClickable: true,
			slidesPerView: 4,
			autoplay: 1000,
			direction: 'horizontal'
		});
	}

	// Isotope
	if(typeof jQuery.fn.isotope === 'function'){
		var $grid = jQuery('.grid').isotope({
			itemSelector: '.element-item',
			layoutMode: 'fitRows'
		});

		// filter functions
		var filterFns = {
			// show if number is greater than 50
			numberGreaterThan50: function() {
				var number = jQuery(this).find('.number').text();
				return parseInt( number, 10 ) > 50;
			},
			// show if name ends with -ium
			ium: function() {
				var name = jQuery(this).find('.name').text();
				return name.match( /ium$/ );
			}
		};
		// bind filter button click
		jQuery('.filters-button-group').on( 'click', 'button', function() {
			var filterValue = jQuery( this ).attr('data-filter');
			// use filterFn if matches value
			filterValue = filterFns[ filterValue ] || filterValue;
			$grid.isotope({ filter: filterValue });
		});
		// change is-checked class on buttons
		jQuery('.button-group').each( function( i, buttonGroup ) {
			var $buttonGroup = jQuery( buttonGroup );
			$buttonGroup.on( 'click', 'button', function() {
				$buttonGroup.find('.is-checked').removeClass('is-checked');
				jQuery( this ).addClass('is-checked');
			});
		});
	}
});
