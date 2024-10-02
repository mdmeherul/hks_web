<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusH6Settings' ) ) {
    class XohaPlusH6Settings {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->selector = apply_filters( 'xoha_h6_selector', array( 'h6' ) );
            $this->settings = xoha_customizer_settings('h6_typo');

            add_filter( 'xoha_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 20);

            add_filter( 'xoha_h6_typo_customizer_update', array( $this, 'h6_typo_customizer_update' ) );

            add_filter( 'xoha_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'xoha_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'xoha_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'xoha_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'xoha_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('xoha_theme_defaults') ? xoha_theme_defaults() : array ();
            $option['h6_typo'] = $theme_defaults['h6_typo'];
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Xoha_Customize_Section(
                    $wp_customize,
                    'site-h6-section',
                    array(
                        'title'    => esc_html__('H6 Typography', 'xoha-plus'),
                        'panel'    => 'site-typography-main-panel',
                        'priority' => 30,
                    )
                )
            );

            /**
             * Option :H6 Typo
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[h6_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Typography(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[h6_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-h6-section',
                            'label'   => esc_html__( 'H6 Tag', 'xoha-plus'),
                        )
                    )
                );

            /**
             * Option : H6 Color
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[h6_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[h6_color]', array(
                            'label'   => esc_html__( 'Color', 'xoha-plus' ),
                            'section' => 'site-h6-section',
                        )
                    )
                );

        }

        function h6_typo_customizer_update( $defaults ) {
            $h6_typo = xoha_customizer_settings( 'h6_typo' );
            if( !empty( $h6_typo ) ) {
                return  $h6_typo;
            }
            return $defaults;
        }

        function fonts_list( $fonts ) {
            return xoha_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = xoha_customizer_settings('h6_color');

            $css .= xoha_customizer_typography_settings( $this->settings );
            $css .= xoha_customizer_color_settings( $color );

            $css = xoha_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_landscape_style( $style ) {
            $css = xoha_customizer_responsive_typography_settings( $this->settings, 'tablet-ls' );
            $css = xoha_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_portrait( $style ) {
            $css = xoha_customizer_responsive_typography_settings( $this->settings, 'tablet' );
            $css = xoha_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function mobile_style( $style ) {
            $css = xoha_customizer_responsive_typography_settings( $this->settings, 'mobile' );
            $css = xoha_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }
    }
}

XohaPlusH6Settings::instance();