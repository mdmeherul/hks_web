(function ($) {

	const wdtCarouselWidgetHandler = function($scope, $) {

		const $carouselItem = $scope.find('.wdt-carousel-holder');
		const $moduleId = $carouselItem.data('id');
		const $swiperItem = $carouselItem.find('.swiper');
		const $swiperUniqueId = $swiperItem.attr('id');
		const $swiperWrapper = $carouselItem.find('.swiper-wrapper');
		const $carouselSettings = $swiperItem.data('settings');

		if($carouselSettings === undefined) {
			return;
		}

		const $direction		  	= ($carouselSettings['direction'] !== undefined) ? ($carouselSettings['direction']) : 'horizontal';
		const $effect		  	= ($carouselSettings['effect'] !== undefined) ? ($carouselSettings['effect']) : 'default';
		const $slides_to_show	 	= ($carouselSettings['slides_to_show'] !== undefined) ? parseInt($carouselSettings['slides_to_show']) : 1;
		const $slides_to_scroll 	= ($carouselSettings['slides_to_scroll'] !== undefined) ? parseInt($carouselSettings['slides_to_scroll']) : 1;
		const $pagination			= ($carouselSettings['pagination'] !== undefined) ? ($carouselSettings['pagination']) : '';
		const $arrows			  	= ($carouselSettings['arrows'] !== undefined) ? ($carouselSettings['arrows'] == 'yes') : false;
		const $speed			 	= ($carouselSettings['speed'] !== undefined && $carouselSettings['speed'] != '') ? parseInt($carouselSettings['speed']) : 400;
		const $autoplay			  	= ($carouselSettings['autoplay'] !== undefined) ? ($carouselSettings['autoplay'] == 'yes') : false;
		const $autoplay_speed	 	= ($carouselSettings['autoplay_speed'] !== undefined && $carouselSettings['autoplay_speed'] != '') ? parseInt($carouselSettings['autoplay_speed']) : 20000;
		const $loop				  	= ($carouselSettings['loop'] !== undefined) ? ($carouselSettings['loop'] == 'yes') : false;
		const $centered_slides		= ($carouselSettings['centered_slides'] !== undefined) ? ($carouselSettings['centered_slides'] == 'yes') : false;
		const $pause_on_interaction = ($carouselSettings['pause_on_interaction'] !== undefined) ? ($carouselSettings['pause_on_interaction'] == 'yes') : false;
		const $overflow_type		= ($carouselSettings['overflow_type'] !== undefined) ? ($carouselSettings['overflow_type']) : '';
		const $overflow_opacity = ($carouselSettings['overflow_opacity'] !== undefined) ? ($carouselSettings['overflow_opacity'] == 'yes') : false;
		const $unequal_height_compatability = ($carouselSettings['unequal_height_compatability'] === 'yes') ? true : false;


		// Initialize height if its vertical carousel
		if($direction == 'vertical') {
			const $height = parseInt($swiperItem.find('.swiper-slide:first .wdt-content-item').height(), 10) + 20;
			$swiperWrapper.css({'height':$height+'px'});
		}

		// Overflow script
		if($overflow_type == 'left') {

			const $itemOffsetLeft = $carouselItem.offset().left;
			const $itemPadding = parseInt($carouselItem.parents('.elementor-widget-wrap').css("padding-left"));
			const $itemLeft = (parseFloat($itemOffsetLeft) - parseFloat($itemPadding));
			const $itemWidth = $carouselItem.width();
			const $itemTotalWidth = parseFloat($itemWidth) + parseFloat($itemLeft);

			$swiperItem.css('width', $itemTotalWidth);
			$swiperItem.css('left', -$itemLeft);

		} else if($overflow_type == 'right') {

			const $docWidth = $(document).width();
			const $itemOffsetLeft = $carouselItem.offset().left;
			const itemOuterWidth = $carouselItem.outerWidth();
			const $itemWidth = $carouselItem.width();
			const itemRight = parseFloat($docWidth) - (parseFloat($itemOffsetLeft) + parseFloat(itemOuterWidth));
			const $itemPadding = parseInt($carouselItem.parents('.elementor-widget-wrap').css("padding-right"));
			const $itemTotalWidth = parseFloat($itemWidth) + parseFloat(itemRight) - parseFloat($itemPadding);

			$swiperItem.css('width', $itemTotalWidth);

		}

		// Build swiper options
		const swiperOptions = {
			initialSlide: 0,
			simulateTouch: true,
			roundLengths: true,
			keyboardControl: true,
			paginationClickable: true,
			autoHeight: false,
			grabCursor: false,

            effect: $effect,
            fadeEffect: {
                crossFade: true
            },
			slidesPerView: $slides_to_show,
			slidesPerGroup: $slides_to_scroll,
			loop:$loop,
			centeredSlides:$centered_slides,
			direction: $direction,
			speed: $speed
		}

		// Update breakpoints
		const $responsiveSettings = $carouselSettings['responsive'];
		const $responsiveData = {};
		$.each($responsiveSettings, function (index, value) {
			$responsiveData[value.breakpoint] = {
				slidesPerView: value.toshow,
				slidesPerGroup: value.toscroll
			};
		});
		swiperOptions['breakpoints'] = $responsiveData;

		// Arrow pagination
		if ($arrows) {
			swiperOptions.navigation = {
				prevEl: '.wdt-arrow-pagination-prev-'+$moduleId,
				nextEl: '.wdt-arrow-pagination-next-'+$moduleId
			};
		}

		// Other pagination
		if ($pagination != '') {
			if( $pagination == 'scrollbar' ) {
				swiperOptions.scrollbar = {
					el: '.wdt-swiper-scrollbar-'+$moduleId,
					type: $pagination,
					hide: true
				};
			} else {
				swiperOptions.pagination = {
					el: '.wdt-swiper-pagination-'+$moduleId,
					type: $pagination,
					clickable: true
				};
			}
		}

		// Autoplay
		if ($autoplay) {
			swiperOptions.autoplay = {
				delay: $autoplay_speed,
				disableOnInteraction: $pause_on_interaction
			};
		}

		const swiperGallery = new Swiper('#'+$swiperUniqueId, swiperOptions);

		if($direction == 'vertical' && $unequal_height_compatability) {
			swiperGallery.on('slideChangeTransitionStart', function () {
				const height = parseInt($swiperItem.find('.swiper-slide.swiper-slide-active .wdt-content-item').height(), 10) + 20;
					$swiperWrapper.animate({height:height}, 400);
			});
		}

		// On slide change
		swiperGallery.on('slideChangeTransitionStart', function () {
			// Overflow Opacity
			if($overflow_opacity) {
				$scope.find('.swiper').css({'overflow': 'visible'});
				$scope.find('.swiper-slide').css({'opacity': 0.5});
				$scope.find('.swiper-slide.swiper-slide-active').css({'opacity': 1});
				$scope.find('.swiper-slide.swiper-slide-active').nextAll('*:lt('+(+$slides_to_show-1)+')').css({'opacity': 1});
			}
		});

		// Overflow Opacity
		if($overflow_opacity) {
			$scope.find('.swiper').css({'overflow': 'visible'});
			$scope.find('.swiper-slide').css({'opacity': 0.5});
			$scope.find('.swiper-slide.swiper-slide-active').css({'opacity': 1});
			$scope.find('.swiper-slide.swiper-slide-active').nextAll('*:lt('+(+$slides_to_show-1)+')').css({'opacity': 1});
		}

    };

	$(window).on('elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-carousel.default', wdtCarouselWidgetHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-counter.default', wdtCarouselWidgetHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-icon-box.default', wdtCarouselWidgetHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-instagram.default', wdtCarouselWidgetHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-team.default', wdtCarouselWidgetHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-testimonial.default', wdtCarouselWidgetHandler);

  	});

  })(jQuery);