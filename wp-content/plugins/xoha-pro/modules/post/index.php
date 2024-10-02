<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProPost' ) ) {
    class XohaProPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_post_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_post_layouts() {
            foreach( glob( XOHA_PRO_DIR_PATH. 'modules/post/templates/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once XOHA_PRO_DIR_PATH.'modules/post/customizer/index.php';
            include_once XOHA_PRO_DIR_PATH.'modules/post/metabox/index.php';
            include_once XOHA_PRO_DIR_PATH.'modules/post/elementor/index.php';
        }

        function frontend() {
            add_action( 'xoha_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );

            add_filter( 'xoha_single_post_params', array( $this, 'register_single_post_params' ) );
            add_filter( 'xoha_single_post_style', array( $this, 'load_post_style'), 10, 2 );
            add_filter( 'xoha_single_post_image', array( $this, 'load_post_image' ), 10, 3 );

            add_action( 'xoha_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );

            add_action( 'wp_ajax_single_post_process_like', array( $this, 'single_post_process_like' ) );
            add_action( 'wp_ajax_nopriv_single_post_process_like', array( $this, 'single_post_process_like' ) );

            $enable = xoha_customizer_settings( 'enable_related_article' );
            if( !empty( $enable )  ) {
                add_action( 'xoha_after_single_post_content_wrap', array( $this, 'single_post_related_article' ) );
            }
        }

        function enqueue_css_assets() {
            if( is_singular('post') ) {
                wp_enqueue_style( 'xoha-pro-post', XOHA_PRO_DIR_URL . 'modules/post/assets/css/post.css', false, XOHA_PRO_VERSION, 'all');

                $post_style = xoha_get_single_post_style( get_the_ID() );
                wp_enqueue_style( 'wdt-blog-post-'.$post_style, XOHA_PRO_DIR_URL . 'modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css', false, XOHA_PRO_VERSION, 'all');
            }
        }

        function register_single_post_params() {

            $params = array(
                'enable_title'           => xoha_customizer_settings( 'enable_title' ),
                'enable_image_lightbox'  => xoha_customizer_settings( 'enable_image_lightbox' ),
                'enable_disqus_comments' => xoha_customizer_settings( 'enable_disqus_comments' ),
                'enable_related_article' => xoha_customizer_settings( 'enable_related_article' ),
                'post_disqus_shortname'  => xoha_customizer_settings( 'post_disqus_shortname' ),
                'post_dynamic_elements'  => xoha_customizer_settings( 'post_dynamic_elements' ),
                'rposts_title'           => xoha_customizer_settings( 'rposts_title' ),
                'rposts_column'          => xoha_customizer_settings( 'rposts_column' ),
                'rposts_count'           => xoha_customizer_settings( 'rposts_count' ),
                'rposts_excerpt'         => xoha_customizer_settings( 'rposts_excerpt' ),
                'rposts_excerpt_length'  => xoha_customizer_settings( 'rposts_excerpt_length' ),
                'rposts_carousel'        => xoha_customizer_settings( 'rposts_carousel' ),
                'rposts_carousel_nav'    => xoha_customizer_settings( 'rposts_carousel_nav' ),
                'post_commentlist_style' => xoha_customizer_settings( 'post_commentlist_style' )
            );

            return $params;
        }

        function load_post_style( $post_style, $post_id ) {
            $post_meta = get_post_meta( $post_id, '_xoha_post_settings', TRUE );
            $post_meta = is_array( $post_meta ) ? $post_meta  : array();

            $post_style = !empty( $post_meta['single_post_style'] ) ? $post_meta['single_post_style'] : $post_style;

            return $post_style;
        }

        function load_post_image( $image, $post_id, $post_meta ) {
            if( array_key_exists( 'single_post_style', $post_meta ) && $post_meta['single_post_style'] == 'split' ) :
                $entry_bg = '';
                $url = get_the_post_thumbnail_url( $post_id, 'full' );
                $entry_bg = "style=background-image:url(".$url.")";

                return '<div class="split-full-img" '.esc_attr($entry_bg).'></div>';
            else:
                return $image;
            endif;
        }

        function enqueue_js_assets() {
            if( is_singular('post') ) {
                wp_enqueue_script( 'jquery-caroufredsel', XOHA_PRO_DIR_URL . 'modules/post/assets/js/jquery.caroufredsel.js', array(), XOHA_PRO_VERSION, true );
                wp_enqueue_script( 'jquery-waypoints', XOHA_PRO_DIR_URL . 'modules/post/assets/js/jquery.waypoints.min.js', array(), XOHA_PRO_VERSION, true );
                wp_enqueue_script( 'post-likes', XOHA_PRO_DIR_URL . 'modules/post/assets/js/post-likes.js', array(), XOHA_PRO_VERSION, true );
                wp_localize_script('post-likes', 'xoha_urls', array(
                    'ajaxurl' => esc_url( admin_url('admin-ajax.php') ),
                    'wpnonce' => wp_create_nonce('rating-nonce')
                ));
            }
        }

        function single_post_process_like() {

            $out = '';
            $postid = $_REQUEST['post_id'];
            $nonce = $_REQUEST['nonce'];
            $action = $_REQUEST['doaction'];
            $arr_pids = array();

            if ( wp_verify_nonce( $nonce, 'rating-nonce' ) && $postid > 0 ) {

                $post_meta = get_post_meta ( $postid, '_xoha_post_settings', TRUE );
                $post_meta = is_array ( $post_meta ) ? $post_meta : array ();

                $var_count = ($action == 'like') ? 'like_count' : 'unlike_count';

                if( isset( $_COOKIE['arr_pids'] ) ) {

                    // article voted already...
                    if( in_array( $postid, explode(',', $_COOKIE['arr_pids']) ) ) {
                        $out = esc_html__('Already', 'xoha-pro');
                    } else {
                        // article first vote...
                        $v = array_key_exists($var_count, $post_meta) ?  $post_meta[$var_count] : 0;
                        $v = $v + 1;
                        $post_meta[$var_count] = $v;
                        update_post_meta( $postid, '_xoha_post_settings', $post_meta );

                        $out = $v;

                        $arr_pids = explode(',', $_COOKIE['arr_pids']);
                        array_push( $arr_pids, $postid);
                        setcookie( "arr_pids", implode(',', $arr_pids ), time()+1314000, "/" );
                    }
                } else {
                    // site first vote...
                    $v = array_key_exists($var_count, $post_meta) ?  $post_meta[$var_count] : 0;
                    $v = $v + 1;
                    $post_meta[$var_count] = $v;
                    update_post_meta( $postid, '_xoha_post_settings', $post_meta );

                    $out = $v;

                    array_push( $arr_pids, $postid);
                    setcookie( "arr_pids", implode(',', $arr_pids ), time()+1314000, "/" );
                }
            } else {
                $out = esc_html__('Security check', 'xoha-pro');
            }

            echo xoha_html_output($out);

            wp_die();
        }

        function single_post_related_article( $post_id ) {
            echo xoha_get_template_part( 'post', 'templates/post-extra/related_article', '', array( 'post_ID' => $post_id ) );
        }
    }
}

XohaProPost::instance();