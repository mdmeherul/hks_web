<?php

/**
 * WooCommerce - Single - Module - 360 Viewer - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Shop_Customizer_Others_Recently_Viewed_Products' ) ) {

    class Xoha_Shop_Customizer_Others_Recently_Viewed_Products {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'xoha_woo_others_settings', array( $this, 'others_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function others_settings( $settings ) {

            $enable_recently_viewed_products                 = xoha_customizer_settings('wdt-woo-others-enable-recently-viewed-products' );
            $settings['enable_recently_viewed_products']     = $enable_recently_viewed_products;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Option : Enable Recently Viewed Products
            */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[wdt-woo-others-enable-recently-viewed-products]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Switch(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-woo-others-enable-recently-viewed-products]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Recently Viewed Products', 'xoha-pro'),
                            'section' => 'woocommerce-others-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                'off' => esc_attr__( 'No', 'xoha-pro' )
                            ),
                            'description'   => esc_html__('Enable recently viewed product sticky section.', 'xoha-pro'),
                        )
                    )
                );

        }

    }

}


if( !function_exists('xoha_shop_customizer_others_recently_viewed_products') ) {
	function xoha_shop_customizer_others_recently_viewed_products() {
		return Xoha_Shop_Customizer_Others_Recently_Viewed_Products::instance();
	}
}

xoha_shop_customizer_others_recently_viewed_products();