<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace XohaElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Xoha_Shop_Elementor_Others_Size_Guide_Widgets {

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

		$this->xoha_shop_load_cxoha_modules();

		add_action( 'xoha_shop_register_widget_styles', array( $this, 'xoha_shop_register_widget_styles' ), 10, 1 );
		add_action( 'xoha_shop_register_widget_scripts', array( $this, 'xoha_shop_register_widget_scripts' ), 10, 1 );

		add_action( 'xoha_shop_preview_styles', array( $this, 'xoha_shop_preview_styles') );

	}

	/**
	 * Init
	 */
	function xoha_shop_load_cxoha_modules() {

		require xoha_shop_others_size_guide()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets styles
	 */
	function xoha_shop_register_widget_styles( $suffix ) {

		wp_register_style( 'swiper',
			xoha_shop_others_size_guide()->module_dir_url() . 'assets/css/swiper.min'.$suffix.'.css',
			array()
		);

		wp_register_style( 'wdt-shop-size-guide',
			xoha_shop_others_size_guide()->module_dir_url() . 'assets/css/style'.$suffix.'.css',
			array()
		);

	}

	/**
	 * Register widgets scripts
	 */
	function xoha_shop_register_widget_scripts( $suffix ) {

		wp_register_script( 'jquery-swiper',
			xoha_shop_others_size_guide()->module_dir_url() . 'assets/js/swiper.min'.$suffix.'.js',
			array( 'jquery' ),
			false,
			true
		);

		wp_register_script( 'wdt-shop-size-guide',
			xoha_shop_others_size_guide()->module_dir_url() . 'assets/js/scripts'.$suffix.'.js',
			array( 'jquery' ),
			false,
			true
		);

	}

	/**
	 * Editor Preview Style
	 */
	function xoha_shop_preview_styles() {

		wp_enqueue_style( 'wdt-shop-size-guide' );

	}

}

Xoha_Shop_Elementor_Others_Size_Guide_Widgets::instance();