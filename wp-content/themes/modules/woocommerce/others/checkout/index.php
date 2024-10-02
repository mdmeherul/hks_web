<?php

/**
 * WooCommerce - Checkout Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Shop_Others_Checkout' ) ) {

    class Xoha_Shop_Others_Checkout {

        private static $_instance = null;

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
        Module Paths
        */

            function module_dir_path() {

                if( xoha_is_file_in_theme( __FILE__ ) ) {
                    return XOHA_MODULE_DIR . '/woocommerce/others/checkout/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( xoha_is_file_in_theme( __FILE__ ) ) {
                    return XOHA_MODULE_URI . '/woocommerce/others/checkout/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                // Includes
                include_once $this->module_dir_path(). 'includes/index.php';

            }

    }

}

if( !function_exists('xoha_shop_others_checkout') ) {
	function xoha_shop_others_checkout() {
        $reflection = new ReflectionClass('Xoha_Shop_Others_Checkout');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Xoha_Shop_Others_Checkout::instance();