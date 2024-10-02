<?php
add_action( 'xoha_after_main_css', 'post_style' );
function post_style() {
    if( is_singular('post') || is_attachment() ) {
        wp_enqueue_style( 'xoha-post', get_theme_file_uri('/modules/post/assets/css/post.css'), false, XOHA_THEME_VERSION, 'all');

        $post_style = xoha_get_single_post_style( get_the_ID() );
        wp_enqueue_style( 'xoha-post-'.$post_style, get_theme_file_uri('/modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css'), false, XOHA_THEME_VERSION, 'all');
    }
}

if( !function_exists('xoha_get_single_post_style') ) {
	function xoha_get_single_post_style( $post_id ) {
		return apply_filters( 'xoha_single_post_style', 'minimal', $post_id );
	}
}

if( !function_exists('xoha_single_post_params') ) {
    function xoha_single_post_params() {
        $params = array(
            'enable_title'   		 => 0,
            'enable_image_lightbox'  => 0,
            'enable_disqus_comments' => 0,
            'post_disqus_shortname'  => '',
            'post_dynamic_elements'  => array( 'content', 'comment_box', 'navigation', 'related_posts' ),
            'post_commentlist_style' => 'rounded'
        );

        return apply_filters( 'xoha_single_post_params', $params );
    }
}

add_action( 'xoha_after_main_css', 'xoha_single_post_enqueue_css' );
if( !function_exists( 'xoha_single_post_enqueue_css' ) ) {
    function xoha_single_post_enqueue_css() {

        wp_enqueue_style( 'xoha-magnific-popup', get_theme_file_uri('/modules/post/assets/css/magnific-popup.css'), false, XOHA_THEME_VERSION, 'all');
    }
}

add_action( 'xoha_before_enqueue_js', 'xoha_single_post_enqueue_js' );
if( !function_exists( 'xoha_single_post_enqueue_js' ) ) {
    function xoha_single_post_enqueue_js() {

        wp_enqueue_script('jquery-magnific-popup', get_theme_file_uri('/modules/post/assets/js/jquery.magnific-popup.js'), array(), false, true);
    }
}

add_filter('post_class', 'xoha_single_set_post_class', 10, 3);
if( !function_exists('xoha_single_set_post_class') ) {
    function xoha_single_set_post_class( $classes, $class, $post_id ) {

        if( is_singular('post') || is_attachment() ) {
        	$classes[] = 'blog-single-entry';
        	$classes[] = 'post-'.xoha_get_single_post_style( $post_id );
        }

        return $classes;
    }
}