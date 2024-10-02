<?php

/**
 * Listing Customizer - Tag Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Pro_Listing_Customizer_Tag' ) ) {

    class Xoha_Pro_Listing_Customizer_Tag {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'xoha_shop_pro_customizer_default', array( $this, 'default' ) );
            add_filter( 'xoha_woo_tag_page_default_settings', array( $this, 'tag_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function default( $option ) {

            $settings = xoha_woo_listing_tag()->woo_default_settings();
            extract($settings);

            if( $product_style_template == 'predefined' ) {
                $option['wdt-woo-tag-page-product-style-template'] = 'predefined-template-'.$product_style_custom_template;
            } else {
                $option['wdt-woo-tag-page-product-style-template'] = $product_style_custom_template;
            }

            $option['wdt-woo-tag-page-product-per-page']       = $product_per_page;
            $option['wdt-woo-tag-page-product-layout']         = $product_layout;
            $option['wdt-woo-tag-page-enable-breadcrumb']      = $enable_breadcrumb;

            // Default Values from Shop Plugin
            $option['wdt-woo-tag-page-bottom-hook']            = $bottom_hook;
            $option['wdt-woo-tag-page-show-sorter-on-header']  = $show_sorter_on_header;
            $option['wdt-woo-tag-page-sorter-header-elements'] = $sorter_header_elements;
            $option['wdt-woo-tag-page-show-sorter-on-footer']  = $show_sorter_on_footer;
            $option['wdt-woo-tag-page-sorter-footer-elements'] = $sorter_footer_elements;

            return $option;

        }

        function tag_page_default_settings( $settings ) {

            $product_style_custom_template = xoha_customizer_settings('wdt-woo-tag-page-product-style-template' );
            if( isset($product_style_custom_template) && !empty($product_style_custom_template) ) {
                $settings['product_style_template']        = 'custom';
                $settings['product_style_custom_template'] = $product_style_custom_template;
            }

            $product_per_page              = xoha_customizer_settings('wdt-woo-tag-page-product-per-page' );
            $settings['product_per_page']  = $product_per_page;

            $product_layout                = xoha_customizer_settings('wdt-woo-tag-page-product-layout' );
            $settings['product_layout']    = $product_layout;

            $enable_breadcrumb             = xoha_customizer_settings('wdt-woo-tag-page-enable-breadcrumb' );
            $settings['enable_breadcrumb'] = $enable_breadcrumb;

            return $settings;

        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Xoha_Customize_Section(
                    $wp_customize,
                    'woocommerce-tag-page-section',
                    array(
                        'title'    => esc_html__('Tag Page', 'xoha-pro'),
                        'panel'    => 'woocommerce-main-section',
                        'priority' => 30,
                    )
                )
            );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-product-style-template]', array(
                            'type'              => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-product-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'xoha-pro'),
                                'section'  => 'woocommerce-tag-page-section',
                                'choices'  => xoha_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );

                /**
                 * Option : Products Per Page
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-product-per-page]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-product-per-page]', array(
                                'type'        => 'number',
                                'label'       => esc_html__( 'Products Per Page', 'xoha-pro' ),
                                'section'     => 'woocommerce-tag-page-section'
                            )
                        )
                    );


                /**
                 * Option : Product Layout
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-product-layout]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-product-layout]', array(
                            'type' => 'wdt-radio-image',
                            'label' => esc_html__( 'Columns', 'xoha-pro'),
                            'section' => 'woocommerce-tag-page-section',
                            'choices' => apply_filters( 'xoha_woo_tag_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'xoha-pro' ),
                                    'path' => XOHA_PRO_DIR_URL . 'modules/woocommerce/tag/customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'xoha-pro' ),
                                    'path' => XOHA_PRO_DIR_URL . 'modules/woocommerce/tag/customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'xoha-pro' ),
                                    'path' => XOHA_PRO_DIR_URL . 'modules/woocommerce/tag/customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'xoha-pro' ),
                                    'path' => XOHA_PRO_DIR_URL . 'modules/woocommerce/tag/customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));

                /**
                 * Option : Enable Breadcrumb
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-enable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-woo-tag-page-enable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Enable Breadcrumb', 'xoha-pro'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                    'off' => esc_attr__( 'No', 'xoha-pro' )
                                )
                            )
                        )
                    );

        }

    }

}


if( !function_exists('xoha_listing_customizer_tag') ) {
	function xoha_listing_customizer_tag() {
		return Xoha_Pro_Listing_Customizer_Tag::instance();
	}
}

xoha_listing_customizer_tag();