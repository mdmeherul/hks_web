<?php

namespace XohaElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Xoha_Shop_Widget_Product_Cat_Single extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-cat-single';
	}

	public function get_title() {
		return esc_html__( 'Product Category - Single', 'xoha-pro' );
	}

	public function get_style_depends() {
		return array ( 'wdt-shop-product-cat-single' );
	}

	public function get_script_depends() {
		return array ();
	}

	protected function register_controls() {

		$this->start_controls_section( 'product_cat_single_section', array(
			'label' => esc_html__( 'General', 'xoha-pro' ),
		) );

			$this->add_control( 'cat_id', array(
				'label'   => esc_html__( 'Category Id', 'xoha-pro' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide category id to show.', 'xoha-pro' ),
				'default' => ''
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose type that you like yo use.', 'xoha-pro' ),
				'options'     => array(
					'type1' => esc_html__('Type 1', 'xoha-pro'),
					'type2' => esc_html__('Type 2', 'xoha-pro')
				),
				'default'     => 'type1',
			) );

			$this->add_control( 'image', array(
				'type'      => Controls_Manager::MEDIA,
				'label'     => esc_html__( 'Image', 'xoha-pro' ),
				'description' => esc_html__( 'Update if you like to use alternate image for this category.', 'xoha-pro' ),
			) );

			$this->add_control( 'show_starting_price', array(
				'label'       => esc_html__( 'Show Starting Price', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose true if you like to show starting price.', 'xoha-pro' ),
				'options'     => array(
					'false' => esc_html__('False', 'xoha-pro'),
					'true'  => esc_html__('True', 'xoha-pro'),
				),
				'condition'   => array( 'type' => 'type1' ),
				'default'     => 'false',
			) );

			$this->add_control( 'show_button', array(
				'label'       => esc_html__( 'Show Button', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose true if you like to show button.', 'xoha-pro' ),
				'options'     => array(
					'false' => esc_html__('False', 'xoha-pro'),
					'true'  => esc_html__('True', 'xoha-pro'),
				),
				'default'     => 'false',
	        ) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'xoha-pro' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'xoha-pro' ),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		$cat_args = array (
			'taxonomy'   => 'product_cat',
			'hide_empty' => 1
		);
		if($settings['cat_id'] != '') {
			$cat_args['include'] = $settings['cat_id'];
		}
		$categories = get_categories($cat_args);

		if( is_array($categories) && !empty($categories) ) {

			foreach( $categories as $category ) {

				$term_id = $category->term_id;

				if($settings['image']['url'] != '') {
					$cat_image = $settings['image']['url'];
				} else {
					$thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
					$image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
					$cat_image = $image_url[0];
				}

				$color_html = '';
				$xoha_shop_cat_color = get_term_meta($term_id, 'xoha_shop_cat_color', true);
				if($xoha_shop_cat_color != '') {
					$color_html .= '<div class="wdt-shop-category-listing-color" style="background-color:'.$xoha_shop_cat_color.';"></div>';
				}

				if($settings['type'] == 'type2') {

					$output .= '<div class="wdt-shop-category-listing-item '.$settings['type'].' '.$settings['class'].'">';
						$output .= '<div class="wdt-shop-category-listing-inner">';
							$output .= '<div class="wdt-shop-category-listing-image">';
								$output .= '<a href="'.get_term_link($category->term_id).'"><img src="'.esc_url($cat_image).'" alt="'.esc_html__('Category Image', 'xoha-pro').'" title="'.esc_html__('Category Image', 'xoha-pro').'" /></a>';
							$output .= '</div>';
							$output .= '<div class="wdt-shop-category-meta-data">';
								$output .= '<h3><a href="'.get_term_link($category->term_id).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="wdt-shop-category-total-items">('.sprintf( esc_html__('%1$s Items', 'xoha-pro'), '<span>'.$category->count.'</span>' ).')</div>';
								if($settings['show_button'] == 'true') {
									$output .= '<a href="'.get_term_link($category->term_id).'" class="wdt-shop-cat-button button">'.esc_html__('View Details', 'xoha-pro').'</a>';
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';

				} else {

					$output .= '<div class="wdt-shop-category-listing-item '.$settings['type'].' '.$settings['class'].'">';
						$output .= '<div class="wdt-shop-category-listing-inner">';
							$output .= '<div class="wdt-shop-category-listing-image">';
								$output .= '<a href="'.get_term_link($category->term_id).'"><img src="'.esc_url($cat_image).'" alt="'.esc_html__('Category Image', 'xoha-pro').'" title="'.esc_html__('Category Image', 'xoha-pro').'" /></a>';
								$output .= $color_html;
							$output .= '</div>';
							$output .= '<div class="wdt-shop-category-meta-data">';
								$output .= '<h3><a href="'.get_term_link($category->term_id).'">'.esc_html($category->cat_name).'</a></h3>';
								if($settings['show_starting_price'] == 'true') {

									$product_args = array (
										'posts_per_page' => -1,
										'post_type'      => 'product',
										'meta_query'     => array (),
										'tax_query'      => array (),
										'post_status'    => 'publish'
									);

									$product_args['tax_query'][] = array (
										'taxonomy' => 'product_cat',
										'field' => 'id',
										'terms' => $category,
										'operator' => 'IN'
									);

									$product_args['orderby']  = 'meta_value_num';
									$product_args['order']    = 'ASC';
									$product_args['meta_key'] = '_sale_price';
									$product_args['fields']   = 'ids';

									$product_ids = get_posts($product_args);
									$cat_product_id = $product_ids[0];

									$wc_product_object = wc_get_product( $cat_product_id );
									$woo_price_html = $wc_product_object->get_price_html();

									if($woo_price_html != '') {
										$output .= '<div class="wdt-shop-category-starting-price-html">'.sprintf(esc_html__('Starts from %1$s', 'xoha-pro'), $woo_price_html).'</div>';
									}

								}
								if($settings['show_button'] == 'true') {
									$output .= '<a href="'.get_term_link($category->term_id).'" class="wdt-shop-cat-button button">'.esc_html__('View Details', 'xoha-pro').'</a>';
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';

				}

			}

		}

		echo xoha_html_output($output);

	}

}