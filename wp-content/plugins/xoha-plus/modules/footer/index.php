<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusFooter' ) ) {
    class XohaPlusFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_footer_layouts();
            $this->load_modules();
        }

        function load_footer_layouts() {
            foreach( glob( XOHA_PLUS_DIR_PATH. 'modules/footer/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once XOHA_PLUS_DIR_PATH.'modules/footer/customizer/index.php';
            include_once XOHA_PLUS_DIR_PATH.'modules/footer/elementor/index.php';
        }
    }
}

XohaPlusFooter::instance();