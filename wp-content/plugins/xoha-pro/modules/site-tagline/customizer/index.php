<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProCustomizerSiteTagline' ) ) {
    class XohaProCustomizerSiteTagline {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'xoha_google_fonts_list', array( $this, 'fonts_list' ) );
        }

        function register( $wp_customize ) {

            /**
             * Option :Site Tagline Typography
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Typography(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-tagline-section',
                            'label'   => esc_html__( 'Typography', 'xoha-pro'),
                        )
                    )
                );


            /**
             * Option : Site Title Color
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[site_tagline_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[site_tagline_color]', array(
                            'label'   => esc_html__( 'Color', 'xoha-pro' ),
                            'section' => 'site-tagline-section',
                        )
                    )
                );
        }

        function fonts_list( $fonts ) {
            $settings = xoha_customizer_settings( 'site_tagline_typo' );
            return xoha_customizer_frontend_font( $settings, $fonts );
        }

    }
}

XohaProCustomizerSiteTagline::instance();