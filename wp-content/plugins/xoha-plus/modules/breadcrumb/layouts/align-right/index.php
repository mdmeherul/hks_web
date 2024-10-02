<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusBreadcrumbAlignRight' ) ) {
    class XohaPlusBreadcrumbAlignRight {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'xoha_plus_breadcrumb_layouts', array( $this, 'add_option' ) );
        }

        function add_option( $options ) {
            $options['alignright'] = esc_html__('Align Right', 'xoha-plus');
            return $options;
        }
    }
}

XohaPlusBreadcrumbAlignRight::instance();