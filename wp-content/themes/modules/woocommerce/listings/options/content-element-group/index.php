<?php

/**
 * Listing Options - Element Group Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Woo_Listing_Option_Content_Element_Group' ) ) {

    class Xoha_Woo_Listing_Option_Content_Element_Group extends Xoha_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-content-element-group';
            $this->option_name          = esc_html__('Element Group Content', 'xoha');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {

            /* Custom Product Templates - Options */
            add_filter( 'xoha_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 50, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_content_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'content';
        }

        /**
         * Setting Arguments
         */
        function setting_args() {

            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'sorter';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  array (
                'enabled' => array(
                    'title' => esc_html__('Title', 'xoha'),
                    'price' => esc_html__('Price', 'xoha'),
                ),
                'disabled'         => array(
                    'cart'           => esc_html__('Cart', 'xoha'),
                    'wishlist'       => esc_html__('Wishlist', 'xoha'),
                    'compare'        => esc_html__('Compare', 'xoha'),
                    'quickview'      => esc_html__('Quick View', 'xoha'),
                    'category'       => esc_html__('Category', 'xoha'),
                    'button_element' => esc_html__('Button Element', 'xoha'),
                    'icons_group'    => esc_html__('Icons Group', 'xoha'),
                    'excerpt'        => esc_html__('Excerpt', 'xoha'),
                    'rating'         => esc_html__('Rating', 'xoha'),
                    'separator'      => esc_html__('Separator', 'xoha'),
                    'swatches'       => esc_html__('Swatches', 'xoha')
                ),
            );
            $settings['enabled_title']  =  esc_html__('Active Elements', 'xoha');
            $settings['disabled_title'] =  esc_html__('Deatcive Elements', 'xoha');

            return $settings;
        }
    }

}

if( !function_exists('xoha_woo_listing_option_content_element_group') ) {
	function xoha_woo_listing_option_content_element_group() {
		return Xoha_Woo_Listing_Option_Content_Element_Group::instance();
	}
}

xoha_woo_listing_option_content_element_group();