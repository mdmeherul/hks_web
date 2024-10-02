<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusGlobalSibarSettings' ) ) {
    class XohaPlusGlobalSibarSettings {

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
        }

        function default( $option ) {
            $option['global_sidebar_layout'] = 'content-full-width';
            $option['global_sidebar']        = '';
            $option['hide_standard_sidebar'] = '';
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Global Sidebar Panel
             */
            $wp_customize->add_section(
                new Xoha_Customize_Section(
                    $wp_customize,
                    'site-global-sidebar-section',
                    array(
                        'title'    => esc_html__('Global Sidebar', 'xoha-plus'),
                        'panel'    => 'site-widget-main-panel',
                        'priority' => 5
                    )
                )
            );

                /**
                 * Option: Global Sidebar Layout
                 */
                    $wp_customize->add_setting(
                        XOHA_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type'    => 'wdt-radio-image',
                            'label'   => esc_html__( 'Global Sidebar Layout', 'xoha-plus'),
                            'section' => 'site-global-sidebar-section',
                            'choices' => apply_filters( 'xoha_global_sidebar_layouts', array(
                                'content-full-width' => array(
                                    'label' => esc_html__( 'Without Sidebar', 'xoha-plus' ),
                                    'path'  =>  XOHA_PLUS_DIR_URL . 'modules/sidebar/customizer/images/without-sidebar.png'
                                ),
                                'with-left-sidebar'  => array(
                                    'label' => esc_html__( 'With Left Sidebar', 'xoha-plus' ),
                                    'path'  =>  XOHA_PLUS_DIR_URL . 'modules/sidebar/customizer/images/left-sidebar.png'
                                ),
                                'with-right-sidebar' => array(
                                    'label' => esc_html__( 'With Right Sidebar', 'xoha-plus' ),
                                    'path'  =>  XOHA_PLUS_DIR_URL . 'modules/sidebar/customizer/images/right-sidebar.png'
                                ),
                            ) )
                        )
                    ) );

                /**
                 * Option : Hide Standard Sidebar
                 */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[hide_standard_sidebar]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Switch(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[hide_standard_sidebar]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-global-sidebar-section',
                            'label'   => esc_html__( 'Hide Standard Sidebar', 'xoha-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                                'off' => esc_attr__( 'No', 'xoha-plus' )
                            )
                        )
                    )
                );

                if ( ! defined( 'XOHA_PRO_VERSION' ) ) {
                    $wp_customize->add_control(
                        new Xoha_Customize_Control_Separator(
                            $wp_customize, XOHA_CUSTOMISER_VAL . '[xoha-plus-site-global-sidebar-separator]',
                            array(
                                'type'        => 'wdt-separator',
                                'section'     => 'site-global-sidebar-section',
                                'settings'    => array(),
                                'caption'     => XOHA_PLUS_REQ_CAPTION,
                                'description' => XOHA_PLUS_REQ_DESC,
                            )
                        )
                    );
                }

        }
    }
}

XohaPlusGlobalSibarSettings::instance();