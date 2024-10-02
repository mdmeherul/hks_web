<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProSideNav' ) ) {
    class XohaProSideNav {

        private static $_instance = null;
        private $global_layout    = '';
        private $global_sidebar   = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_module();
            $this->frontend();
        }

        function load_module() {
            include_once XOHA_PRO_DIR_PATH.'modules/side-nav/metabox/index.php';
            add_filter( 'theme_page_templates', array( $this, 'add_sidenav_template' ) );
        }

        function add_sidenav_template( $templates ) {
            $templates = array_merge( $templates, array( 'tpl-side-nav.php' => esc_html__('Side Navigation', 'xoha-pro' ) ) );
            return $templates;
        }

        function frontend() {
            add_action( 'xoha_after_main_css', array( $this, 'enqueue_assets' ) );
            add_action( 'xoha_before_single_page_content_wrap', array( $this, 'before_content_wrap' ) );
            add_action( 'xoha_after_single_page_content_wrap', array( $this, 'after_content_wrap' ), 9999999 );
        }

        function enqueue_assets() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                wp_enqueue_style( 'sidenav', XOHA_PRO_DIR_URL . 'modules/side-nav/assets/css/sidenav.css', false, XOHA_PRO_VERSION, 'all' );
                wp_enqueue_script( 'theia-sticky-sidebar', XOHA_PRO_DIR_URL . 'assets/js/theia-sticky-sidebar.min.js', array('jquery'), XOHA_PRO_VERSION, true );
                wp_enqueue_script( 'sidenav-sticky', XOHA_PRO_DIR_URL . 'modules/side-nav/assets/js/side-nav.js', array('theia-sticky-sidebar'), XOHA_PRO_VERSION, true );
            }
        }

        function before_content_wrap() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                $id       = get_the_ID();
                $settings = get_post_meta( $id, '_xoha_sidenav_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                $show_content = isset( $settings['show_content'] ) ? $settings['show_content'] : '';
                $content_id = isset( $settings['content'] ) ? $settings['content'] : '';

                $classes = '';
                if( isset( $settings['style'] ) ) {
                    $classes .= ' '.$settings['style'];
                }

                if( isset( $settings['align'] ) ) {
                    $classes .= " sidenav-alignright";
                }

                if( isset( $settings['sticky'] ) ) {
                    $classes .= " sidenav-sticky";
                }

                echo xoha_get_template_part( 'side-nav', 'template/tpl-side-nav', '', array( 'id' => $id, 'show_content' => $show_content, 'content_id' => $content_id, 'classes' => $classes ) );
                echo '<div class="side-navigation-content">';
            }
        }
        function after_content_wrap() {
            $page_template = $this->get_page_template();
            if( $page_template == 'tpl-side-nav.php' ) {
                echo "</div>";
            }
        }

        function get_page_template() {
            if( is_singular('page') ) {
                return get_post_meta( get_the_ID(), '_wp_page_template', true );
            }
        }
    }
}

XohaProSideNav::instance();