<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusCustomizerSiteToTop' ) ) {
    class XohaPlusCustomizerSiteToTop {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_filter( 'xoha_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'xoha_general_cutomizer_options', array( $this, 'register_general' ), 40 );
        }

        function default( $option ) {
            $option['show_site_to_top'] = '0';
            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new Xoha_Customize_Section(
                    $wp_customize,
                    'site-to-top-section',
                    array(
                        'title'    => esc_html__('To Top', 'xoha-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 40,
                    )
                )
            );

                /**
                 * Option : Enable Site To Top
                 */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[show_site_to_top]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Switch(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[show_site_to_top]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-to-top-section',
                            'label'   => esc_html__( 'Enable To Top', 'xoha-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                                'off' => esc_attr__( 'No', 'xoha-plus' )
                            )
                        )
                    )
                );
        }
    }
}

XohaPlusCustomizerSiteToTop::instance();