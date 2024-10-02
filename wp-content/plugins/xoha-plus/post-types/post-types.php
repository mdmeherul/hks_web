<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'XohaPlusPostTypes' )) {
	/**
	 *
	 * @author iamdesigning11
	 *
	 */
	class XohaPlusPostTypes {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			// Header Post Type
			require_once XOHA_PLUS_DIR_PATH . 'post-types/header-post-type.php';
			// Footer Post Type
			require_once XOHA_PLUS_DIR_PATH . 'post-types/footer-post-type.php';
		}
	}
}

XohaPlusPostTypes::instance();