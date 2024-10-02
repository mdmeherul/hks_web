<?php

/**
 * WooCommerce - Single - Module - Upsell & Related - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Shop_Customizer_Single_Upsell_Related' ) ) {

    class Xoha_Shop_Customizer_Single_Upsell_Related {

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

            /**************
             *  Upsell
             **************/

                /**
                * Option : Show Upsell Products
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-display]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-display]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Upsell Products', 'xoha'),
                                'section' => 'woocommerce-single-page-upsell-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha' ),
                                    'off' => esc_attr__( 'No', 'xoha' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Upsell Title
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-title]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-title]', array(
                            'type'       => 'text',
                            'section'    => 'woocommerce-single-page-upsell-section',
                            'label'      => esc_html__( 'Upsell Title', 'xoha' )
                        )
                    );

                /**
                 * Option : Upsell Column
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-column]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-column]', array(
                            'type' => 'wdt-radio-image',
                            'label' => esc_html__( 'Upsell Column', 'xoha'),
                            'section' => 'woocommerce-single-page-upsell-section',
                            'choices' => apply_filters( 'xoha_woo_upsell_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));


                /**
                * Option : Upsell Limit
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-limit]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-limit]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Upsell Limit', 'xoha'),
                                'section'  => 'woocommerce-single-page-upsell-section',
                                'choices'  => array (
                                    1 => esc_html__( '1', 'xoha' ),
                                    2 => esc_html__( '2', 'xoha' ),
                                    3 => esc_html__( '3', 'xoha' ),
                                    4 => esc_html__( '4', 'xoha' ),
                                    5 => esc_html__( '5', 'xoha' ),
                                    6 => esc_html__( '6', 'xoha' ),
                                    7 => esc_html__( '7', 'xoha' ),
                                    8 => esc_html__( '8', 'xoha' ),
                                    9 => esc_html__( '9', 'xoha' ),
                                    10 => esc_html__( '10', 'xoha' ),
                                )
                            )
                        )
                    );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-style-template]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-upsell-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'xoha'),
                                'section'  => 'woocommerce-single-page-upsell-section',
                                'choices'  => xoha_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );


            /**************
             *  Related
             **************/

                /**
                * Option : Show Related Products
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-display]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-display]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Related Products', 'xoha'),
                                'section' => 'woocommerce-single-page-related-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha' ),
                                    'off' => esc_attr__( 'No', 'xoha' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Related Title
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-title]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-title]', array(
                            'type'       => 'text',
                            'section'    => 'woocommerce-single-page-related-section',
                            'label'      => esc_html__( 'Related Title', 'xoha' )
                        )
                    );

                /**
                 * Option : Related Column
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-column]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-column]', array(
                            'type' => 'wdt-radio-image',
                            'label' => esc_html__( 'Related Column', 'xoha'),
                            'section' => 'woocommerce-single-page-related-section',
                            'choices' => apply_filters( 'xoha_woo_related_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'xoha' ),
                                    'path' => xoha_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));


                /**
                * Option : Related Limit
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-limit]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-limit]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Related Limit', 'xoha'),
                                'section'  => 'woocommerce-single-page-related-section',
                                'choices'  => array (
                                    1 => esc_html__( '1', 'xoha' ),
                                    2 => esc_html__( '2', 'xoha' ),
                                    3 => esc_html__( '3', 'xoha' ),
                                    4 => esc_html__( '4', 'xoha' ),
                                    5 => esc_html__( '5', 'xoha' ),
                                    6 => esc_html__( '6', 'xoha' ),
                                    7 => esc_html__( '7', 'xoha' ),
                                    8 => esc_html__( '8', 'xoha' ),
                                    9 => esc_html__( '9', 'xoha' ),
                                    10 => esc_html__( '10', 'xoha' ),
                                )
                            )
                        )
                    );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-style-template]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-related-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'xoha'),
                                'section'  => 'woocommerce-single-page-related-section',
                                'choices'  => xoha_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );


        }

    }

}


if( !function_exists('xoha_shop_customizer_single_upsell_related') ) {
	function xoha_shop_customizer_single_upsell_related() {
		return Xoha_Shop_Customizer_Single_Upsell_Related::instance();
	}
}

xoha_shop_customizer_single_upsell_related();