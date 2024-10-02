<?php

// Single Page - Media Images
if(!function_exists('wdt_sp_media_images')) {
	function wdt_sp_media_images( $attrs, $content = null ) {
		$attrs = shortcode_atts ( array (
			'listing_id'                    => '',
			'image_size'                    => 'full',
			'show_image_description'        => 'false',
			'include_featured_image'        => 'false',
			'class'                         => '',

			'carousel_effect'               => '',
			'carousel_autoplay'             => '',
			'carousel_slidesperview'        => 1,
			'carousel_loopmode'             => '',
			'carousel_mousewheelcontrol'    => '',
			'carousel_verticaldirection'    => '',
			'carousel_paginationtype'       => '',
			'carousel_numberofthumbnails'   => 3,
			'carousel_arrowpagination'      => '',
			'carousel_arrowpagination_type' => 'type1',
			'carousel_spacebetween' => ''
		), $attrs, 'wdt_sp_media_images' );

		$output = '';
		if($attrs['listing_id'] == '' && is_singular('wdt_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {
			$wdt_media_images_ids    = get_post_meta($attrs['listing_id'], 'wdt_media_images_ids', true);
			$wdt_media_images_ids 	  = (is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) ? $wdt_media_images_ids : array ();
			$wdt_media_images_titles = get_post_meta($attrs['listing_id'], 'wdt_media_images_titles', true);
			$wdt_media_images_titles = (is_array($wdt_media_images_titles) && !empty($wdt_media_images_titles)) ? $wdt_media_images_titles : array ();
			$wdt_featured_image_id   = get_post_thumbnail_id($attrs['listing_id']);
			$wdt_featured_image_id   = ($wdt_featured_image_id != '') ? $wdt_featured_image_id : -1;
			$uniqid = uniqid();

			$add_class = '';
			if($attrs['carousel_verticaldirection'] == 'true') {
				$add_class = 'wdt-listings-vertical-thumb';
			}

			$media_carousel_attributes = array ();
			array_push($media_carousel_attributes, 'data-enablecarousel="true"');
			array_push($media_carousel_attributes, 'data-carouseleffect="'.esc_attr( $attrs['carousel_effect'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselautoplay="'.esc_attr( $attrs['carousel_autoplay'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperview="'.esc_attr( $attrs['carousel_slidesperview'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselloopmode="'.esc_attr( $attrs['carousel_loopmode'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselmousewheelcontrol="'.esc_attr( $attrs['carousel_mousewheelcontrol'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselverticaldirection="'.esc_attr( $attrs['carousel_verticaldirection'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselpaginationtype="'.esc_attr( $attrs['carousel_paginationtype'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselnumberofthumbnails="'.esc_attr( $attrs['carousel_numberofthumbnails'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselarrowpagination="'.esc_attr( $attrs['carousel_arrowpagination'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselspacebetween="'.esc_attr( $attrs['carousel_spacebetween'] ).'"');
			array_push($media_carousel_attributes, 'data-carouselnoofimages="'.esc_attr( count($wdt_media_images_ids) ).'"');

			if(!empty($media_carousel_attributes)) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$output .= '<div class="wdt-listings-image-gallery-holder '.esc_attr( $attrs['class'] ).' '.esc_attr( $add_class ).'">';

				// Gallery Images
				$output .= '<div class="wdt-listings-image-gallery-container swiper-container" '.$media_carousel_attributes_string.'>';
					$output .= '<div class="wdt-listings-image-gallery swiper-wrapper">';

									if($attrs['include_featured_image'] == 'true') {
										$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
										if($featured_image_id > 0) {
											$image_details = wp_get_attachment_image_src($featured_image_id, $attrs['image_size']);
											$output .= '<div class="swiper-slide" data-hash="slide-'.esc_attr( $uniqid.$uniqid ).'"><img src="'.esc_url($image_details[0]).'" title="'.esc_attr__('Featured Image','wdt-portfolio').'" alt="'.esc_attr__('Featured Image','wdt-portfolio').'" /></div>';
										}
									}

									if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
										$i = 0;
										foreach($wdt_media_images_ids as $wdt_media_images_id) {
											if($wdt_media_images_id != $wdt_featured_image_id) {
												$wdt_media_title = '';
												if(isset($wdt_media_images_titles[$i])) {
													$wdt_media_title = $wdt_media_images_titles[$i];
												}
												$image_details = wp_get_attachment_image_src($wdt_media_images_id, 'full');
												$output .= '<div class="swiper-slide" data-hash="slide-'.esc_attr( $uniqid.$i ).'"><img src="'.esc_url($image_details[0]).'" alt="'.esc_attr__('Gallery Image','wdt-portfolio').'" />';
													if($attrs['show_image_description'] == 'true') {
														$output .= '<div class="wdt-listings-image-gallery-title">'.esc_html( $wdt_media_title ).'</div>';
													}
												$output .= '</div>';
												$i++;
											}
										}
									}

					$output .= '</div>';

					if($attrs['carousel_paginationtype'] != '' || $attrs['carousel_arrowpagination'] == 'true') {

						$output .= '<div class="wdt-listings-swiper-pagination-holder">';

							if($attrs['carousel_paginationtype'] == 'bullets') {
								$output .= '<div class="wdt-swiper-bullet-pagination"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'progressbar') {
								$output .= '<div class="wdt-swiper-progress-pagination"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'scrollbar') {
								$output .= '<div class="wdt-swiper-scrollbar"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'fraction') {
								$output .= '<div class="wdt-swiper-fraction-pagination"></div>';
							}

							if($attrs['carousel_arrowpagination'] == 'true') {
								$output .= '<div class="wdt-swiper-arrow-pagination '.esc_attr( $attrs['carousel_arrowpagination_type'] ).'">';
									$output .= '<a href="#" class="wdt-swiper-arrow-prev">'.esc_html__('Prev','wdt-portfolio').'</a>';
									$output .= '<a href="#" class="wdt-swiper-arrow-next">'.esc_html__('Next','wdt-portfolio').'</a>';
								$output .= '</div>';
							}

						$output .= '</div>';

					}

				$output .= '</div>';

				if($attrs['carousel_paginationtype'] == 'thumbnail') {

					// Gallery Thumb
					$output .= '<div class="wdt-listings-image-gallery-thumb-container swiper-container">';
						$output .= '<div class="wdt-listings-image-gallery-thumb swiper-wrapper">';

										if($attrs['include_featured_image'] == 'true') {
											$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
											$image_details = wp_get_attachment_image_src($featured_image_id, $attrs['image_size']);

											$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" title="'.esc_attr__('Gallery Thumb','wdt-portfolio').'" alt="'.esc_attr__('Gallery Thumb','wdt-portfolio').'" /></div>';
										}

										if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
											$i = 0;
											foreach($wdt_media_images_ids as $wdt_media_attachments_id) {
												if(($wdt_media_attachments_id != $wdt_featured_image_id) || ($attrs['include_featured_image'] && $wdt_media_attachments_id == $wdt_featured_image_id)) {
													$wdt_media_title = '';
													if(isset($wdt_media_images_titles[$i])) {
														$wdt_media_title = $wdt_media_images_titles[$i];
													}
													$image_details = wp_get_attachment_image_src($wdt_media_attachments_id, $attrs['image_size']);
													$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" alt="'.esc_attr__('Gallery Thumb','wdt-portfolio').'" /></div>';
													$i++;
												}
											}
										}

						$output .= '</div>';
					$output .= '</div>';

				}

			$output .= '</div>';

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','wdt-portfolio'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'wdt_sp_media_images', 'wdt_sp_media_images' );
}

// Single Page - Media Images List
if(!function_exists('wdt_sp_media_images_list')) {
	function wdt_sp_media_images_list( $attrs, $content = null ) {
		$attrs = shortcode_atts ( array (
			'listing_id'             => '',
			'columns'                => 4,
			'image_size'             => 'full',
			'show_image_description' => 'false',
			'with_space'             => 'false',
			'include_featured_image' => 'false',
			'image_ids'              => '',
			'class'                  => ''
		), $attrs, 'wdt_sp_media_images_list' );

		$output = '';
		if($attrs['listing_id'] == '' && is_singular('wdt_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

            if($attrs['columns'] == 6) {
                $column_class = array ( 'wdt-column', 'wdt-one-sixth' );
            } else if($attrs['columns'] == 5) {
                $column_class = array ( 'wdt-column', 'wdt-one-fifth' );
            } else if($attrs['columns'] == 4) {
                $column_class = array ( 'wdt-column', 'wdt-one-fourth' );
            } else if($attrs['columns'] == 3) {
                $column_class = array ( 'wdt-column', 'wdt-one-third' );
            } else if($attrs['columns'] == 2) {
                $column_class = array ( 'wdt-column', 'wdt-one-half' );
            } else {
                $column_class = array ( 'wdt-column', 'wdt-one-column' );
            }


			$wdt_media_images_ids    = get_post_meta($attrs['listing_id'], 'wdt_media_images_ids', true);
			$wdt_media_images_ids 	 = (is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) ? $wdt_media_images_ids : array ();
			$wdt_media_images_titles = get_post_meta($attrs['listing_id'], 'wdt_media_images_titles', true);
			$wdt_media_images_titles = (is_array($wdt_media_images_titles) && !empty($wdt_media_images_titles)) ? $wdt_media_images_titles : array ();
			$wdt_featured_image_id   = get_post_thumbnail_id($attrs['listing_id']);
			$wdt_featured_image_id   = ($wdt_featured_image_id != '') ? $wdt_featured_image_id : -1;
			$uniqid = uniqid();

            $add_class = '';
            if($attrs['with_space'] == 'true') {
                $add_class = 'with-space';
            }

            $image_ids = false;
            if(isset($attrs['image_ids']) && !empty($attrs['image_ids'])) {
                $image_ids = explode(',', $attrs['image_ids']);
            }

			$output .= '<div class="wdt-listings-image-gallery-list-holder '.esc_attr( $attrs['class'] ).' '.$add_class.'">';

				// Gallery Images
				$output .= '<div class="wdt-listings-image-gallery-list-container">';
					$output .= '<div class="wdt-listings-image-gallery-list">';

                        $i = 0;
                        if($attrs['include_featured_image'] == 'true') {
                            $featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
                            if($featured_image_id > 0) {
                                $image_details = wp_get_attachment_image_src($featured_image_id, $attrs['image_size']);
                                $output .= '<div class="wdt-listings-image-gallery-item '.implode(' ', $column_class).' first"><img src="'.esc_url($image_details[0]).'" title="'.esc_attr__('Featured Image','wdt-portfolio').'" alt="'.esc_attr__('Featured Image','wdt-portfolio').'" /></div>';
                                $i++;
                            }
                        }

                        if(is_array($image_ids) && !empty($image_ids)) {
                            foreach($image_ids as $image_id) {
                                $wdt_media_images_id = $wdt_media_images_ids[$image_id];
                                if($wdt_media_images_id != $wdt_featured_image_id) {
                                    $first_class = (($i%$attrs['columns']) == 0) ? 'first' : '';
                                    $wdt_media_title = '';
                                    if(isset($wdt_media_images_titles[$i])) {
                                        $wdt_media_title = $wdt_media_images_titles[$i];
                                    }
                                    $image_details = wp_get_attachment_image_src($wdt_media_images_id, 'full');
                                    $output .= '<div class="wdt-listings-image-gallery-item '.implode(' ', $column_class).' '.$first_class.'"><img src="'.esc_url($image_details[0]).'" alt="'.esc_attr__('Gallery Image','wdt-portfolio').'" />';
                                        if($attrs['show_image_description'] == 'true') {
                                            $output .= '<div class="wdt-listings-image-gallery-title">'.esc_html( $wdt_media_title ).'</div>';
                                        }
                                    $output .= '</div>';
                                    $i++;
                                }
                            }
                        } else if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
                            foreach($wdt_media_images_ids as $wdt_media_images_id) {
                                if($wdt_media_images_id != $wdt_featured_image_id) {
                                    $first_class = (($i%$attrs['columns']) == 0) ? 'first' : '';
                                    $wdt_media_title = '';
                                    if(isset($wdt_media_images_titles[$i])) {
                                        $wdt_media_title = $wdt_media_images_titles[$i];
                                    }
                                    $image_details = wp_get_attachment_image_src($wdt_media_images_id, 'full');
                                    $output .= '<div class="wdt-listings-image-gallery-item '.implode(' ', $column_class).' '.$first_class.'"><img src="'.esc_url($image_details[0]).'" alt="'.esc_attr__('Gallery Image','wdt-portfolio').'" />';
                                        if($attrs['show_image_description'] == 'true') {
                                            $output .= '<div class="wdt-listings-image-gallery-title">'.esc_html( $wdt_media_title ).'</div>';
                                        }
                                    $output .= '</div>';
                                    $i++;
                                }
                            }
                        }

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','wdt-portfolio'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'wdt_sp_media_images_list', 'wdt_sp_media_images_list' );
}

?>