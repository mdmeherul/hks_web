<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'XohaPlusHeaderPostType' ) ) {

	class XohaPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'xoha_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'xoha_template_include' ) );
		}

		function xoha_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'xoha-plus' ),
				'singular_name'		 => __( 'Header', 'xoha-plus' ),
				'menu_name'			 => __( 'Headers', 'xoha-plus' ),
				'add_new'			 => __( 'Add Header', 'xoha-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'xoha-plus' ),
				'edit'				 => __( 'Edit Header', 'xoha-plus' ),
				'edit_item'			 => __( 'Edit Header', 'xoha-plus' ),
				'new_item'			 => __( 'New Header', 'xoha-plus' ),
				'view'				 => __( 'View Header', 'xoha-plus' ),
				'view_item' 		 => __( 'View Header', 'xoha-plus' ),
				'search_items' 		 => __( 'Search Headers', 'xoha-plus' ),
				'not_found' 		 => __( 'No Headers found', 'xoha-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'xoha-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function xoha_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = XOHA_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

XohaPlusHeaderPostType::instance();