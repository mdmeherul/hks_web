<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusCustomizerSidebar' ) ) {
    class XohaPlusCustomizerSidebar {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_action( 'customize_register', array( $this, 'register' ), 15);
            $this->load_modules();
        }

        function register( $wp_customize ) {

            /**
             * Main Panel
             */
            $wp_customize->add_panel(
                new Xoha_Customize_Panel(
                    $wp_customize,
                    'site-widget-main-panel',
                    array(
                        'title'    => esc_html__('Site Sidebar', 'xoha-plus'),
                        'priority' => xoha_customizer_panel_priority( 'sidebar' )
                    )
                )
            );

                /**
                 * Settings Panel
                 */
                $wp_customize->add_panel(
                    new Xoha_Customize_Panel(
                        $wp_customize,
                        'site-widget-settings-panel',
                        array(
                            'title'    => esc_html__('Settings', 'xoha-plus'),
                            'panel'    => 'site-widget-main-panel',
                            'priority' => 10
                        )
                    )
                );

                /**
                 * Widget Area Panel
                 */
                $wp_customize->add_panel(
                    new Xoha_Customize_Panel(
                        $wp_customize,
                        'widgets',
                        array(
                            'title'       => esc_html__('Widget Areas', 'xoha-plus'),
                            'panel'       => 'site-widget-main-panel',
                            'description' => esc_html__( 'Widgets are independent sections of content that can be placed into widgetized areas provided by your theme (commonly lled sidebars).', 'xoha-plus' ),
                            'priority'    => 15,
                        )
                    )
                );

        }

        function load_modules() {
            foreach( glob( XOHA_PLUS_DIR_PATH. 'modules/sidebar/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }

    }
}

XohaPlusCustomizerSidebar::instance();