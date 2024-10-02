<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace XohaElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Xoha_Shop_Elementor_Single_Social_Widgets {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	function __construct() {

		$this->xoha_shop_load_modules();

		add_action( 'xoha_shop_register_widgets', array( $this, 'xoha_shop_register_widgets' ), 20, 1 );

		add_action( 'xoha_shop_register_widget_styles', array( $this, 'xoha_shop_register_widget_styles' ), 10, 1 );

		add_action( 'xoha_shop_preview_styles', array( $this, 'xoha_shop_preview_styles') );

	}

	/**
	 * Init
	 */
	function xoha_shop_load_modules() {

		require xoha_shop_single_module_social_share_and_follow()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets
	 */
	function xoha_shop_register_widgets( $widgets_manager ) {

		require xoha_shop_single_module_social_share_and_follow()->module_dir_path() . 'elementor/widgets/index.php';
		$widgets_manager->register( new Xoha_Shop_Widget_Product_Summary_Extend() );

	}

	/**
	 * Register widgets styles
	 */
	function xoha_shop_register_widget_styles( $suffix ) {

		# Social Sahre & Follow

			wp_register_style( 'wdt-shop-social-share-and-follow',
				xoha_shop_single_module_social_share_and_follow()->module_dir_url() . 'elementor/widgets/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Editor Preview Style
	 */
	function xoha_shop_preview_styles() {

		# Social Sahre & Follow
			wp_enqueue_style( 'wdt-shop-social-share-and-follow' );

	}

}

Xoha_Shop_Elementor_Single_Social_Widgets::instance();