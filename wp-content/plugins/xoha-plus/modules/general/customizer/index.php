<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusCustomizerSiteGeneral' ) ) {
    class XohaPlusCustomizerSiteGeneral {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new Xoha_Customize_Panel(
                    $wp_customize,
                    'site-general-main-panel',
                    array(
                        'title'    => esc_html__('Site General', 'xoha-plus'),
                        'priority' => xoha_customizer_panel_priority( 'general' )
                    )
                )
            );

            do_action('xoha_general_cutomizer_options', $wp_customize );

        }
    }
}

XohaPlusCustomizerSiteGeneral::instance();