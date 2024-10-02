<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusSkinPrimayColor' ) ) {
    class XohaPlusSkinPrimayColor {
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

            add_filter( 'xoha_primary_color_css_var', array( $this, 'primary_color_var' ) );
            add_filter( 'xoha_primary_rgb_color_css_var', array( $this, 'primary_rgb_color_var' ) );
            add_filter( 'xoha_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('xoha_theme_defaults') ? xoha_theme_defaults() : array ();
            $option['primary_color'] = $theme_defaults['primary_color'];
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Option : Primary Color
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[primary_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Color(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[primary_color]', array(
                        'section' => 'site-skin-main-section',
                        'label'   => esc_html__( 'Primary Color', 'xoha-plus' ),
                    )
                )
            );
        }

        function primary_color_var( $var ) {
            $primary_color = xoha_customizer_settings( 'primary_color' );
            if( !empty( $primary_color ) ) {
                $var = '--wdtPrimaryColor:'.esc_attr($primary_color).';';
            }

            return $var;
        }

        function primary_rgb_color_var( $var ) {
            $primary_color = xoha_customizer_settings( 'primary_color' );
            if( !empty( $primary_color ) ) {
                $var = '--wdtPrimaryColorRgb:'.xoha_hex2rgba($primary_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            $style = apply_filters( 'xoha_primary_color_style', $style );
            return $style;
        }
    }
}

XohaPlusSkinPrimayColor::instance();