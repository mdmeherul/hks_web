<?php

/**
 * WooCommerce - Single - Module - 360 Viewer
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Shop_Single_Module_360_Viewer' ) ) {

    class Xoha_Shop_Single_Module_360_Viewer {

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
                    return XOHA_MODULE_DIR . '/woocommerce/single/modules/360-viewer/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( xoha_is_file_in_theme( __FILE__ ) ) {
                    return XOHA_MODULE_URI . '/woocommerce/single/modules/360-viewer/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Load Modules
        */

            function load_modules() {

                // If Theme-Plugin is activated

                    if( function_exists( 'xoha_pro' ) ) {

                        // Metabox
                            include_once $this->module_dir_path() . 'metabox/index.php';

                        // Customizer
                            include_once $this->module_dir_path() . 'customizer/index.php';

                        // Elementor
                            include_once $this->module_dir_path() . 'elementor/index.php';

                    }

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

            }

    }

}

if( !function_exists('xoha_shop_single_module_360_viewer') ) {
	function xoha_shop_single_module_360_viewer() {
		return Xoha_Shop_Single_Module_360_Viewer::instance();
	}
}

xoha_shop_single_module_360_viewer();