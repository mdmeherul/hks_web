<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProGlobalSibarSettings' ) ) {
    class XohaProGlobalSibarSettings {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'xoha_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function default( $option ) {
            $option['global_sidebar'] = '';
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Option: Global Sidebar
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[global_sidebar]', array(
                    'type' => 'option',
                )
            );

            $metabox = MetaboxSidebar::instance();
            $wp_customize->add_control( new Xoha_Customize_Control(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[global_sidebar]', array(
                    'type'       => 'select',
                    'section'    => 'site-global-sidebar-section',
                    'label'      => esc_html__( 'Global Custom Sidebar?', 'xoha-pro' ),
                    'choices'    => $metabox->registered_widget_areas(),
                    'dependency' => array( 'global_sidebar_layout', 'any', 'with-left-sidebar,with-right-sidebar' ),
                )
            ) );

        }
    }
}

XohaProGlobalSibarSettings::instance();