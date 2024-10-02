<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusSkinSecondaryColor' ) ) {
    class XohaPlusSkinSecondaryColor {
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

            add_filter( 'xoha_secondary_color_css_var', array( $this, 'secondary_color_var' ) );
            add_filter( 'xoha_secondary_rgb_color_css_var', array( $this, 'secondary_rgb_color_var' ) );
            add_filter( 'xoha_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('xoha_theme_defaults') ? xoha_theme_defaults() : array ();
            $option['secondary_color'] = $theme_defaults['secondary_color'];
            return $option;
        }

        function register( $wp_customize ) {

                /**
                 * Option : Secondary Color
                 */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[secondary_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Color(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[secondary_color]', array(
                            'section' => 'site-skin-main-section',
                            'label'   => esc_html__( 'Secondary Color', 'xoha-plus' ),
                        )
                    )
                );

        }

        function secondary_color_var( $var ) {
            $secondary_color = xoha_customizer_settings( 'secondary_color' );
            if( !empty( $secondary_color ) ) {
                $var = '--wdtSecondaryColor:'.esc_attr($secondary_color).';';
            }

            return $var;
        }

        function secondary_rgb_color_var( $var ) {
            $secondary_color = xoha_customizer_settings( 'secondary_color' );
            if( !empty( $secondary_color ) ) {
                $var = '--wdtSecondaryColorRgb:'.xoha_hex2rgba($secondary_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            $style = apply_filters( 'xoha_secondary_color_style', $style );

            return $style;
        }
    }
}

XohaPlusSkinSecondaryColor::instance();