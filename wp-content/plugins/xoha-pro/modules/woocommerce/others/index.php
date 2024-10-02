<?php

/**
 * WooCommerce - Others Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Pro_Others' ) ) {

    class Xoha_Pro_Others {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

        }

        /*
        Load Modules
        */
        function load_modules() {

            // Customizer
                include_once XOHA_PRO_DIR_PATH . 'modules/woocommerce/others/customizer/index.php';

        }

    }

}

if( !function_exists('xoha_others') ) {
	function xoha_others() {
		return Xoha_Pro_Others::instance();
	}
}

xoha_others();