var wdtPortfolioFrontendUtils = {

	wdtPortfolioListingsListingIsotope : function($appended = false) {

	    jQuery('.wdt-listings-item-apply-isotope .wdt-listings-item-container').each(function() {

	    	var this_item = jQuery(this);

	        var $grid = this_item.isotope({
				itemSelector: '.wdt-column',
				percentPosition: true,
				masonry: {
					columnWidth: '.grid-sizer'
				}
	        });

            if($appended) {
                $grid.isotope('reloadItems');
            }

			window.setTimeout(function(){
				this_item.isotope();
			}, 1400);

	    });

        jQuery('.wdt-listings-item-apply-isotope .wdt-listings-item-container').each(function() {

	    	var this_item = jQuery(this);

	        this_item.isotope();

	    });

	    jQuery('.wdt-listings-item-apply-isotope .wdt-listings-item-isotope-filter').each(function() {

	    	var isotope_filter = jQuery(this);

			isotope_filter.find('a').on('click', function() {

				isotope_filter.find('a').removeClass('active-sort');
				var selector = jQuery(this).attr('data-filter');
				jQuery(this).addClass('active-sort');

				jQuery(this).parents('.wdt-listings-item-apply-isotope').find('.wdt-listings-item-container').isotope({ filter: selector, masonry: {  }, animationEngine : 'jquery' });

				return false;

			});

	    });


	},

	wdtPortfolioListingCarousel : function(output_container) {

		var swiperGalleryListing = [];
		var swiperGalleryListingOptions = [];
		var swiperListingIterator = 1;

		output_container.find('.wdt-listings-container').each(function() {

			var $swiperItem = jQuery(this);
			var swiperUniqueId = 'swiperuniqueid-'+swiperListingIterator;
			swiperGalleryListingOptions[swiperUniqueId] = [];
			$swiperItem.attr('id', swiperUniqueId);

			// Get swiper options
			var effect = output_container.attr('data-carouseleffect');

			var autoplay = parseInt(output_container.attr('data-carouselautoplay'), 10);
			var autoplay_enable = false;
			if(autoplay > 0) {
				autoplay_enable = true;
				swiperGalleryListingOptions[swiperUniqueId]['autoplay'] = autoplay;
			} else {
				swiperGalleryListingOptions[swiperUniqueId]['autoplay'] = 0;
			}

			var slidesperview = parseInt(output_container.attr('data-carouselslidesperview'), 10);
			var loopmode = (output_container.attr('data-carouselloopmode') == 'true') ? true : false;
			var mousewheelcontrol = (output_container.attr('data-carouselmousewheelcontrol') == 'true') ? true : false;

			var pagination_class = '';
			var pagination_type = '';

			if(output_container.attr('data-carouselbulletpagination') == 'true') {
				var pagination_class = output_container.find('.wdt-swiper-bullet-pagination');
				var pagination_type = 'bullets';
			}

			var spacebetween = parseInt(output_container.attr('data-carouselspacebetween'), 10);
			if(spacebetween) {
				spacebetween = spacebetween;
			} else {
				spacebetween = 0;
			}

			if(slidesperview == 1) {
				var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 1;
			} else if(slidesperview == 2) {
				var breakpoint_slides_1 = 2; var breakpoint_slides_2 = 2; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
			} else if(slidesperview == 3) {
				var breakpoint_slides_1 = 3; var breakpoint_slides_2 = 3; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
			} else if(slidesperview >= 4) {
				var breakpoint_slides_1 = 4; var breakpoint_slides_2 = 3; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
			}

			// Generate swiper
		    swiperGalleryListing[swiperUniqueId] = new Swiper($swiperItem, {

     			initialSlide: 0,
                simulateTouch: true,
                roundLengths: true,
                spaceBetween: spacebetween,
                keyboardControl: true,
                paginationClickable: true,
                autoHeight: true,

                grabCursor: true,
                autoplay: {
                			enabled: autoplay_enable,
						    delay: autoplay,
						},
                slidesPerView: slidesperview,
                loop:loopmode,
                mousewheel: mousewheelcontrol,

				pagination: {
					el: pagination_class,
					type: pagination_type,
					clickable: true,
					renderFraction: function (currentClass, totalClass) {
						return '<span class="' + currentClass + '"></span>' +
								'<span class="wdt-separator"></span>' +
								'<span class="' + totalClass + '"></span>';
					}
				},

                effect: effect,
				coverflowEffect: {
					slideShadows: false,
					rotate: 0,
					stretch: 0,
					depth: 200,
					modifier: 1,
				},
		        cubeEffect: {
		        	slideShadows: true,
		            shadow: true,
		            shadowOffset: 20,
		            shadowScale: 0.94
		        },

		        breakpoints: {
		            0: {
		                slidesPerView: breakpoint_slides_4,
		            },
		            768: {
		                slidesPerView: breakpoint_slides_3,
		            },
		            1025: {
		                slidesPerView: breakpoint_slides_2,
		            },
		            1280: {
		                slidesPerView: breakpoint_slides_1,
		            }
		        },

		    });

		    if(output_container.attr('data-carouselarrowpagination') == 'true') {

			    output_container.find('.wdt-swiper-pagination-holder .wdt-swiper-arrow-pagination .wdt-swiper-arrow-prev').on('click', function(e) {
					var swiperUniqueId = $swiperItem.attr('id');
			        swiperGalleryListing[swiperUniqueId].slidePrev();
			        if(swiperGalleryListingOptions[swiperUniqueId]['autoplay'] > 0) {
			        	swiperGalleryListing[swiperUniqueId].autoplay.start();
			        }
			        e.preventDefault();
			    });

			    output_container.find('.wdt-swiper-pagination-holder .wdt-swiper-arrow-pagination .wdt-swiper-arrow-next').on('click', function(e) {
			    	var swiperUniqueId = $swiperItem.attr('id');
			        swiperGalleryListing[swiperUniqueId].slideNext();
			        if(swiperGalleryListingOptions[swiperUniqueId]['autoplay'] > 0 ) {
			        	swiperGalleryListing[swiperUniqueId].autoplay.start();
			        }
			        e.preventDefault();
			    });

			}

		    swiperListingIterator++;

		});

	},

	wdtPortfolioFilterOptions : function() {

		// Keyword
		var keyword = jQuery('.wdt-sf-keyword').val();

    	// Location
		var user_latitude = jQuery('.wdt-sf-location-latitude').val();
		var user_longitude = jQuery('.wdt-sf-location-longitude').val();

		var radius = radius_unit = '';
		if(user_latitude != '' && user_latitude != '') {
			if(jQuery('.wdt-sf-radius').length > 0 && jQuery('.wdt-sf-radius-unit').length > 0) {
				var radius      = jQuery('.wdt-sf-radius').val();
				var radius_unit = jQuery('.wdt-sf-radius-unit').val();
			} else if(jQuery('.wdt-sf-location-max-radius').length > 0 && jQuery('.wdt-sf-location-radius-unit').length > 0) {
				var radius      = jQuery('.wdt-sf-location-max-radius').val();
				var radius_unit = jQuery('.wdt-sf-location-radius-unit').val();
			}
		}

		// Categories
		var categories = jQuery('.wdt-sf-categories option:selected').map(function(){
			if(this.value != '') {
				return this.value;
			}
		}).get();
		if(categories.length === 0) {
			var categories = jQuery('.wdt-sf-categories:checked').map(function(){
				if(this.value != '') {
					return this.value;
				}
			}).get();
		}

		// Tags
		var tags = jQuery('.wdt-sf-tags option:selected').map(function(){
			if(this.value != '') {
				return this.value;
			}
		}).get();
		if(tags.length === 0) {
			var tags = jQuery('.wdt-sf-tags:checked').map(function(){
				if(this.value != '') {
					return this.value;
				}
			}).get();
		}

		// Start Date
		var startdate = jQuery('.wdt-sf-startdate').val();

		// Price Range
		var pricerange_start = jQuery('.wdt-sf-pricerange-start').val();
		var pricerange_end = jQuery('.wdt-sf-pricerange-end').val();

		// Features
		var features_query = {};
		var features_total_query = 0;
		jQuery('.wdt-sf-features-field-holder').each(function () {

			var field_type = jQuery(this).find('.wdt-sf-features-field-type').val();

			var tab_id = jQuery(this).find('.wdt-sf-features-tab-id').val();

			var features_item_data = {};

			features_item_data['field_type'] = field_type;

			if(field_type == 'dropdown' || field_type == 'list') {

				var item_values = jQuery(this).find('.wdt-sf-features option:selected').map(function(){
					if(this.value != '') {
						return this.value;
					}
				}).get();
				if(item_values.length === 0) {
					var item_values = jQuery(this).find('.wdt-sf-features:checked').map(function(){
						if(this.value != '') {
							return this.value;
						}
					}).get();
				}

				features_item_data['item_values'] = item_values;

				if(item_values.length != 0) {
					features_total_query = features_total_query + 1;
				}

			} else if(field_type == 'range') {

				var start = jQuery(this).find('.wdt-sf-features-start').val();
				var end = jQuery(this).find('.wdt-sf-features-end').val();

				features_item_data['start'] = start;
				features_item_data['end'] = end;

				features_total_query = features_total_query + 1;

			}

			features_query[tab_id] = features_item_data;

		});


		// Order By
		var orderby = jQuery('.wdt-sf-orderby option:selected').val();
		if(orderby === undefined) {
			var orderby = jQuery('.wdt-sf-orderby-list a.active').attr('data-itemvalue');
		}

		// MLS Number
		var mls_number = jQuery('.wdt-sf-mls-number').val();

		// Others
		var others = jQuery('.wdt-sf-others-list-item.active').map(function(){
			if(jQuery(this).attr('data-itemvalue') != '') {
				return jQuery(this).attr('data-itemvalue');
			}
		}).get();


		// Radius

		if(jQuery.inArray( 'nearby', others ) > -1) {

			if((radius == '' && radius_unit == '') || (radius == undefined && radius_unit == undefined)) {
				var radius = jQuery('.wdt-sf-location-max-radius').val();
				var radius_unit = jQuery('.wdt-sf-location-radius-unit').val();
			}

			if(radius == undefined && radius_unit == undefined) {
				var radius = 100;
				var radius_unit = 'km';
			}

		}

		var use_radius = '';
		if((radius != '' && radius_unit != '') && (radius != undefined && radius_unit != undefined)) {
			var use_radius = 'true';
		}


		// Create array
		var filter_data = {};
		filter_data['keyword']              = keyword;
		filter_data['user_latitude']        = user_latitude;
		filter_data['user_longitude']       = user_longitude;
		filter_data['use_radius']           = use_radius;
		filter_data['radius']               = radius;
		filter_data['radius_unit']          = radius_unit;
		filter_data['categories']           = categories;
		filter_data['tags']                 = tags;
		filter_data['startdate']            = startdate;
		filter_data['pricerange_start']     = pricerange_start;
		filter_data['pricerange_end']       = pricerange_end;
		filter_data['features_query']       = features_query;
		filter_data['features_total_query'] = features_total_query;
		filter_data['orderby']              = orderby;
		filter_data['mls_number']           = mls_number;
		filter_data['others']               = others;

		return filter_data;

	},

	wdtPortfolioImagePopup : function() {

		var enable_gallery_popup = jQuery('.wdt-listings-item-image-gallery-popup-enable');
		var repeater_items = enable_gallery_popup.find('.wdt-listings-item-container .wdt-listings-item-wrapper');
		
		jQuery(repeater_items).each(function() {
			var $this_item = jQuery(this);
			var $image_gallery = $this_item.find('.wdt-listings-item-bottom-section .wdt-listings-item-image-gallery').attr('data-media-gallery');
			var $image_click = $this_item.find('.wdt-listings-hover-image-icon');
			var $image_type = 'image';	

			if( $image_gallery !== undefined ) {
				$image_gallery = jQuery.parseJSON($image_gallery);

				var $gallery_data = [];
				jQuery.each( $image_gallery, function( key, value ) {

					var $gallery_fields = {};
					$gallery_fields['src'] = value;
					$gallery_fields['type'] = $image_type;

					$gallery_data.push($gallery_fields);

				} );
			}
			wdtPortfolioFrontendUtils.wdtPortfolioLoadPopup($gallery_data, $image_type, $image_click);
		});

	},

	wdtPortfolioLoadPopup : function($gallery_data, $image_type, $image_click) {

		$image_click.magnificPopup({
			items: $gallery_data,
			gallery: {
			enabled: true
			},
			removalDelay: 500,
			showCloseBtn: true,
			enableEscapeKey: true,
			closeOnBgClick: true,
			mainClass: 'wdt-portfolio-listing-image-box-popup wdt-portfolio-image-popup-window',
			type: $image_type // this is default type
		});
	},

	wdtPortfolioLoadDataOutput : function(output_container) {

		var load_data = load_map = 'false';

		if(output_container == undefined) {

			var output_container = map_output_container = '';
			if(jQuery('.wdt-listing-output-data-container.wdt-search-list-items').length) {
				var output_container = jQuery('.wdt-listing-output-data-container.wdt-search-list-items');
				load_data = 'true';
			}

			if(jQuery('.wdt-listing-output-map-container.wdt-search-list-items').length) {
				var map_output_container = jQuery('.wdt-listing-output-map-container.wdt-search-list-items');
				load_map = 'true';
			}

			if(load_data == 'false' && load_map == 'false') {
				alert(wdtfrontendobject.outputDivAlert);
				return;
			}

		} else {

			if(output_container.hasClass('wdt-listing-output-data-container')) {
				load_data = 'true';
			} else if(output_container.hasClass('wdt-listing-output-map-container')) {
				var map_output_container = output_container;
				output_container = '';
				load_map = 'true';
			}

		}

		if(load_data == 'true') {
			var parent_item = output_container;
		} else if(load_map == 'true') {
			var parent_item = map_output_container;
		}

		// Default options

		var enable_carousel = keyword = user_latitude = user_longitude = use_radius = radius = radius_unit = list_items = categories = tags = startdate = pricerange_start = pricerange_end = features_query = features_total_query = orderby = mls_number = others = '';

		var type = gallery = post_per_page = columns = apply_isotope = excerpt_length = features_image_or_icon = features_include = no_of_cat_to_display = apply_equal_height = '';

		var isotope_filter = apply_child_of = featured_items = custom_options = show_image_popup = '';

        var masonary_one_items = masonary_one_half_items = masonary_one_third_items = masonary_two_third_items = masonary_one_fourth_items = masonary_three_fourth_items = '';

		if(load_data == 'true') {

			type                   = output_container.find('.wdt-listing-output-data-holder').attr('data-type');
			gallery                = output_container.find('.wdt-listing-output-data-holder').attr('data-gallery');
			post_per_page          = output_container.find('.wdt-listing-output-data-holder').attr('data-postperpage');
			columns                = output_container.find('.wdt-listing-output-data-holder').attr('data-columns');
			apply_isotope          = output_container.find('.wdt-listing-output-data-holder').attr('data-applyisotope');
			excerpt_length         = output_container.find('.wdt-listing-output-data-holder').attr('data-excerptlength');
			features_image_or_icon = output_container.find('.wdt-listing-output-data-holder').attr('data-featuresimageoricon');
			features_include       = output_container.find('.wdt-listing-output-data-holder').attr('data-featuresinclude');
			no_of_cat_to_display   = output_container.find('.wdt-listing-output-data-holder').attr('data-noofcattodisplay');
			apply_equal_height     = output_container.find('.wdt-listing-output-data-holder').attr('data-applyequalheight');
			pagination_type        = output_container.find('.wdt-listing-output-data-holder').attr('data-paginationtype');

			isotope_filter         = output_container.find('.wdt-listing-output-data-holder').attr('data-isotopefilter');
			apply_child_of         = output_container.find('.wdt-listing-output-data-holder').attr('data-applychildof');
			featured_items         = output_container.find('.wdt-listing-output-data-holder').attr('data-featureditems');
			custom_options         = output_container.find('.wdt-listing-output-data-holder').attr('data-customoptions');

			show_image_popup       = output_container.find('.wdt-listing-output-data-holder').attr('data-showimagepopup');

		}

		// Direct item listings

		if((load_data == 'true' && output_container.hasClass('wdt-direct-list-items')) || (load_map == 'true' && map_output_container.hasClass('wdt-direct-list-items'))) {

			var item_type = output_holder_type = '';
			if(load_data == 'true') {
				item_type = 'data';
				output_holder_type = output_container;
			} else if(load_map == 'true') {
				item_type = 'map';
				output_holder_type = map_output_container;
			}

			// Filters

			var list_item_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-listitemids');
			if(list_item_ids != undefined && list_item_ids != '') {
				list_items = list_item_ids.split(',');
			}

			var category_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-categoryids');
			if(category_ids != undefined && category_ids != '') {
				categories = category_ids.split(',');
			}

			var tag_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-tagids');
			if(tag_ids != undefined && tag_ids != '') {
				tags = tag_ids.split(',');
			}

            // Masonary

            var masonary_one_item_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-masonaryoneitems');
			if(masonary_one_item_ids != undefined && masonary_one_item_ids != '') {
				masonary_one_items = masonary_one_item_ids.split(',');
			}

            var masonary_one_half_item_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-masonaryonehalfitems');
			if(masonary_one_half_item_ids != undefined && masonary_one_half_item_ids != '') {
				masonary_one_half_items = masonary_one_half_item_ids.split(',');
			}

            var masonary_one_third_item_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-masonaryonethirditems');
			if(masonary_one_third_item_ids != undefined && masonary_one_third_item_ids != '') {
				masonary_one_third_items = masonary_one_third_item_ids.split(',');
			}

            var masonary_two_third_item_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-masonarytwothirditems');
			if(masonary_two_third_item_ids != undefined && masonary_two_third_item_ids != '') {
				masonary_two_third_items = masonary_two_third_item_ids.split(',');
			}

            var masonary_one_fourth_item_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-masonaryonefourthitems');
			if(masonary_one_fourth_item_ids != undefined && masonary_one_fourth_item_ids != '') {
				masonary_one_fourth_items = masonary_one_fourth_item_ids.split(',');
			}

            var masonary_three_fourth_item_ids = output_holder_type.find('.wdt-listing-output-'+item_type+'-holder').attr('data-masonarythreefourthitems');
			if(masonary_three_fourth_item_ids != undefined && masonary_three_fourth_item_ids != '') {
				masonary_three_fourth_items = masonary_three_fourth_item_ids.split(',');
			}

			// Carousel

			var enable_carousel = output_holder_type.attr('data-enablecarousel');


		} else {

			// Filter options

			var filter_data      = wdtPortfolioFrontendUtils.wdtPortfolioFilterOptions();
			keyword              = filter_data.keyword;
			user_latitude        = filter_data.user_latitude;
			user_longitude       = filter_data.user_longitude;
			use_radius           = filter_data.use_radius;
			radius               = filter_data.radius;
			radius_unit          = filter_data.radius_unit;
			categories           = filter_data.categories;
			tags                 = filter_data.tags;
			startdate            = filter_data.startdate;
			pricerange_start     = filter_data.pricerange_start;
			pricerange_end       = filter_data.pricerange_end;
			features_query       = filter_data.features_query;
			features_total_query = filter_data.features_total_query;
			orderby              = filter_data.orderby;
			mls_number           = filter_data.mls_number;
			others               = filter_data.others;

			// Filter Option in Output Data Container
			if(categories == '') {
				if(load_data == 'true') {
					var category_ids = output_container.find('.wdt-listing-output-data-holder').attr('data-categoryids');
				} else if(load_map == 'true') {
					var category_ids = map_output_container.find('.wdt-listing-output-map-holder').attr('data-categoryids');
				}
				if(category_ids != undefined && category_ids != '') {
					categories = category_ids.split(',');
				}
			}

		}

		var data_apply_isotope = apply_isotope;
		var data_load_map      = load_map;

		jQuery.ajax({
			type: "POST",
			url: wdtfrontendobject.ajaxurl,
			dataType: "JSON",
			data:
			{
				action                : 'wdt_generate_load_search_data_ouput',
				current_page          : 1,
				offset                : 0,
				type                  : type,
				gallery               : gallery,
				post_per_page         : post_per_page,
				columns               : columns,
				apply_isotope         : apply_isotope,
				isotope_filter        : isotope_filter,
				apply_child_of        : apply_child_of,
				featured_items        : featured_items,
				excerpt_length        : excerpt_length,
				features_image_or_icon: features_image_or_icon,
				features_include      : features_include,
				no_of_cat_to_display  : no_of_cat_to_display,
				apply_equal_height    : apply_equal_height,
				pagination_type       : pagination_type,

				custom_options        : custom_options,

				keyword               : keyword,
				user_latitude         : user_latitude,
				user_longitude        : user_longitude,
				use_radius            : use_radius,
				radius                : radius,
				radius_unit           : radius_unit,
				list_items            : list_items,
				categories            : categories,
				tags                  : tags,

				show_image_popup      : show_image_popup,

                masonary_one_items         : masonary_one_items,
                masonary_one_half_items    : masonary_one_half_items,
                masonary_one_third_items   : masonary_one_third_items,
                masonary_two_third_items   : masonary_two_third_items,
                masonary_one_fourth_items  : masonary_one_fourth_items,
                masonary_three_fourth_items: masonary_three_fourth_items,

				startdate             : startdate,
				pricerange_start      : pricerange_start,
				pricerange_end        : pricerange_end,
				features_query        : features_query,
				features_total_query  : features_total_query,
				orderby               : orderby,
				mls_number            : mls_number,
				others                : others,

				enable_carousel       : enable_carousel,
				load_data             : load_data,
				load_map              : load_map
			},
			beforeSend: function(){
				wdtPortfolioCommonUtils.wdtPortfolioAjaxBeforeSend(parent_item);
			},
			success: function (response) {

				// Load data
				if(load_data == 'true') {

					output_container.find('.wdt-listing-output-data-holder').html(response.data);

					if(data_apply_isotope == 'true') {
						// Isotope
						wdtPortfolioFrontendUtils.wdtPortfolioListingsListingIsotope(false);
					} else if(enable_carousel == 'true') {
						// Carousel
						wdtPortfolioFrontendUtils.wdtPortfolioListingCarousel(output_container);
					} else if(apply_equal_height == 'true') {
						//Equal Height
						output_container.find('.wdt-listings-item-wrapper').matchHeight({ property:"min-height" });
					}

					setTimeout(function(){
						wdtPortfolioFrontendUtils.wdtPortfolioListingImageSwiperGallery();
						if(jQuery.fn.niceScroll !== undefined) {
							jQuery('html').getNiceScroll().resize();
						}

						wdtPortfolioFrontendUtils.wdtPortfolioImagePopup();					
					},1000);

				}

				// Load map
				if(data_load_map == 'true' && map_output_container != undefined) {
					wdtPortfolioFrontendLocationUtils.wdtPortfolioLoadMapOutput(response.dataids, map_output_container);
				}

			},
			complete: function(){
				wdtPortfolioCommonUtils.wdtPortfolioAjaxAfterSend(parent_item);
			}
		});


	},

	wdtPortfolioAjaxPagination : function() {

		jQuery( 'body' ).delegate( '.wdt-listing-pagination a:not(.disabled)', 'click', function(e) {

            e.preventDefault();

			var this_item = jQuery(this);

            if(this_item.parents('.wdt-listing-pagination').hasClass('wdt-loadmore-pagination loaded')){
                return false;
            }

			var listing_options = this_item.parents('.wdt-pagination').attr('data-listing-options');
			listing_options = jQuery.parseJSON(listing_options);

            var pagination_type = listing_options['pagination_type'];

			// Pagination Data
            var current_page;
            if(pagination_type == 'numbered') {
                var dynamic_pagination = false;
                if(this_item.parent().hasClass('prev-post')) {
                    current_page = parseInt(this_item.attr('data-currentpage'), 10)-1;
                } else if(this_item.parent().hasClass('next-post')) {
                    current_page = parseInt(this_item.attr('data-currentpage'), 10)+1;
                } else {
                    current_page = this_item.text();
                }
            } else if(pagination_type == 'loadmore' || pagination_type == 'infinity') {
                var dynamic_pagination = true;
                current_page = parseInt(this_item.attr('data-currentpage'), 10) + 1;
            }

			var post_per_page = listing_options['post_per_page'];

			if(current_page == 1) {
				var offset = 0;
			} else if(current_page > 1) {
				var offset = ((current_page-1)*post_per_page);
			}

			var function_call      = this_item.parents('.wdt-pagination').attr('data-functioncall');
			var output_div         = this_item.parents('.wdt-pagination').attr('data-outputdiv');

			var apply_isotope      = listing_options['apply_isotope'];
			var enable_carousel    = listing_options['enable_carousel'];
			var loader             = listing_options['loader'];
			var loader_parent      = listing_options['loader_parent'];
			var apply_equal_height = listing_options['apply_equal_height'];
			var parent_item        = this_item.parents(loader_parent);

			var default_options =
			{
                dynamic_pagination: dynamic_pagination,
				action       : function_call,
				current_page : current_page,
				offset       : offset
			};

			var list_items = categories = tags = keyword = user_latitude = user_longitude = use_radius = radius = radius_unit = startdate = pricerange_start = pricerange_end = features_query = features_total_query = orderby = mls_number = others = '';


			if(this_item.parents().hasClass('wdt-direct-list-items')) {

				var item_type = '';
				var map_output_container = '';
				if(this_item.parents('.wdt-direct-list-items').hasClass('wdt-listing-output-data-container')) {
					var output_container = this_item.parents('.wdt-direct-list-items');
					item_type = 'data';
				} else if(this_item.parents('.wdt-direct-list-items').hasClass('wdt-listing-output-map-container')) {
					var map_output_container = this_item.parents('.wdt-direct-list-items');
					item_type = 'map';
				}

				// Filters

				var list_item_ids = output_container.find('.wdt-listing-output-'+item_type+'-holder').attr('data-listitemids');
				if(list_item_ids != undefined && list_item_ids != '') {
					list_items = list_item_ids.split(',');
				}

				var category_ids = output_container.find('.wdt-listing-output-'+item_type+'-holder').attr('data-categoryids');
				if(category_ids != undefined && category_ids != '') {
					categories = category_ids.split(',');
				}

				var tag_ids = output_container.find('.wdt-listing-output-'+item_type+'-holder').attr('data-tagids');
				if(tag_ids != undefined && tag_ids != '') {
					tags = tag_ids.split(',');
				}

				var unique_options =
				{
					list_items          : list_items,
					categories          : categories,
					tags                : tags
				};

			} else {

				var output_container = jQuery('.wdt-listing-output-data-container');
				var map_output_container = jQuery('.wdt-listing-output-map-container');


				// Filter options

				var filter_data      = wdtPortfolioFrontendUtils.wdtPortfolioFilterOptions();
				keyword              = filter_data.keyword;
				user_latitude        = filter_data.user_latitude;
				user_longitude       = filter_data.user_longitude;
				use_radius           = filter_data.use_radius;
				radius               = filter_data.radius;
				radius_unit          = filter_data.radius_unit;
				categories           = filter_data.categories;
				tags                 = filter_data.tags;
				startdate            = filter_data.startdate;
				pricerange_start     = filter_data.pricerange_start;
				pricerange_end       = filter_data.pricerange_end;
				features_query       = filter_data.features_query;
				features_total_query = filter_data.features_total_query;
				orderby              = filter_data.orderby;
				mls_number           = filter_data.mls_number;
				others               = filter_data.others;

				// Filter Option in Output Data Container
				if(categories == '') {
					var category_ids = output_container.find('.wdt-listing-output-data-holder').attr('data-categoryids');
					if(category_ids != undefined && category_ids != '') {
						categories = category_ids.split(',');
					}
				}

				var unique_options =
				{
					keyword             : keyword,
					user_latitude       : user_latitude,
					user_longitude      : user_longitude,
					use_radius          : use_radius,
					radius              : radius,
					radius_unit         : radius_unit,
					categories          : categories,
					tags                : tags,
					startdate           : startdate,
					pricerange_start    : pricerange_start,
					pricerange_end      : pricerange_end,
					features_query      : features_query,
					features_total_query: features_total_query,
					orderby             : orderby,
					mls_number          : mls_number,
					others              : others,
				};

			}

			var consolidated_options = Object.assign(default_options, listing_options, unique_options);
			consolidated_options['custom_options'] = consolidated_options['custom_options'] ? JSON.stringify(consolidated_options['custom_options']) : '';

			// ajax call
			jQuery.ajax({
				type: "POST",
				url: wdtcommonobject.ajaxurl,
				dataType: "JSON",
				data: consolidated_options,
				beforeSend: function() {
					if(loader == 'true') {
						wdtPortfolioCommonUtils.wdtPortfolioAjaxBeforeSend(parent_item);
					}
                    if(pagination_type == 'loadmore') {
                        this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
                    }
				},
				success: function (response) {

                    if(pagination_type == 'numbered') {

                        var offset_top = this_item.parents('.'+output_div).offset().top;

                        this_item.parents('.'+output_div).html(response.data);

                        if(apply_isotope == 'true') {
                            // Isotope
                            wdtPortfolioFrontendUtils.wdtPortfolioListingsListingIsotope(false);
                        } else if(enable_carousel == 'true') {
                            // Carousel
                            wdtPortfolioFrontendUtils.wdtPortfolioListingCarousel(output_container);
                        } else if(apply_equal_height == 'true') {
                            //Equal Height
                            output_container.find('.wdt-listings-item-wrapper').matchHeight({ property:"min-height" });
                        }

                        setTimeout(function(){
                            wdtPortfolioFrontendUtils.wdtPortfolioListingImageSwiperGallery();
                            if(jQuery.fn.niceScroll !== undefined) {
                                jQuery('html').getNiceScroll().resize();
                            }
                        },1000);

                        // Load map
                        if(map_output_container.length) {
                            wdtPortfolioFrontendLocationUtils.wdtPortfolioLoadMapOutput(response.dataids, map_output_container);
                        }

                        // Scroll to top
                        jQuery('html, body').animate({
                            scrollTop: parseInt(offset_top, 10)-60
                        }, 600);

                    } else if(pagination_type == 'loadmore' || pagination_type == 'infinity') {

                        if(response.dataids.length) {

                            this_item.parents('.'+output_div).find('.wdt-listings-item-container').append(response.data);
                            this_item.attr('data-currentpage', current_page);

                            if(apply_isotope == 'true') {
                                // Isotope
                                wdtPortfolioFrontendUtils.wdtPortfolioListingsListingIsotope(true);
                            } else if(enable_carousel == 'true') {
                                // Carousel
                                wdtPortfolioFrontendUtils.wdtPortfolioListingCarousel(output_container);
                            } else if(apply_equal_height == 'true') {
                                //Equal Height
                                output_container.find('.wdt-listings-item-wrapper').matchHeight({ property:"min-height" });
                            }

                            setTimeout(function(){
                                wdtPortfolioFrontendUtils.wdtPortfolioListingImageSwiperGallery();
                                if(jQuery.fn.niceScroll !== undefined) {
                                    jQuery('html').getNiceScroll().resize();
                                }
                            },1000);

                            // Load map
                            if(map_output_container.length) {
                                wdtPortfolioFrontendLocationUtils.wdtPortfolioLoadMapOutput(response.dataids, map_output_container);
                            }

                        } else {
                            this_item.html(wdtfrontendobject.noMorePosts);
                            this_item.parents('.wdt-loadmore-pagination').addClass('loaded');
                        }

                    }

				},
				complete: function() {
					if(loader == 'true') {
						wdtPortfolioCommonUtils.wdtPortfolioAjaxAfterSend(parent_item);
					}
                    if(pagination_type == 'loadmore') {
                        this_item.find('span').remove();
                    }
				}
			});

		});

        window.addEventListener('scroll', () => {

            let infinityItem = jQuery('.wdt-infinity-pagination');

            if(infinityItem.length) {

                const scrollTop = document.documentElement.scrollTop;

                let infinityItemOffset = infinityItem.offset();
                let infinityItemOffsetTop = Math.floor(infinityItemOffset.top - 400);

                if(scrollTop >= infinityItemOffsetTop) {
                    jQuery('.wdt-listing-pagination a').trigger('click');
                    jQuery('.wdt-listing-pagination a').addClass('disabled');
                } else {
                    jQuery('.wdt-listing-pagination a').removeClass('disabled');
                }

            }

        });

	},

	wdtPortfolioListingImageSwiperGallery : function() {

		// Image gallery swiper
		var swiperGallery = [];
		var swiperGalleryOptions = [];
		var swiperIterator = 1;

		jQuery('.wdt-listings-image-gallery-container').each(function() {

			var $swiperItem = jQuery(this);
			var swiperUniqueId = 'swiperuniqueid-imggal-'+swiperIterator;

			swiperGalleryOptions[swiperUniqueId] = [];
			$swiperItem.attr('id', swiperUniqueId);

			// Get swiper options
			var effect = $swiperItem.attr('data-carouseleffect');
			var autoheight = false;

			var paginationtype = ($swiperItem.attr('data-carouselpaginationtype') != '') ? $swiperItem.attr('data-carouselpaginationtype') : '';

			var autoplay = parseInt($swiperItem.attr('data-carouselautoplay'), 10);
			if(autoplay > 0) {
				swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] = true;
				autoplay_enable = true;
			} else {
				swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] = false;
				autoplay_enable = false;
			}

			var slidesperview = parseInt($swiperItem.attr('data-carouselslidesperview'), 10);
			swiperGalleryOptions[swiperUniqueId]['centeredslides'] = true;
			if(slidesperview > 1) {
				swiperGalleryOptions[swiperUniqueId]['centeredslides'] = false;
			}

			var noofimages = parseInt($swiperItem.attr('data-carouselnoofimages'), 10);
			var initialSlide = 0;
			if(slidesperview > 2) {
				initialSlide = 2;
				swiperGalleryOptions[swiperUniqueId]['initialSlide'] = 2;
			}

			var loopmode = ($swiperItem.attr('data-carouselloopmode') == 'true') ? true : false;
			var mousewheelcontrol = ($swiperItem.attr('data-carouselmousewheelcontrol') == 'true') ? true : false;
			var verticaldirection = ($swiperItem.attr('data-carouselverticaldirection') == 'true') ? true : false;
			var direction = 'horizontal';
			swiperGalleryOptions[swiperUniqueId]['direction'] = 'horizontal';
			if(verticaldirection) {
				direction = 'vertical';
				swiperGalleryOptions[swiperUniqueId]['direction'] = 'vertical';
			}

			var pagination_class = '';
			var pagination_type = '';
			var watch_state = false;


			if(paginationtype == 'bullets') {
				var pagination_class = $swiperItem.find('.wdt-swiper-bullet-pagination');
				var pagination_type = 'bullets';
				var watch_state = true;
			}

			if(paginationtype == 'fraction') {
				var pagination_class =  $swiperItem.find('.wdt-swiper-fraction-pagination');
				var pagination_type = 'fraction';
			}

			if(paginationtype == 'progressbar') {
				var pagination_class =  $swiperItem.find('.wdt-swiper-progress-pagination');
				var pagination_type = 'progressbar';
			}

			var scrollbar_class = '';
			var	scrollbar_hide = true;
			if(paginationtype == 'scrollbar') {
				scrollbar_class = $swiperItem.find('.wdt-swiper-scrollbar');
				scrollbar_hide = false;
			}

			if(paginationtype == 'thumbnail') {
				swiperGalleryOptions[swiperUniqueId]['thumbnailpagination'] = true;
				swiperGalleryOptions[swiperUniqueId]['numberofthumbnails'] = $swiperItem.attr('data-carouselnumberofthumbnails');
				loopmode = false;
			} else {
				swiperGalleryOptions[swiperUniqueId]['thumbnailpagination'] = false;
			}

			var spacebetween = parseInt($swiperItem.attr('data-carouselspacebetween'), 10);
			if(spacebetween) {
				spacebetween = spacebetween;
			} else {
				spacebetween = 0;
			}

			if(slidesperview == 1) {
				var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 1;
			} else if(slidesperview == 2) {
				var breakpoint_slides_1 = 2; var breakpoint_slides_2 = 2; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
			} else if(slidesperview == 3) {
				var breakpoint_slides_1 = 3; var breakpoint_slides_2 = 3; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
			} else if(slidesperview >= 4) {
				var breakpoint_slides_1 = 4; var breakpoint_slides_2 = 3; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
			}

			// Generate swiper
		    swiperGallery[swiperUniqueId] = new Swiper($swiperItem, {

     			initialSlide: initialSlide,
                simulateTouch: true,
                roundLengths: true,
                spaceBetween: spacebetween,
                keyboardControl: true,
                paginationClickable: true,
                autoHeight: autoheight,

                grabCursor: true,
                autoplay: {
                			enabled: autoplay_enable,
						    delay: autoplay,
						},
                slidesPerView: slidesperview,
                loop:loopmode,
                mousewheel: mousewheelcontrol,
                direction: direction,

 				hashNavigation: {
					watchState: watch_state
				},

				pagination: {
					el: pagination_class,
					type: pagination_type,
					clickable: true,
					renderFraction: function (currentClass, totalClass) {
						return '<span class="' + currentClass + '"></span>' +
								'<span class="wdt-separator"></span>' +
								'<span class="' + totalClass + '"></span>';
					}
				},

				scrollbar: {
					el: scrollbar_class,
					hide: scrollbar_hide,
					draggable: true,
				},

                effect: effect,
				coverflowEffect: {
					slideShadows: false,
					rotate: 0,
					stretch: 0,
					depth: 200,
					modifier: 1,
				},
		        cubeEffect: {
		        	slideShadows: true,
		            shadow: true,
		            shadowOffset: 20,
		            shadowScale: 0.94
		        },

		        breakpoints: {
		            1024: {
		                slidesPerView: breakpoint_slides_1,
		            },
		            768: {
		                slidesPerView: breakpoint_slides_2,
		            },
		            640: {
		                slidesPerView: breakpoint_slides_3,
		            },
		            320: {
		                slidesPerView: breakpoint_slides_4,
		            }
		        },

		    });


		    // Arrow pagination
	    	var arrowpagination = ($swiperItem.attr('data-carouselarrowpagination') == 'true') ? true : false;

	    	if(arrowpagination) {

			    $swiperItem.find('.wdt-listings-swiper-pagination-holder .wdt-swiper-arrow-pagination .wdt-swiper-arrow-prev').on('click', function(e) {
			    	var swiperUniqueId = $swiperItem.attr('id');
			        swiperGallery[swiperUniqueId].slidePrev();
			        if(swiperGalleryOptions[swiperUniqueId]['autoplay_enable']) {
			        	swiperGallery[swiperUniqueId].autoplay.start();
			        }
			        e.preventDefault();
			    });

			    $swiperItem.find('.wdt-listings-swiper-pagination-holder .wdt-swiper-arrow-pagination .wdt-swiper-arrow-next').on('click', function(e) {
			    	var swiperUniqueId = $swiperItem.attr('id');
			        swiperGallery[swiperUniqueId].slideNext();
			        if(swiperGalleryOptions[swiperUniqueId]['autoplay_enable']) {
			        	swiperGallery[swiperUniqueId].autoplay.start();
			        }
			        e.preventDefault();
			    });

			}

		    swiperIterator++;

		});

		// Generate gallery thumb pagination
		for(i = 1; i < swiperIterator; i++) {
			if(swiperGalleryOptions['swiperuniqueid-imggal-'+i]['thumbnailpagination']) {

				var swiperUniqueId = 'swiperuniqueid-imggal-'+i;

				var $swiper_gallerythumb_item = jQuery('#'+swiperUniqueId).parents('.wdt-listings-image-gallery-holder').find('.wdt-listings-image-gallery-thumb-container');

			    var swiperGalleryThumbs = new Swiper($swiper_gallerythumb_item, {
			    	initialSlide       : swiperGalleryOptions[swiperUniqueId]['initialSlide'],
			        spaceBetween       : 10,
			        direction          : swiperGalleryOptions[swiperUniqueId]['direction'],
			        centeredSlides     : swiperGalleryOptions[swiperUniqueId]['centeredslides'],
			        slidesPerView      : swiperGalleryOptions[swiperUniqueId]['numberofthumbnails'],
			        touchRatio         : 0.2,
			        slideToClickedSlide: true
			    });

			    swiperGallery[swiperUniqueId].controller.control = swiperGalleryThumbs;
			    swiperGalleryThumbs.controller.control = swiperGallery[swiperUniqueId];

			}
		}

	},

	wdtPortfolioContentScroll : function() {

		if(jQuery('.wdt-content-scroll').length) {

			var head = document.getElementsByTagName('head')[0];
			var script = document.createElement('script');
			script.src = wdtfrontendobject.pluginPath+'assets/js/jquery.nicescroll.js';
			script.type = 'text/javascript';
			head.appendChild(script);

			jQuery('.wdt-content-scroll').niceScroll({ cursorcolor:wdtfrontendobject.primaryColor, cursorwidth: '5px', background:wdtfrontendobject.tertiaryColor, cursorborder:'none' });

		}

	},

	wdtPortfolioResponsiveMortageCalculator : function() {

		if(jQuery('.lidd_mc_form').length) {

			jQuery('.lidd_mc_input input[type="text"]').each(function() {
				jQuery( this ).wrap( '<div class="wdt-rmc-field-wrap"></div>' );
				jQuery( '<span></span>' ).insertAfter( jQuery(this) );
			});

		}

	}

};

var wdtPortfolioFrontend = {

	dtInit : function() {

		var isMobile = (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/Android/i)) || (navigator.userAgent.match(/Blackberry/i)) || (navigator.userAgent.match(/Windows Phone/i)) ? true : false;
		var currentWidth = window.innerWidth || document.documentElement.clientWidth;

		wdtPortfolioFrontend.wdtPortfolio(isMobile, currentWidth);
		wdtPortfolioFrontend.dtLoadData();

	},

	wdtPortfolio : function(isMobile, currentWidth) {

		jQuery(window).on('resize', function() {
			wdtPortfolioFrontendUtils.wdtPortfolioListingsListingIsotope(false);
			wdtPortfolioFrontendUtils.wdtPortfolioContentScroll();
		});

		wdtPortfolioFrontendUtils.wdtPortfolioListingsListingIsotope(false);

		wdtPortfolioFrontendUtils.wdtPortfolioAjaxPagination();

		// Image Swiper Gallery for Listings & Single Page
			wdtPortfolioFrontendUtils.wdtPortfolioListingImageSwiperGallery();

		wdtPortfolioFrontendUtils.wdtPortfolioContentScroll();

		wdtPortfolioFrontendUtils.wdtPortfolioResponsiveMortageCalculator();

	},

	dtLoadData : function() {

		jQuery('.wdt-direct-list-items').each(function() {
			wdtPortfolioFrontendUtils.wdtPortfolioLoadDataOutput(jQuery(this));
		});

	},

};

jQuery(document).ready(function() {

	if(!wdtfrontendobject.elementorPreviewMode) {
		wdtPortfolioFrontend.dtInit();
	}

});

( function( $ ) {

	var wdtPortfolioFrontendJs = function($scope, $){
		wdtPortfolioFrontend.dtInit();
	};

    $(window).on('elementor/frontend/init', function(){
		if(wdtfrontendobject.elementorPreviewMode) {
			elementorFrontend.hooks.addAction('frontend/element_ready/wdt-widget-df-listings-listing.default', wdtPortfolioFrontendJs);
		}
	});

} )( jQuery );