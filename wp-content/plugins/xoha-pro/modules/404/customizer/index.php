<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProCustomizerSite404' ) ) {
    class XohaProCustomizerSite404 {

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

            $option['enable_404message']   = '1';
            $option['notfound_style']      = 'type2';
            $option['notfound_darkbg']     = '1';
            $option['notfound_pageid']     = '';
            $option['notfound_background'] = array(
                'background-color'      => 'rgb(0,0,0)',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );
            $option['notfound_bg_style'] = '';

            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Option : 404 Meaage
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[enable_404message]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Switch(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[enable_404message]', array(
                            'type'        => 'wdt-switch',
                            'label'       => esc_html__( 'Enable Message', 'xoha-pro'),
                            'description' => esc_html__('YES! to enable not-found page message.', 'xoha-pro'),
                            'section'     => 'site-404-page-section',
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                'off' => esc_attr__( 'No', 'xoha-pro' )
                            )
                        )
                    )
                );

            /**
             * Option : Template Style
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[notfound_style]', array(
                        'default' => 'type2',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[notfound_style]', array(
                            'type'    => 'select',
                            'section' => 'site-404-page-section',
                            'label'   => esc_html__( 'Template Style', 'xoha-pro' ),
                            'choices' => array(
                                'type1'  => esc_html__('Modern', 'xoha-pro'),
                                'type2'  => esc_html__('Classic', 'xoha-pro'),
                                'type4'  => esc_html__('Diamond', 'xoha-pro'),
                                'type5'  => esc_html__('Shadow', 'xoha-pro'),
                                'type6'  => esc_html__('Diamond Alt', 'xoha-pro'),
                                'type7'  => esc_html__('Stack', 'xoha-pro'),
                                'type8'  => esc_html__('Minimal', 'xoha-pro'),
                            ),
                            'description' => esc_html__('Choose the style of not-found template page.', 'xoha-pro'),
                        )
                    )
                );

            /**
             * Option : Notfound Dark BG
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[notfound_darkbg]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Switch(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[notfound_darkbg]', array(
                            'type'        => 'wdt-switch',
                            'label'       => esc_html__( '404 Dark BG', 'xoha-pro'),
                            'description' => esc_html__('YES! to use dark bg notfound page for this site.', 'xoha-pro'),
                            'section'     => 'site-404-page-section',
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
                                'off' => esc_attr__( 'No', 'xoha-pro' )
                            )
                        )
                    )
                );

            /**
             * Option : Custom Page
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[notfound_pageid]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[notfound_pageid]', array(
                            'type'        => 'select',
                            'section'     => 'site-404-page-section',
                            'label'       => esc_html__( 'Custom Page', 'xoha-pro' ),
                            'choices'     => $this->pages_list(),
                            'description' => esc_html__('Choose the page for not-found content.', 'xoha-pro'),
                        )
                    )
                );

            /**
             * Option : 404 Background
             */
                $wp_customize->add_setting(
                    XOHA_CUSTOMISER_VAL . '[notfound_background]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Xoha_Customize_Control_Background(
                        $wp_customize, XOHA_CUSTOMISER_VAL . '[notfound_background]', array(
                            'type'    => 'wdt-background',
                            'section' => 'site-404-page-section',
                            'label'   => esc_html__( 'Background', 'xoha-pro' ),
                        )
                    )
                );

            /**
             * Option : Custom Styles
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[notfound_bg_style]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[notfound_bg_style]', array(
                        'type'    	  => 'textarea',
                        'section'     => 'site-404-page-section',
                        'label'       => esc_html__( 'Custom Inline Styles', 'xoha-pro' ),
                        'description' => esc_html__('Paste custom CSS styles for not found page.', 'xoha-pro'),
                        'input_attrs' => array(
                            'placeholder' => esc_html__( 'color:#ff00bb; text-align:left;', 'xoha-pro' ),
                        ),
                    )
                )
            );

        }

        function pages_list() {
            $choices     = array();
            $choices[''] = esc_html__('Choose the page', 'xoha-pro');

            $args  = array(
                'post_type'   => 'page',
                'post_status' => 'publish'
            );
            $pages = get_pages($args);

            foreach( $pages as $page ):
                $choices[$page->ID]	= $page->post_title;
            endforeach;

            return $choices;
        }

    }
}

XohaProCustomizerSite404::instance();