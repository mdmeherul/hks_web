<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Woo_Listing_Option_Thumb_Content' ) ) {

    class Xoha_Woo_Listing_Option_Thumb_Content extends Xoha_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            $this->option_slug          = 'product-thumb-content';
            $this->option_name          = esc_html__('Thumb Content', 'xoha');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();

        }

        /*
        Backend Render
        */

            function render_backend() {
                add_filter( 'xoha_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 10, 1 );
            }

        /*
        Custom Product Templates - Options
        */
            function woo_custom_product_template_thumb_options( $template_options ) {

                array_push( $template_options, $this->setting_args() );

                return $template_options;

            }

        /*
        Setting Group
        */
            function setting_group() {

                return 'thumb';

            }

        /*
        Setting Arguments
        */
            function setting_args() {

                $settings                =  array ();

                $settings['id']          =  $this->option_slug;
                $settings['type']        =  'sorter';
                $settings['title']       =  $this->option_name;
                $settings['default']     =  array (
                    'enabled'            => array(
                        'title'          => esc_html__('Title', 'xoha'),
                        'category'       => esc_html__('Category', 'xoha'),
                        'price'          => esc_html__('Price', 'xoha'),
                        'button_element' => esc_html__('Button Element', 'xoha'),
                        'icons_group'    => esc_html__('Icons Group', 'xoha'),
                    ),
                    'disabled'         => array(
                        'excerpt'        => esc_html__('Excerpt', 'xoha'),
                        'rating'         => esc_html__('Rating', 'xoha'),
                        'countdown'      => esc_html__('Count Down', 'xoha'),
                        'separator'      => esc_html__('Separator', 'xoha'),
                        'element_group'  => esc_html__('Element Group', 'xoha'),
                        'swatches'       => esc_html__('Swatches', 'xoha'),
                    ),
                );

                return $settings;

            }

    }

}

if( !function_exists('xoha_woo_listing_option_thumb_content') ) {
	function xoha_woo_listing_option_thumb_content() {
		return Xoha_Woo_Listing_Option_Thumb_Content::instance();
	}
}

xoha_woo_listing_option_thumb_content();