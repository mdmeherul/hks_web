<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'xoha_shop_woo_single_summary_options_cxoha_render' ) ) {
	function xoha_shop_woo_single_summary_options_cxoha_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'xoha-pro');
		return $options;

	}
	add_filter( 'xoha_shop_woo_single_summary_options', 'xoha_shop_woo_single_summary_options_cxoha_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'xoha_shop_woo_single_summary_styles_cxoha_render' ) ) {
	function xoha_shop_woo_single_summary_styles_cxoha_render( $styles ) {

		array_push( $styles, 'wdt-shop-coundown-timer' );
		return $styles;

	}
	add_filter( 'xoha_shop_woo_single_summary_styles', 'xoha_shop_woo_single_summary_styles_cxoha_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'xoha_shop_woo_single_summary_scripts_cxoha_render' ) ) {
	function xoha_shop_woo_single_summary_scripts_cxoha_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'wdt-shop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'xoha_shop_woo_single_summary_scripts', 'xoha_shop_woo_single_summary_scripts_cxoha_render', 10, 1 );

}