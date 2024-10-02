<?php

namespace XohaElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Xoha_Shop_Widget_Product_Search extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-search';
	}

	public function get_title() {
		return esc_html__( 'Product Search', 'xoha-pro' );
	}

	public function get_style_depends() {
		return array( 'wdt-shop-product-search' );
	}

	protected function register_controls() {


		$tpl_args = array (
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'tpl-product-search-listing.php',
			'suppress_filters' => 0
		);
		$product_search_tpl_posts = get_posts($tpl_args);

		$product_search_tpls = array ();
		if(is_array($product_search_tpl_posts) && !empty($product_search_tpl_posts)) {
			foreach($product_search_tpl_posts as $product_search_tpl_post) {
				$product_search_tpls[$product_search_tpl_post->ID] = $product_search_tpl_post->post_title;
			}
		}

		$this->start_controls_section( 'product_search_section', array(
			'label' => esc_html__( 'General', 'xoha-pro' ),
		) );

			$this->add_control( 'show_categories', array(
				'label'       => esc_html__( 'Show Categories', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Show categories dropdown to search.', 'xoha-pro' ),
				'options'     => array(
					'false' => esc_html__('False', 'xoha-pro'),
					'true' => esc_html__('True', 'xoha-pro')
				),
				'default'     => 'true',
			) );

			$this->add_control( 'textfield_label', array(
				'label'       => esc_html__( 'Textfield Label', 'xoha-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can change textfield label here.', 'xoha-pro' ),
				'default'     => ''
			) );

			$this->add_control( 'search_template', array(
				'label'       => esc_html__( 'Search Template', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose product search result template that you would like to use. If you haven\'t created any create page by choosing "Product Search Result Template".', 'xoha-pro' ),
				'options'     => $product_search_tpls
			) );

			$this->add_control( 'class', array(
				'label'       => esc_html__( 'Class', 'xoha-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'xoha-pro' ),
				'default'     => ''
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		$output .= '<div class="wdt-shop-product-search-container">';

			$output .= '<form class="wdtShopSearchForm" action="'.get_permalink($settings['search_template']).'" method="post">';

				if(isset($settings['show_categories']) && $settings['show_categories'] == 'true') {

					$xoha_shop_search_categories = array ();
					if(isset($_REQUEST['xoha_shop_search_categories'])) {
						if(is_array($_REQUEST['xoha_shop_search_categories']) && !empty($_REQUEST['xoha_shop_search_categories'])) {
							$xoha_shop_search_categories = $_REQUEST['xoha_shop_search_categories'];
						} else if($_REQUEST['xoha_shop_search_categories'] != '') {
							$xoha_shop_search_categories = explode(',', $_REQUEST['xoha_shop_search_categories']);
						}
					}

					$mulitple_attr = '';
					$mulitple_name = 'xoha_shop_search_categories';
					if(isset($settings['categories_multiple_dropdown']) && $settings['categories_multiple_dropdown'] == 'true') {
						$mulitple_attr = 'multiple';
						$mulitple_name = 'xoha_shop_search_categories[]';
					}

					$output .= '<div class="wdt-shop-product-search-item">';

						$cat_args = array (
							'taxonomy'   => 'product_cat',
							'hide_empty' => 1
						);
						$categories = get_categories($cat_args);

						if( is_array($categories) && !empty($categories) ) {

							$output .= '<select class="wdt-shop-search-field wdt-shop-search-categories-field wdt-shop-chosen-select" name="'.$mulitple_name.'" data-placeholder="'.esc_html__('Choose Categories', 'xoha-pro').'" '.esc_attr($mulitple_attr).'>';

								if($mulitple_attr == '') {
									$output .= '<option value="">'.esc_html__('Choose Categories', 'xoha-pro').'</option>';
								}

								foreach( $categories as $category ) {

									$selected_attr = '';
									if(in_array($category->term_id, $xoha_shop_search_categories)) {
										$selected_attr = 'selected="selected"';
									}
									$output .= '<option value="'.esc_attr($category->term_id).'" '.$selected_attr.'>'.esc_html($category->name).'</option>';

								}

							$output .= '</select>';

						}

					$output .= '</div>';

				}

				$output .= '<div class="wdt-shop-product-search-item-holder">';

					$output .= '<div class="wdt-shop-product-search-item">';

						$textfield_label = esc_html__('Keyword', 'xoha-pro');
						if($settings['textfield_label'] != '') {
							$textfield_label = esc_html($settings['textfield_label']);
						}

						$xoha_shop_search_keyword = '';
						if(isset($_REQUEST['xoha_shop_search_keyword']) && $_REQUEST['xoha_shop_search_keyword'] != '') {
							$xoha_shop_search_keyword = $_REQUEST['xoha_shop_search_keyword'];
						}

						$output .= '<input name="xoha_shop_search_keyword" class="wdt-shop-search-field wdt-shop-search-keyword-field" type="text" value="'.esc_attr($xoha_shop_search_keyword).'" placeholder="'.esc_attr($textfield_label).'" />';

					$output .= '</div>';

					$output .= '<div class="wdt-shop-product-search-item">';

						$output .= '<input name="xoha_shop_search_submit" class="wdt-shop-search-field wdt-shop-search-submit-field" type="submit" value="'.esc_html__('Submit', 'xoha-pro').'" />';

						$output .= '<input type="hidden" name="xoha_shop_product_search_nonce" value="'.wp_create_nonce('xoha_shop_product_search').'" />';

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</form>';

		$output .= '</div>';

		echo xoha_html_output($output);

	}

}