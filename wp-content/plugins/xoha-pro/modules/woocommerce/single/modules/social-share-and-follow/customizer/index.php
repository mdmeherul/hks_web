<?php

/**
 * WooCommerce - Single - Module - Social Share & Follow - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Shop_Customizer_Single_Social_Share_And_Follow' ) ) {

    class Xoha_Shop_Customizer_Single_Social_Share_And_Follow {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'xoha_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_show_sharer_facebook                = xoha_customizer_settings('wdt-single-product-show-sharer-facebook' );
            $settings['product_show_sharer_facebook']    = $product_show_sharer_facebook;

            $product_show_sharer_delicious               = xoha_customizer_settings('wdt-single-product-show-sharer-delicious' );
            $settings['product_show_sharer_delicious']   = $product_show_sharer_delicious;

            $product_show_sharer_digg                    = xoha_customizer_settings('wdt-single-product-show-sharer-digg' );
            $settings['product_show_sharer_digg']        = $product_show_sharer_digg;

            $product_show_sharer_twitter                 = xoha_customizer_settings('wdt-single-product-show-sharer-twitter' );
            $settings['product_show_sharer_twitter']     = $product_show_sharer_twitter;

            $product_show_sharer_linkedin                = xoha_customizer_settings('wdt-single-product-show-sharer-linkedin' );
            $settings['product_show_sharer_linkedin']    = $product_show_sharer_linkedin;

            $product_show_sharer_pinterest               = xoha_customizer_settings('wdt-single-product-show-sharer-pinterest' );
            $settings['product_show_sharer_pinterest']   = $product_show_sharer_pinterest;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Share
            */

                /**
                * Option : Sharer Description
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-description]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-description]', array(
                                'type'        => 'wdt-description',
                                'label'       => esc_html__( 'Note: ', 'xoha-pro'),
                                'section'     => 'woocommerce-single-page-sociable-share-section',
                                'description' => esc_html__( 'This option is applicable only for WooCommerce "Custom Template".', 'xoha-pro')
                            )
                        )
                    );

                /**
                * Option : Show Facebook Sharer
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-facebook]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-facebook]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Facebook Sharer', 'xoha-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                    'off' => esc_attr__( 'No', 'xoha-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Delicious Sharer
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-delicious]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-delicious]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Delicious Sharer', 'xoha-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                    'off' => esc_attr__( 'No', 'xoha-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Digg Sharer
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-digg]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-digg]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Digg Sharer', 'xoha-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                    'off' => esc_attr__( 'No', 'xoha-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Twitter Sharer
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-twitter]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-twitter]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Twitter Sharer', 'xoha-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                    'off' => esc_attr__( 'No', 'xoha-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show LinkedIn Sharer
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-linkedin]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-linkedin]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show LinkedIn Sharer', 'xoha-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                    'off' => esc_attr__( 'No', 'xoha-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Pinterest Sharer
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-pinterest]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-pinterest]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Pinterest Sharer', 'xoha-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                    'off' => esc_attr__( 'No', 'xoha-pro' )
                                )
                            )
                        )
                    );

            /**
            * Follow
            */

                /**
                * Option : Follow Description
                */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-follow-description]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Switch(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-follow-description]', array(
                                'type'    => 'wdt-description',
                                'label'   => esc_html__( 'Note :', 'xoha-pro'),
                                'section' => 'woocommerce-single-page-sociable-follow-section',
                                'description'   => esc_html__( 'This option is applicable only for WooCommerce "Custom Template".', 'xoha-pro'),
                            )
                        )
                    );

                    $social_follow = array (
                        'delicious'   => esc_html__('Delicious', 'xoha-pro'),
                        'deviantart'  => esc_html__('Deviantart', 'xoha-pro'),
                        'digg'        => esc_html__('Digg', 'xoha-pro'),
                        'dribbble'    => esc_html__('Dribbble', 'xoha-pro'),
                        'envelope'    => esc_html__('Envelope', 'xoha-pro'),
                        'facebook'    => esc_html__('Facebook', 'xoha-pro'),
                        'flickr'      => esc_html__('Flickr', 'xoha-pro'),
                        'google-plus' => esc_html__('Google Plus', 'xoha-pro'),
                        'gtalk'       => esc_html__('GTalk', 'xoha-pro'),
                        'instagram'   => esc_html__('Instagram', 'xoha-pro'),
                        'lastfm'      => esc_html__('Lastfm', 'xoha-pro'),
                        'linkedin'    => esc_html__('Linkedin', 'xoha-pro'),
                        'myspace'     => esc_html__('Myspace', 'xoha-pro'),
                        'picasa'      => esc_html__('Picasa', 'xoha-pro'),
                        'pinterest'   => esc_html__('Pinterest', 'xoha-pro'),
                        'reddit'      => esc_html__('Reddit', 'xoha-pro'),
                        'rss'         => esc_html__('RSS', 'xoha-pro'),
                        'skype'       => esc_html__('Skype', 'xoha-pro'),
                        'stumbleupon' => esc_html__('Stumbleupon', 'xoha-pro'),
                        'technorati'  => esc_html__('Technorati', 'xoha-pro'),
                        'tumblr'      => esc_html__('Tumblr', 'xoha-pro'),
                        'twitter'     => esc_html__('Twitter', 'xoha-pro'),
                        'viadeo'      => esc_html__('Viadeo', 'xoha-pro'),
                        'vimeo'       => esc_html__('Vimeo', 'xoha-pro'),
                        'yahoo'       => esc_html__('Yahoo', 'xoha-pro'),
                        'youtube'     => esc_html__('Youtube', 'xoha-pro')
                    );

                    foreach($social_follow as $socialfollow_key => $socialfollow) {

                        $wp_customize->add_setting(
                            XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-follow-'.$socialfollow_key.']', array(
                                'type' => 'option'
                            )
                        );

                        $wp_customize->add_control(
                            new Xoha_Customize_Control_Switch(
                                $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-show-follow-'.$socialfollow_key.']', array(
                                    'type'    => 'wdt-switch',
                                    'label'   => sprintf(esc_html__('Show %1$s Follow', 'xoha-pro'), $socialfollow),
                                    'section' => 'woocommerce-single-page-sociable-follow-section',
                                    'choices' => array(
                                        'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                        'off' => esc_attr__( 'No', 'xoha-pro' )
                                    )
                                )
                            )
                        );

                        $wp_customize->add_setting(
                            XOHA_CUSTOMISER_VAL . '[wdt-single-product-follow-'.$socialfollow_key.'-link]', array(
                                'type' => 'option'
                            )
                        );

                        $wp_customize->add_control(
                            new Xoha_Customize_Control(
                                $wp_customize, XOHA_CUSTOMISER_VAL . '[wdt-single-product-follow-'.$socialfollow_key.'-link]', array(
                                    'type'       => 'text',
                                    'section'    => 'woocommerce-single-page-sociable-follow-section',
                                    'input_attrs' => array(
                                        'placeholder' => sprintf(esc_html__('%1$s Link', 'xoha-pro'), $socialfollow)
                                    ),
                                    'dependency' => array ( 'wdt-single-product-show-follow-'.$socialfollow_key, '==', '1' )
                                )
                            )
                        );

                    }

        }

    }

}


if( !function_exists('xoha_shop_customizer_single_social_share_and_follow') ) {
	function xoha_shop_customizer_single_social_share_and_follow() {
		return Xoha_Shop_Customizer_Single_Social_Share_And_Follow::instance();
	}
}

xoha_shop_customizer_single_social_share_and_follow();