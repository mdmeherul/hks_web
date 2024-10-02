<?php
namespace XohaElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Xoha_Shop_Widget_Related_Products extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-related-products';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Related Products', 'xoha-pro' );
	}

	public function get_style_depends() {
		return array( 'wdt-shop-product-single-related-products' );
	}

	public function product_style_templates() {

		$shop_product_templates['admin'] = esc_html__('Admin Option', 'xoha-pro');
		$shop_product_templates = array_merge ( $shop_product_templates, xoha_woo_listing_customizer_settings()->product_templates_list() );

		return $shop_product_templates;

	}

	protected function register_controls() {

		$this->start_controls_section( 'product_featured_image_section', array(
			'label' => esc_html__( 'General', 'xoha-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'xoha-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product summary items. No need to provide ID if it is used in Product single page.', 'xoha-pro'),
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose column that you like to display upsell products.', 'xoha-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 4,
	        ) );

			$this->add_control( 'limit', array(
				'label'       => esc_html__( 'Limit', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'xoha-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10 ),
				'default'     => 4,
	        ) );

			$this->add_control( 'product_style_template', array(
				'label'       => esc_html__( 'Product Style Template', 'xoha-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'xoha-pro' ),
				'options'     => $this->product_style_templates(),
				'default'     => 'admin',
	        ) );

			$this->add_control( 'hide_title', array(
				'label'        => esc_html__( 'Hide Title', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish to hide title you can do it here', 'xoha-pro'),
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

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		if($settings['product_id'] != '') {

			$output .= '<div class="wdt-product-related-products '.$settings['class'].'">';

				if($settings['product_style_template'] == 'admin') {
					$product_style_template = xoha_customizer_settings( 'wdt-single-product-related-style-template' );
				} else {
					$product_style_template = $settings['product_style_template'];
				}

                $settings['product_related_style_template']        = 'custom';
                $settings['product_related_style_custom_template'] = $product_style_template;


				xoha_shop_single_module_upsell_related()->woo_load_listing( $settings['product_related_style_template'], $settings['product_related_style_custom_template'] );

				wc_set_loop_prop('product_related_hide_title', $settings['hide_title']);
				wc_set_loop_prop('columns', $settings['columns']);

				ob_start();
				woocommerce_related_products( array ( 'posts_per_page' => $settings['limit'], 'columns' => $settings['columns'], 'orderby' => 'rand' ) );
				$output .= ob_get_clean();

				xoha_shop_product_style_reset_loop_prop(); /* Reset Product Style Loop Prop */

			$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'xoha-pro');

		}

		echo $output;

	}

}