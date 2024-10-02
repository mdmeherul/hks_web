<?php
namespace XohaElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Xoha_Shop_Widget_Product_Images_Carousel extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-single-images-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Images Carousel', 'xoha-pro' );
	}

	public function get_style_depends() {
		return array( 'jquery-swiper', 'wdt-shop-products-carousel', 'wdt-shop-product-single-images-carousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'wdt-shop-product-single-images-carousel' );
	}

	protected function register_controls() {

		$this->product_section();
		$this->carousel_section();
	}

	public function product_section() {

		$this->start_controls_section( 'product_images_carousel_section', array(
			'label' => esc_html__( 'General', 'xoha-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'xoha-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product iamges carousel. No need to provide ID if it is used in Product single page.', 'xoha-pro'),
			) );

			$this->add_control( 'include_featured_image', array(
				'label'        => esc_html__( 'Include Feature Image', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can include featured image in this gallery.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'include_product_labels', array(
				'label'        => esc_html__( 'Include Product Labels', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can include product labels in this gallery.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'enable_thumb_enlarger', array(
				'label'        => esc_html__( 'Enable Thumb Enlarger', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable thumbnail enlarger in this gallery.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'xoha-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();
	}

	public function carousel_section() {

		$this->start_controls_section( 'product_carousel_section', array(
			'label' => esc_html__( 'Carousel Settings', 'xoha-pro' ),
		) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'xoha-pro' ),
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Default', 'xoha-pro' ),
					'fade' => esc_html__( 'Fade', 'xoha-pro' ),
	            ),
	        ) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'xoha-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 1,
	        ) );

			$this->add_control( 'carousel_loopmode', array(
				'label'        => esc_html__( 'Enable Loop Mode', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'        => esc_html__( 'Enable Mousewheel Control', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_verticaldirection', array(
				'label'        => esc_html__( 'Enable Vertical Direction', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To make your slides to navigate vertically.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'        => esc_html__( 'Enable Bullet Pagination', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable bullet pagination.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_thumbnailpagination', array(
				'label'        => esc_html__( 'Enable Thumbnail Pagination', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable thumbnail pagination.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_thumbnail_position', array(
				'label'       => esc_html__( 'Thumbnail Position', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'xoha-pro' ),
				'options'     => array(
					''      => esc_html__('Bottom', 'xoha-pro'),
					'left'  => esc_html__('Left', 'xoha-pro'),
					'right' => esc_html__('Right', 'xoha-pro'),
				),
				'condition'   => array( 'carousel_thumbnailpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_slidesperview_thumbnail', array(
				'label'       => esc_html__( 'Number Of Images - Thumbnail', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number of images to show in thumbnails.', 'xoha-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6 ),
				'condition'   => array( 'carousel_thumbnailpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'        => esc_html__( 'Enable Arrow Pagination', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable arrow pagination.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => esc_html__( 'Arrow Type', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'xoha-pro' ),
				'options'     => array(
					''      => esc_html__('Default', 'xoha-pro'),
					'type2' => esc_html__('Type 2', 'xoha-pro'),
				),
				'condition'   => array( 'carousel_arrowpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_scrollbar', array(
				'label'        => esc_html__( 'Enable Scrollbar', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable scrollbar for your carousel.', 'xoha-pro'),
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'       => esc_html__( 'Space Between Sliders', 'xoha-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Space between sliders can be given here.', 'xoha-pro'),
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if($settings['product_id'] != '') {

			$media_carousel_attributes = array ();

			array_push($media_carousel_attributes, 'data-carouseleffect="'.$settings['carousel_effect'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperview="'.$settings['carousel_slidesperview'].'"');
			array_push($media_carousel_attributes, 'data-carouselloopmode="'.$settings['carousel_loopmode'].'"');
			array_push($media_carousel_attributes, 'data-carouselmousewheelcontrol="'.$settings['carousel_mousewheelcontrol'].'"');
			array_push($media_carousel_attributes, 'data-carouselverticaldirection="'.$settings['carousel_verticaldirection'].'"');
			array_push($media_carousel_attributes, 'data-carouselbulletpagination="'.$settings['carousel_bulletpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselthumbnailpagination="'.$settings['carousel_thumbnailpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselthumbnailposition="'.$settings['carousel_thumbnail_position'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperviewthumbnail="'.$settings['carousel_slidesperview_thumbnail'].'"');
			array_push($media_carousel_attributes, 'data-carouselarrowpagination="'.$settings['carousel_arrowpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselscrollbar="'.$settings['carousel_scrollbar'].'"');
			array_push($media_carousel_attributes, 'data-carouselspacebetween="'.$settings['carousel_spacebetween'].'"');

			if(!empty($media_carousel_attributes)) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$product = wc_get_product( $settings['product_id'] );

			$gallery_holder_class = '';
			if($settings['carousel_thumbnailpagination'] == 'true' && ($settings['carousel_thumbnail_position'] == 'left' || $settings['carousel_thumbnail_position'] == 'right')) {
				$gallery_holder_class = 'wdt-product-vertical-thumb';
			}
			$gallery_holder_thumb_class = '';
			if($settings['carousel_thumbnail_position'] == 'left' || $settings['carousel_thumbnail_position'] == 'right') {
				$gallery_holder_thumb_class = 'wdt-product-vertical-thumb-'.$settings['carousel_thumbnail_position'];
			}

			$output .= '<div class="wdt-product-image-gallery-holder '.$settings['class'].' '.$gallery_holder_class.' '.$gallery_holder_thumb_class.'">';

				// Gallery Images
				$output .= '<div class="wdt-product-image-gallery-container swiper-container" '.$media_carousel_attributes_string.'>';

			    	if($settings['enable_thumb_enlarger'] == 'true') {
						$output .= '<div class="wdt-product-image-gallery-thumb-enlarger"></div>';
					}

			    	if($settings['include_product_labels'] == 'true') {

						ob_start();
						xoha_shop_woo_show_product_additional_labels($product);
						$product_sale_flash = ob_get_clean();

						$output .= $product_sale_flash;

					}

				    $output .= '<div class="wdt-product-image-gallery swiper-wrapper">';

	    				if($settings['include_featured_image'] == 'true') {

							$output .= '<div class="wdt-product-image swiper-slide">';

								$attachment_id = $product->get_image_id();

								$image_size               = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
								$full_size                = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
								$full_src                 = wp_get_attachment_image_src( $attachment_id, $full_size );
								$image                    = wp_get_attachment_image( $attachment_id, $image_size, false, array(
									'title'                   => get_post_field( 'post_title', $attachment_id ),
									'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
									'data-src'                => $full_src[0],
									'data-large_image'        => $full_src[0],
									'data-large_image_width'  => $full_src[1],
									'data-large_image_height' => $full_src[2],
									'class'                   => 'wp-post-image',
								) );

								$output .= $image;

							$output .= '</div>';

						}

						$attachment_ids = $product->get_gallery_image_ids();

	                    if(is_array($attachment_ids) && !empty($attachment_ids)) {
	                        $i = 0;
	                        foreach($attachment_ids as $attachment_id) {

                               	$output .= '<div class="wdt-product-image swiper-slide">';

									$image_size               = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
									$full_size                = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
									$full_src                 = wp_get_attachment_image_src( $attachment_id, $full_size );
									$image                    = wp_get_attachment_image( $attachment_id, $image_size, false, array(
										'title'                   => get_post_field( 'post_title', $attachment_id ),
										'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
										'data-src'                => $full_src[0],
										'data-large_image'        => $full_src[0],
										'data-large_image_width'  => $full_src[1],
										'data-large_image_height' => $full_src[2],
										'class'                   => '',
									) );

									$output .= $image;

                               	$output .= '</div>';

                                $i++;

	                        }
	                    }

		    		$output .= '</div>';

					$output .= '<div class="wdt-product-image-gallery-pagination-holder">';

						if($settings['carousel_bulletpagination'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-bullet-pagination"></div>';
						}

						if($settings['carousel_scrollbar'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-scrollbar"></div>';
						}

						if($settings['carousel_arrowpagination'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-arrow-pagination '.$settings['carousel_arrowpagination_type'].'">';
								$output .= '<a href="#" class="wdt-product-image-gallery-arrow-prev">'.esc_html__('Prev', 'xoha-pro').'</a>';
								$output .= '<a href="#" class="wdt-product-image-gallery-arrow-next">'.esc_html__('Next', 'xoha-pro').'</a>';
							$output .= '</div>';
						}

					$output .= '</div>';
		   		$output .= '</div>';

		   		if($settings['carousel_thumbnailpagination'] == 'true') {

			   		// Gallery Thumb
					$output .= '<div class="wdt-product-image-gallery-thumb-container swiper-container">';
					    $output .= '<div class="wdt-product-image-gallery-thumb swiper-wrapper">';

		    				if($settings['include_featured_image'] == 'true') {
								$featured_image_id = get_post_thumbnail_id($settings['product_id']);
								$image_details = wp_get_attachment_image_src($featured_image_id, 'woocommerce_single');

								$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" title="'.esc_html__('Gallery Thumb', 'xoha-pro').'" alt="'.esc_html__('Gallery Thumb', 'xoha-pro').'" /></div>';
							}

		                    if(is_array($attachment_ids) && !empty($attachment_ids)) {
		                        $i = 0;
		                        foreach($attachment_ids as $attachment_id) {
	                                $image_details = wp_get_attachment_image_src($attachment_id, 'woocommerce_single');
	                               	$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" alt="'.esc_html__('Gallery Thumb', 'xoha-pro').'" /></div>';
	                                $i++;
		                        }
		                    }

			    		$output .= '</div>';
			    	$output .= '</div>';

			    }

		   	$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'xoha-pro');

		}

		echo $output;

	}

}