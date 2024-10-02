<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProSlider' ) ) {
    class XohaProSlider {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once XOHA_PRO_DIR_PATH.'modules/slider/metabox/index.php';
        }

        function frontend() {
            add_action( 'xoha_after_main_css', array( $this, 'enqueue_assets' ) );
            add_action( 'xoha_slider', array( $this, 'load_template' ), 11 );
        }

        function enqueue_assets() {

            if ( is_singular( 'page') ) {
                $settings = get_post_meta( get_queried_object_id(), '_xoha_slider_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['show'] ) && isset( $settings['type']) ) {
                    wp_enqueue_style( 'site-slider', XOHA_PRO_DIR_URL . 'modules/slider/assets/css/slider.css', false, XOHA_PRO_VERSION, 'all' );
                }
            }
        }

        function load_template() {

            if ( is_singular( 'page') ) {
                $settings = get_post_meta( get_queried_object_id(), '_xoha_slider_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['show'] ) && isset( $settings['type']) ) {
                    $type = $settings['type'];
                    $id   = isset( $settings[$type] ) ? $settings[$type] : '';
                    echo xoha_get_template_part( 'slider', 'layouts/'.$type.'/template', '', array( 'code' => $id ) );
                }
            }
        }

    }
}

XohaProSlider::instance();