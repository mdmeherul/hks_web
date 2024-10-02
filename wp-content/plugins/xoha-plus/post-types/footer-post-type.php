<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'XohaPlusFooterPostType' ) ) {

	class XohaPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'xoha_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'xoha_template_include' ) );
		}

		function xoha_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'xoha-plus' ),
				'singular_name'		 => __( 'Footer', 'xoha-plus' ),
				'menu_name'			 => __( 'Footers', 'xoha-plus' ),
				'add_new'			 => __( 'Add Footer', 'xoha-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'xoha-plus' ),
				'edit'				 => __( 'Edit Footer', 'xoha-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'xoha-plus' ),
				'new_item'			 => __( 'New Footer', 'xoha-plus' ),
				'view'				 => __( 'View Footer', 'xoha-plus' ),
				'view_item' 		 => __( 'View Footer', 'xoha-plus' ),
				'search_items' 		 => __( 'Search Footers', 'xoha-plus' ),
				'not_found' 		 => __( 'No Footers found', 'xoha-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'xoha-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function xoha_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = XOHA_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

XohaPlusFooterPostType::instance();