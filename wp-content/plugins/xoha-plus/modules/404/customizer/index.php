<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusCustomizerSite404' ) ) {
    class XohaPlusCustomizerSite404 {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ) {

            /**
             * 404 Page
             */
            $wp_customize->add_section(
                new Xoha_Customize_Section(
                    $wp_customize,
                    'site-404-page-section',
                    array(
                        'title'    => esc_html__('404 Page', 'xoha-plus'),
                        'priority' => xoha_customizer_panel_priority( '404' )
                    )
                )
            );

            if ( ! defined( 'XOHA_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Xoha_Customize_Control_Separator(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[xoha-plus-site-404-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-404-page-section',
                            'settings'    => array(),
                            'caption'     => XOHA_PLUS_REQ_CAPTION,
                            'description' => XOHA_PLUS_REQ_DESC,
                        )
                    )
                );
            }

        }

    }
}

XohaPlusCustomizerSite404::instance();