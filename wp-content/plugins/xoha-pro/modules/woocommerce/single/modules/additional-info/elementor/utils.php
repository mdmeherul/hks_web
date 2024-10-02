<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'xoha_shop_woo_single_summary_options_ai_render' ) ) {
	function xoha_shop_woo_single_summary_options_ai_render( $options ) {

		$options['additional_info']                   = esc_html__('Summary Additional Info', 'xoha-pro');
		$options['additional_info_delivery_period']   = esc_html__('Summary Additional Info - Delivery Period', 'xoha-pro');
		$options['additional_info_realtime_visitors'] = esc_html__('Summary Additional Info - Real Time Visitors', 'xoha-pro');
		$options['additional_info_shipping_offer']    = esc_html__('Summary Additional Info - Shipping Offer', 'xoha-pro');
		return $options;

	}
	add_filter( 'xoha_shop_woo_single_summary_options', 'xoha_shop_woo_single_summary_options_ai_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'xoha_shop_woo_single_summary_styles_ai_render' ) ) {
	function xoha_shop_woo_single_summary_styles_ai_render( $styles ) {

		array_push( $styles, 'wdt-shop-additional-info' );
		return $styles;

	}
	add_filter( 'xoha_shop_woo_single_summary_styles', 'xoha_shop_woo_single_summary_styles_ai_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'xoha_shop_woo_single_summary_scripts_ai_render' ) ) {
	function xoha_shop_woo_single_summary_scripts_ai_render( $scripts ) {

		array_push( $scripts, 'wdt-shop-additional-info' );
		return $scripts;

	}
	add_filter( 'xoha_shop_woo_single_summary_scripts', 'xoha_shop_woo_single_summary_scripts_ai_render', 10, 1 );

}