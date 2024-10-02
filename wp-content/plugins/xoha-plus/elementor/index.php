<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'XohaPlusElementor' )) {
	/**
	 *
	 * @author iamdesigning11
	 *
	 */
	class XohaPlusElementor {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {
            add_action( 'plugins_loaded', array( $this, 'register_init' ) );
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		}

        function register_init() {
            if(!did_action( 'elementor/loaded' )) {
                return;
            }

            add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
        }

        function register_category( $elements_manager ) {
            $elements_manager->add_category(
                'xoha-widgets', array(
                    'title' => esc_html__( 'Xoha', 'xoha-plus' ),
                    'icon'  => 'font'
                )
            );
        }

        function register_widgets( $widgets_manager ) {
            require XOHA_PLUS_DIR_PATH . 'elementor/class-common-widget-base.php';
        }

        function enqueue_assets() {
            wp_enqueue_style( 'xoha-plus-elementor', XOHA_PLUS_DIR_URL . 'elementor/assets/css/elementor.css', false, XOHA_PLUS_VERSION, 'all');
        }

	}
}

XohaPlusElementor::instance();