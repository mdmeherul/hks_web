<?php

/**
 * Listing Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Woo_Listing_Customizer_Settings' ) ) {

    class Xoha_Woo_Listing_Customizer_Settings {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Register Parent Customizer Menu */
                add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        /*
        Register Parent Customizer Menu
        */
            function register( $wp_customize ) {

                /**
                 * Panel
                 */
                $wp_customize->add_panel(
                    new Xoha_Customize_Panel(
                        $wp_customize,
                        'woocommerce-main-section',
                        array(
                            'title'    => esc_html__('Xoha - WooCommerce', 'xoha-pro'),
                            'priority' => xoha_customizer_panel_priority( 'woocommerce' )
                        )
                    )
                );

            }

        /*
        Product Templates List
        */
            function product_templates_list() {

                $product_templates_list = array ();

                $cs_options = get_option( CS_OPTION );

                if( is_array( $cs_options ) && !empty( $cs_options ) ) {
                    foreach( $cs_options as $cs_option_key => $cs_option ) {

                        if( strpos($cs_option_key, 'xoha-woo-product-style-template-') !== false ) {

                            $product_templates_list[str_replace('xoha-woo-product-style-template-', 'predefined-template-', $cs_option_key)] = $cs_option[0]['product-template-id'];

                        } else if( strpos($cs_option_key, 'xoha-woo-product-style-templates') !== false ) {

                            if( is_array( $cs_option ) && !empty( $cs_option ) ) {
                                foreach( $cs_option as $cs_custom_option_key => $cs_custom_option ) {
                                    $product_templates_list['custom-template-'.$cs_custom_option_key] = $cs_custom_option['product-template-id'];
                                }
                            }

                        }

                    }
                }

                return $product_templates_list;

            }

    }

}


if( !function_exists('xoha_woo_listing_customizer_settings') ) {
	function xoha_woo_listing_customizer_settings() {
		return Xoha_Woo_Listing_Customizer_Settings::instance();
	}
}

xoha_woo_listing_customizer_settings();


