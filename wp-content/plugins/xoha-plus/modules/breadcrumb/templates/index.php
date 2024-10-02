<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusBCTemplate' ) ) {
    class XohaPlusBCTemplate {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_frontend();
        }

        function load_frontend() {
            add_filter( 'xoha_breadcrumb_params', array( $this, 'register_breadcrumb_params' ) );
            add_filter( 'xoha_breadcrumb_get_template_part', array( $this, 'register_template' ), 10, 2 );

            add_action( 'xoha_after_main_css', array( $this, 'enqueue_assets' ) );

            add_filter( 'xoha_header_wrapper_classes', array( $this, 'register_header_class' ) );
        }

        function register_header_class() {

            $header_cls = xoha_customizer_settings('breadcrumb_position');

            if( is_singular() ) {

                $post_id = get_the_ID();
                $bc_meta       = $this->register_meta_params( $post_id );

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {
                    $header_cls = $bc_meta['position'];
                }
                return $header_cls;
            } else {
                return $header_cls;
            }
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-breadcrumb', XOHA_PLUS_DIR_URL . 'modules/breadcrumb/assets/css/breadcrumb.css', XOHA_PLUS_VERSION );
        }

        function base_meta_style( $meta ) {

            $bg_meta = array_key_exists( 'background', $meta ) ? $meta['background'] : array();

            $style = '';
            $bg = array();

            $bg['background-image']      = array_key_exists( 'image' , $bg_meta ) ? $bg_meta['image'] : '';
            $bg['background-repeat']     = array_key_exists( 'repeat' , $bg_meta ) ? $bg_meta['repeat'] : '';
            $bg['background-position']   = array_key_exists( 'position' , $bg_meta ) ? $bg_meta['position'] : '';
            $bg['background-attachment'] = array_key_exists( 'attachment' , $bg_meta ) ? $bg_meta['attachment'] : '';
            $bg['background-size']       = array_key_exists( 'size' , $bg_meta ) ? $bg_meta['size'] : '';
            $bg['background-color']      = array_key_exists( 'color' , $bg_meta ) ? $bg_meta['color'] : '';

            $bg_css         = xoha_customizer_bg_settings( $bg );
            //$enable_overlay = xoha_customizer_settings('breadcrumb_overlay_bg_color');
            $enable_overlay = array_key_exists( 'enable_overlay', $meta ) ? $meta['enable_overlay'] : 0;
            $gradient_color = array_key_exists( 'gradient_color', $meta ) ? $meta['gradient_color'] : '';
            $bg['gradient-background-color'] = isset($gradient_color) ? $gradient_color : '';

            if( !empty( $bg_css ) && empty( $enable_overlay ) ) {

                $style .= xoha_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper > .main-title-section-bg', $bg_css );

            } elseif( !empty( $enable_overlay ) ) {

                $overlay_color = array_key_exists( 'background-color', $bg ) ? $bg['background-color'] : '';
                $overlay_gradient_color = array_key_exists( 'gradient-background-color', $bg ) ? $bg['gradient-background-color'] : '';
                $bg['background-color'] = '';
                $bg['gradient-background-color'] = '';

                $bg_css = xoha_customizer_bg_settings( $bg );

                if( !empty( $bg_css ) ) {
                    $style .= xoha_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper > .main-title-section-bg', $bg_css );
                }

                if( !empty( $overlay_color ) || !empty( $overlay_gradient_color ) ) {
                    $bg_css = xoha_customizer_bg_settings( array( 'background-color' => $overlay_color, 'gradient-background-color' => $overlay_gradient_color, 'breadcrumb_overlay_bg_color' => true ) );
                    $style .= xoha_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg:after, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg:after, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg:after, .main-title-section-wrapper > .main-title-section-bg:after', $bg_css );
                }

            }

            if( !empty( $style ) ){
                wp_register_style( 'site-breadcrumb-inline', '', array (), XOHA_PLUS_VERSION, 'all' );
                wp_enqueue_style( 'site-breadcrumb-inline' );
                wp_add_inline_style( 'site-breadcrumb-inline', $style );
            }
        }

        function register_breadcrumb_params() {

            $enable_delimiter = xoha_customizer_settings( 'change_breadcrumb_delimiter' );
            $delimiter        = xoha_customizer_settings( 'breadcrumb_delimiter' );

            $delimiter = ( $enable_delimiter ) ? '<span class="'.esc_attr($delimiter).'"></span>' : '<span class="breadcrumb-default-delimiter"></span>';

            $wrapper_class    = array();
            $enable_darkbg    = xoha_customizer_settings( 'enable_dark_bg_breadcrumb' );
            $breadcrumb_style = xoha_customizer_settings( 'breadcrumb_style' );

            if( $enable_darkbg ) {
                $wrapper_class[] = 'dark-bg-breadcrumb';
            }

            $wrapper_class[] = $breadcrumb_style;

            $bc_overlay_bg_color = xoha_customizer_settings( 'breadcrumb_overlay_bg_color' );
            if($bc_overlay_bg_color) {
                $wrapper_class[] = 'overlay-wrapper';
            }

            $params = array(
                'home'             => esc_html__( 'Home', 'xoha-plus' ),
                'home_link'        => home_url('/'),
                'delimiter'        => $delimiter,
                'wrapper_classes'  => implode( ' ', $wrapper_class )
            );

            return $params;
        }

        function register_meta_params( $post_id ) {

            $post_meta = get_post_meta( $post_id, '_xoha_breadcrumb_settings', true );
            $post_meta = is_array( $post_meta ) ? $post_meta : array();

            return $post_meta;
        }

        function register_template( $args, $post_id ) {

            $style         = '';

            $template_args = $this->register_breadcrumb_params();
            $bc_meta       = $this->register_meta_params( $post_id );

            if( empty($bc_meta) || ( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] != 'disable' ) ) {

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {

                    $wrapper_class    = array();
                    $enable_darkbg    = array_key_exists( 'enable_dark_bg', $bc_meta ) ? $bc_meta['enable_dark_bg'] : '';
                    $breadcrumb_style = xoha_customizer_settings( 'breadcrumb_style' );

                    if( $enable_darkbg ) {
                        $wrapper_class[] = 'dark-bg-breadcrumb';
                    }

                    $wrapper_class[] = $breadcrumb_style;

                    if(array_key_exists( 'enable_overlay', $bc_meta ) && $bc_meta['enable_overlay']) {
                        $wrapper_class[] = 'overlay-wrapper';
                    }

                    $template_args['wrapper_classes'] = implode( ' ', $wrapper_class );
                    $this->base_meta_style( $bc_meta );

                } else {
                    $enable_bc = xoha_customizer_settings( 'enable_breadcrumb' );
                    if( ! $enable_bc ) {
                        return;
                    }
                }

                $bc_source = xoha_customizer_settings( 'breadcrumb_source' );

                switch( $bc_source ):

                    case 'default':
                    default:
                        xoha_template_part( 'breadcrumb', 'templates/default/title-content', '', $template_args );
                    break;

                endswitch;
            } else {
                $enable_bc = xoha_customizer_settings( 'enable_breadcrumb' );
                if( ! $enable_bc ) {
                    return;
                }
            }

        }

    }
}

XohaPlusBCTemplate::instance();