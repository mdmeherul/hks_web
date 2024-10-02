<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusCustomizerSiteHeader' ) ) {
    class XohaPlusCustomizerSiteHeader {

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

            $wp_customize->add_section(
                new Xoha_Customize_Section(
                    $wp_customize,
                    'site-header-section',
                    array(
                        'title'    => esc_html__('Header', 'xoha-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 10,
                    )
                )
            );

                /**
                 * Option :Site Header
                 */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[site_header]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[site_header]', array(
                            'type'    => 'select',
                            'section' => 'site-header-section',
                            'label'   => esc_html__( 'Site Header', 'xoha-plus' ),
                            'choices' => apply_filters( 'xoha_header_layouts', array() ),
                        )
                    )
                );

        }
    }
}

XohaPlusCustomizerSiteHeader::instance();