<?php

/* Product Listing - Shortcodes */

if(!function_exists('xoha_shop_product_listing_html')) {
	function xoha_shop_product_listing_html($attrs, $content = null) {

		$attrs = shortcode_atts ( array (
			'data_source'                   => '',
			'show_pagination'               => '',
			'enable_carousel'               => '',
			'post_per_page'                 => 12,
			'display_mode'                  => 'grid',
			'columns'                       => 4,
			'list_options'                  => 'left-thumb',
			'product_style_template'        => -1,

			'current_page'                  => 1,
			'offset'                        => 0,
			'categories'                    => '',
			'tags'                          => '',
			'include'                       => '',
			'exclude'                       => '',

			'carousel_effect'               => '',
			'carousel_slidesperview'        => 2,
			'carousel_slidespercolumn'      => 2,
			'carousel_loopmode'             => '',
			'carousel_mousewheelcontrol'    => '',
			'carousel_bulletpagination'     => '',
			'carousel_arrowpagination'      => '',
			'carousel_arrowpagination_type' => '',
			'carousel_scrollbar'            => '',
			'carousel_spacebetween'         => '',

			'class'                         => ''
		), $attrs );

		$out = xoha_shop_products_render_html($attrs);

		return $out;

	}
	add_shortcode( 'xoha_shop_product_listing', 'xoha_shop_product_listing_html' );
}

if(!function_exists('xoha_shop_products_render_html')) {
	function xoha_shop_products_render_html($settings) {

		// Remove these theme support to avoid conflict with yith quiz view gallery zoom - Start
		remove_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
		remove_theme_support( 'wc-product-gallery-slider' );
		// Remove these theme support to avoid conflict with yith quiz view gallery zoom - End


		$output = '';

		if ( isset( $_REQUEST['xoha_shop_search_submit'] ) && !empty( $_REQUEST['xoha_shop_search_submit'] ) ) {
			$settings['page_requests'] = $_REQUEST;
		}

		$ps_nonce_verified = false;
		if ( isset( $settings['page_requests']['xoha_shop_product_search_nonce'] ) && wp_verify_nonce( $settings['page_requests']['xoha_shop_product_search_nonce'], 'xoha_shop_product_search' ) ) {
			$ps_nonce_verified = true;
		}


		$woo_product_style_template = $settings['product_style_template'];

		if($settings['display_mode'] == 'list') {
			$settings['columns'] = 1;
			$settings['carousel_slidesperview'] = 1;
		}

		$media_carousel_attributes_string = $container_class = $wrapper_class = $item_class = '';

		if($settings['enable_carousel'] == 'true') {

			$media_carousel_attributes = array ();

			array_push($media_carousel_attributes, 'data-carouseleffect="'.$settings['carousel_effect'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperview="'.$settings['carousel_slidesperview'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidespercolumn="'.$settings['carousel_slidespercolumn'].'"');
			array_push($media_carousel_attributes, 'data-carouselloopmode="'.$settings['carousel_loopmode'].'"');
			array_push($media_carousel_attributes, 'data-carouselmousewheelcontrol="'.$settings['carousel_mousewheelcontrol'].'"');
			array_push($media_carousel_attributes, 'data-carouselbulletpagination="'.$settings['carousel_bulletpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselarrowpagination="'.$settings['carousel_arrowpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselscrollbar="'.$settings['carousel_scrollbar'].'"');
			array_push($media_carousel_attributes, 'data-carouselspacebetween="'.$settings['carousel_spacebetween'].'"');

			if(!empty($media_carousel_attributes)) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}


			$container_class = 'swiper-container';
			$wrapper_class = 'swiper-wrapper';
			$item_class = 'swiper-slide';

			$output .= '<div class="wdt-products-carousel-container">';

		} else {
			$wrapper_class = 'products-apply-isotope';
		}

		// Loop variables setup
		wc_set_loop_prop('non_archive_listing', 1);
		wc_set_loop_prop('item_class', $item_class);
		wc_set_loop_prop('columns', $settings['columns']);

		$type_class_instance = 'xoha_woo_listing_type_custom';
		if ( function_exists( $type_class_instance ) ) {

			if( $settings['product_style_template'] == -1 ) {
				$type_class_instance()->custom_template = xoha_customizer_settings('wdt-woo-shop-page-product-style-template' );
			} else {
				$type_class_instance()->custom_template = $settings['product_style_template'];
			}

			$type_options = $type_class_instance()->set_type_options();

			if( is_array ( $type_options ) && !empty ( $type_options ) ) {
				foreach ( $type_options as $type_option_key => $type_option ) {

					$type_option_key = str_replace( 'product-', '', $type_option_key);
					$type_option_key = str_replace( '-', '_', $type_option_key);
					$option_class_instance = 'xoha_woo_listing_option_'.$type_option_key;  // Option Class Instance

					if ( function_exists( $option_class_instance ) ) {

						$option_class_instance()->option_default_value = $type_option;
						$option_class_instance()->render_frontend();
						$option_class_instance()->woo_listings_loop_prop();

					}

				}
			}

			$type_class_instance()->for_non_archive_listing();
			$type_class_instance()->render_frontend();

			wc_set_loop_prop('product-display-type', $settings['display_mode']);
			wc_set_loop_prop('product-display-type-list-option', $settings['list_options']);

		}

		$output .= '<div class="wdt-products-container woocommerce '.$settings['class'].' '.$container_class.'" '.$media_carousel_attributes_string.'>';

			$classes = apply_filters( 'xoha_woo_listings_class', array () );
			$classes = ( is_array ($classes) && !empty ($classes) ) ? implode( ' ', $classes ) : '';

			$output .= '<ul class="products '.$wrapper_class.' '.$classes.'">';

				if($settings['enable_carousel'] != 'true') {
					$output .= '<li class="product isotope-grid-sizer"><div class="'.xoha_woo_loop_column_class($settings['columns']).'"></div></li>';
				}

				ob_start();

					if( empty( $settings['post_per_page'] ) ) {
						$settings['post_per_page'] = -1;
					}

					$args = array(
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'posts_per_page' => $settings['post_per_page'],
						'meta_query'     => array (),
						'tax_query'      => array (),
						'offset'         => $settings['offset'],
						'paged'          => $settings['current_page'],
					);

					if($ps_nonce_verified) {
						if(isset($settings['page_requests']['xoha_shop_search_keyword']) && $settings['page_requests']['xoha_shop_search_keyword'] != '') {
							$args['s'] = $settings['page_requests']['xoha_shop_search_keyword'];
						}
					}


					// Exclude hidden products
					$args['tax_query'][] = array(
						'taxonomy'         => 'product_visibility',
						'terms'            => array( 'exclude-from-catalog', 'exclude-from-search' ),
						'field'            => 'name',
						'operator'         => 'NOT IN',
						'include_children' => false,
					);


					// Categories
					if($ps_nonce_verified) {

						$xoha_shop_search_categories = array ();

						if(isset($settings['page_requests']['xoha_shop_search_categories']) && !empty($settings['page_requests']['xoha_shop_search_categories'])) {
							$xoha_shop_search_categories = $settings['page_requests']['xoha_shop_search_categories'];
						}

						if(!empty($xoha_shop_search_categories)) {
							$args['tax_query'][] = array (
														'taxonomy' => 'product_cat',
														'field'    => 'id',
														'terms'    => $xoha_shop_search_categories,
														'operator' => 'IN'
													);
						}

					} else {
						if(is_array($settings['categories']) && !empty($settings['categories'])) {
							$args['tax_query'][] = array (
														'taxonomy' => 'product_cat',
														'field'    => 'id',
														'terms'    => $settings['categories'],
														'operator' => 'IN'
													);
						}
					}

					// Tags
					if(is_array($settings['tags']) && !empty($settings['tags'])) {
						$args['tax_query'][] = array (
													'taxonomy' => 'product_tag',
													'field'    => 'id',
													'terms'    => $settings['tags'],
													'operator' => 'IN'
												);
					}

					// Include
					$include = ($settings['include'] != '') ? explode(',', $settings['include']) : array ();
					if(!empty($include)) {
						$args['post__in'] = $include;
					}

					// Exclude
					$exclude = ($settings['exclude'] != '') ? explode(',', $settings['exclude']) : array ();
					if(!empty($exclude)) {
						$args['post__not_in'] = $exclude;
					}

					// Data Source

					# Featured
					if ( $settings['data_source'] == 'featured' ) {
						$args['tax_query'][] = array (
													'taxonomy' => 'product_visibility',
													'field'    => 'name',
													'terms'    => 'featured',
													'operator' => 'IN',
												);
					}

					# Sale
					if ( $settings['data_source'] == 'sale' ) {
						if(!empty($include)) {
							$args['post__in'] = array_merge( $include, wc_get_product_ids_on_sale() );
						} else {
							$args['post__in'] = wc_get_product_ids_on_sale();
						}
					}

					# Best Seller
					if ( $settings['data_source'] == 'bestseller' ) {
						$args['orderby'] = 'meta_value_num';
						$args['meta_key'] = 'total_sales';
					}

					# Recent
					if ( $settings['data_source'] == 'recent' ) {
						$args['orderby'] = 'date';
						$args['order'] = 'DESC';
					}

					// Loop

					$products = new WP_Query( $args );

					if ( $products->have_posts() ) :
						while ( $products->have_posts() ) :
							$products->the_post();
							wc_get_template_part( 'content', 'product' );
						endwhile;
					endif;

					wp_reset_postdata();

				$output .= ob_get_clean();

			$output .= '</ul>';

			$max_num_pages = $products->max_num_pages;

			// For pagination
			if($settings['show_pagination'] == 'true') {
				$shortcode_settings = json_encode($settings);
				$output .= xoha_shop_products_ajax_pagination($max_num_pages, $settings['current_page'], $settings['post_per_page'], 'xoha_shop_products_ajax_call', 'wdt-products-container', $shortcode_settings);
			}

			if($settings['enable_carousel'] == 'true') {

				$output .= '<div class="wdt-products-pagination-holder">';

					if($settings['carousel_bulletpagination'] == 'true') {
						$output .= '<div class="wdt-products-bullet-pagination"></div>';
					}

					if($settings['carousel_scrollbar'] == 'true') {
						$output .= '<div class="wdt-products-scrollbar"></div>';
					}

					if($settings['carousel_arrowpagination'] == 'true') {
						$output .= '<div class="wdt-products-arrow-pagination '.$settings['carousel_arrowpagination_type'].'">';
							$output .= '<a href="#" class="wdt-products-arrow-prev">'.esc_html__('Prev', 'xoha-pro').'</a>';
							$output .= '<a href="#" class="wdt-products-arrow-next">'.esc_html__('Next', 'xoha-pro').'</a>';
						$output .= '</div>';
					}

				$output .= '</div>';

			}

		$output .= '</div>';

		// Reset the loop.
		wc_reset_loop();

		if($settings['enable_carousel'] == 'true') {
			$output .= '</div>';
		}

		return $output;

	}
}



// Product Shortcode - Ajax Call

if ( ! function_exists( 'xoha_shop_products_ajax_call' ) ) {

	function xoha_shop_products_ajax_call() {

		$productpagination_nonce = $_POST['productpagination_nonce'];
		if(isset($productpagination_nonce) && wp_verify_nonce($productpagination_nonce, 'productpagination_nonce')) {

			$shortcodeattrs_settings = json_decode(html_entity_decode(stripslashes($_REQUEST['shortcodeattrs'])), true);

			$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : 1;
			$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;

			$shortcodeattrs_settings['current_page'] = $current_page;
			$shortcodeattrs_settings['offset'] = $offset;

			$output = xoha_shop_products_render_html($shortcodeattrs_settings);

			echo xoha_html_output($output);

		}

		wp_die();

	}

	add_action( 'wp_ajax_xoha_shop_products_ajax_call', 'xoha_shop_products_ajax_call' );
	add_action( 'wp_ajax_nopriv_xoha_shop_products_ajax_call', 'xoha_shop_products_ajax_call' );

}

// Product Shortcode - Ajax Pagination

if ( ! function_exists( 'xoha_shop_products_ajax_pagination' ) ) {

	function xoha_shop_products_ajax_pagination($max_num_pages, $current_page, $post_per_page, $function_call, $output_div, $shortcode_attrs) {

		$output = '';

		if($max_num_pages > 1) {

			$output .= '<div class="wdt-product-pagination wdt-product-ajax-pagination" data-postperpage="'.$post_per_page.'" data-functioncall="'.$function_call.'" data-outputdiv="'.$output_div.'"  data-shortcodeattrs="'.esc_js($shortcode_attrs).'" data-productpagination-nonce="'.wp_create_nonce('productpagination_nonce').'">';

				if($current_page > 1) {
					$output .= '<div class="prev-post"><a href="#" data-currentpage="'.$current_page.'"><span class="wdticon-angle-double-left"></span></a></div>';
				}

				$output .= paginate_links ( array (
							  'base' 		 => '#',
							  'format' 		 => '',
							  'current' 	 => $current_page,
							  'type'     	 => 'list',
							  'end_size'     => 2,
							  'mid_size'     => 3,
							  'prev_next'    => false,
							  'total' 		 => $max_num_pages
						  ) );

				if ($current_page < $max_num_pages) {
					$output .= '<div class="next-post"><a href="#" data-currentpage="'.$current_page.'"><span class="wdticon-angle-double-right"></span></a></div>';
				}

			$output .= '</div>';

	    }

	    return $output;

	}

}



// Summary Nav - Single page product navigation

if( ! function_exists( 'xoha_shop_single_product_nav' ) ) {
	function xoha_shop_single_product_nav() {

	    $next = get_next_post();
	    $prev = get_previous_post();

		$next_id = ( ! empty( $next ) ) ? $next->ID : '';
		$prev_id = ( ! empty( $prev ) ) ? $prev->ID : '';

	    $next = ( ! empty( $next ) ) ? wc_get_product( $next->ID ) : false;
		$prev = ( ! empty( $prev ) ) ? wc_get_product( $prev->ID ) : false;

		if ( ! empty( $next ) ) {
			$next_thumbnail_id = get_post_thumbnail_id($next_id);
			$next_image_src    = wp_get_attachment_image_src($next_thumbnail_id, 'woocommerce_thumbnail', false);
			$next_image_src    = isset($next_image_src[0]) ? $next_image_src[0] : wc_placeholder_img_src( 'woocommerce_thumbnail' );
		}

		if ( ! empty( $prev ) ) {
			$prev_thumbnail_id = get_post_thumbnail_id($prev_id);
			$prev_image_src    = wp_get_attachment_image_src($prev_thumbnail_id, 'woocommerce_thumbnail', false);
			$prev_image_src    = isset($prev_image_src[0]) ? $prev_image_src[0] : wc_placeholder_img_src( 'woocommerce_thumbnail' );
		}

	    $output = '';

		$output .= '<div class="wdt-single-product-nav">';

			if ( ! empty( $prev ) ) {

				$output .= '<div class="wdt-single-product-nav-btn product-nav-prev">';
					$output .= '<a href="'.esc_url( $prev->get_permalink() ).'">'.esc_html__('Previous product', 'xoha-pro').'<span class="product-nav-btn-icon"></span></a>';
					$output .= '<div class="wdt-single-product-nav-intro-wrapper">';
						$output .= '<div class="product-nav-intro">';
							$output .= '<div class="product-nav-intro-image">';
								$output .= '<a href="'.esc_url( $prev->get_permalink() ).'" class="product-thumb">';
									$output .= '<span class="prev-image" style="background-image:url('.esc_url($prev_image_src).')"></span>';
								$output .= '</a>';
							$output .= '</div>';
							$output .= '<div class="product-nav-intro-description">';
								$output .= '<a href="'.esc_url( $prev->get_permalink() ).'" class="product-title">';
									$output .= esc_html( $prev->get_title() );
								$output .= '</a>';
								$output .= '<span class="price">';
									$output .= $prev->get_price_html();
								$output .= '</span>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

			}

			$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
			$output .= '<a href="'.esc_url($shop_page_url).'" class="wdt-single-product-nav-back-btn"><span>'.esc_html__('Back to products', 'xoha-pro').'</span></a>';

			if ( ! empty( $next ) ) {

				$output .= '<div class="wdt-single-product-nav-btn product-nav-next">';
					$output .= '<a href="'.esc_url( $next->get_permalink() ).'">'.esc_html__('Next product', 'xoha-pro').'<span class="product-nav-btn-icon"></span></a>';
					$output .= '<div class="wdt-single-product-nav-intro-wrapper">';
						$output .= '<div class="product-nav-intro">';
							$output .= '<div class="product-nav-intro-image">';
								$output .= '<a href="'.esc_url( $next->get_permalink() ).'" class="product-thumb">';
									$output .= '<span class="next-image" style="background-image:url('.esc_url($next_image_src).')"></span>';
								$output .= '</a>';
							$output .= '</div>';
							$output .= '<div class="product-nav-intro-description">';
								$output .= '<a href="'.esc_url( $next->get_permalink() ).'" class="product-title">';
									$output .= esc_html( $next->get_title() );
								$output .= '</a>';
								$output .= '<span class="price">';
									$output .= $next->get_price_html();
								$output .= '</span>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

			}


		$output .= '</div>';

		return $output;

	}
}