<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusMainBGColor' ) ) {
    class XohaPlusMainBGColor {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'xoha_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'xoha_body_bg_color_css_var', array( $this, 'body_bg_color_var' ) );
            add_filter( 'xoha_body_bg_rgb_color_css_var', array( $this, 'body_bg_rgb_color_var' ) );
            add_filter( 'xoha_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('xoha_theme_defaults') ? xoha_theme_defaults() : array ();
            $option['body_bg_color'] = $theme_defaults['body_bg_color'];
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Option : Primary Color
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[body_bg_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Color(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[body_bg_color]', array(
                        'section' => 'site-skin-main-section',
                        'label'   => esc_html__( 'Main Background Color', 'xoha-plus' ),
                    )
                )
            );
        }

        function body_bg_color_var( $var ) {
            $body_bg_color = xoha_customizer_settings( 'body_bg_color' );
            if( !empty( $body_bg_color ) ) {
                $var = '--wdtBodyBGColor:'.esc_attr($body_bg_color).';';
            }

            return $var;
        }

        function body_bg_rgb_color_var( $var ) {
            $body_bg_color = xoha_customizer_settings( 'body_bg_color' );
            if( !empty( $body_bg_color ) ) {
                $var = '--wdtBodyBGColorRgb:'.xoha_hex2rgba($body_bg_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            return $style;
        }
    }
}

XohaPlusMainBGColor::instance();