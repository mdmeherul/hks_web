<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusSkin' ) ) {
    class XohaPlusSkin {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
        }

        function load_modules() {
            include_once XOHA_PLUS_DIR_PATH.'modules/skin/customizer/index.php';
        }

    }
}

XohaPlusSkin::instance();