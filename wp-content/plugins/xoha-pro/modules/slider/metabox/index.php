<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxSlider' ) ) {
    class MetaboxSlider {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'slider' ) );
        }

        function slider( $options ) {

            $post_types = apply_filters( 'xoha_slider_posts', array( 'page' ) );

            $options[] = array(
                'id'        => '_xoha_slider_settings',
                'title'     => esc_html('Slider', 'xoha-pro'),
                'post_type' => $post_types,
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'layout_section',
                        'fields' => array(
                            array(
                                'id'      => 'slider-notice',
                                'type'    => 'notice',
                                'class'   => 'danger',
                                'content' => esc_html__('Slider tab works only if breadcrumb disabled.','xoha-pro'),
                                'class'   => 'margin-30 cs-danger'
                            ),
                            array(
                                'id'    => 'show',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show Slider', 'xoha-pro' ),
                            ),
                            array(
                                'id'         => 'position',
                                'type'       => 'select',
                                'title'      => esc_html__('Position?', 'xoha-pro' ),
                                'options'    => array(
                                    'header-top-relative' => esc_html__('Top Header Relative','xoha-pro'),
                                    'header-top-absolute' => esc_html__('Top Header Absolute','xoha-pro'),
                                    'bottom-header'       => esc_html__('Bottom Header','xoha-pro'),
                                ),
                                'default'    => 'bottom-header',
                                'dependency' => array( 'show', '==', 'true' ),
                            ),
                            array(
                                'id'         => 'type',
                                'type'       => 'select',
                                'title'      => esc_html__('Slider', 'xoha-pro' ),
                                'options'    => array(
                                  ''                 => esc_html__('Select a slider','xoha-pro'),
                                  'layerslider'      => esc_html__('Layer slider','xoha-pro'),
                                  'revolutionslider' => esc_html__('Revolution slider','xoha-pro'),
                                  'customslider'     => esc_html__('Custom Slider Shortcode','xoha-pro'),
                                ),
                                'dependency' => array( 'show', '==', 'true' ),
                            ),
                            array(
                                'id'         => 'layerslider',
                                'type'       => 'select',
                                'title'      => esc_html__('Layer Slider', 'xoha-pro' ),
                                'options'    => $this->layersliders(),
                                'dependency' => array( 'show|type', '==|==', 'true|layerslider' ),
                            ),
                            array(
                                'id'         => 'revolutionslider',
                                'type'       => 'select',
                                'title'      => esc_html__('Revolution Slider', 'xoha-pro' ),
                                'options'    => $this->revolutionsliders(),
                                'dependency' => array( 'show|type', '==|==', 'true|revolutionslider' ),
                            ),
                            array(
                                'id'         => 'customslider',
                                'type'       => 'textarea',
                                'title'      => esc_html__('Custom Slider Code', 'xoha-pro' ),
                                'dependency' => array( 'show|type', '==|==', 'true|customslider' ),
                            ),
                        )
                    )
                )
            );

            return $options;
        }

        function layersliders() {
            $layerslider = array( esc_html__('Select a slider','xoha-pro') );

            if( class_exists('LS_Sliders') ) {
                $sliders = LS_Sliders::find(array('limit' => 50));

                if(!empty($sliders)) {
                    foreach($sliders as $key => $item){
                        $layerslider[ $item['id'] ] = $item['name'];
                    }
                }
            }

            return $layerslider;
        }

        function revolutionsliders() {
            $revolutionslider = array( '' => esc_html__('Select a slider','xoha-pro') );

            if( class_exists('RevSlider') ) {
                $sld     = new RevSlider();
                $sliders = $sld->getArrSliders();

                if(!empty($sliders)){
                    foreach($sliders as $key => $item) {
                        $revolutionslider[$item->getAlias()] = $item->getTitle();
                    }
                }
            }

            return $revolutionslider;
        }
    }
}

MetaboxSlider::instance();