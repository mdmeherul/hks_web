<?php

/*
 * Cross Sell Product Listing
 */

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

if( ! function_exists( 'xoha_shop_cross_sell_display' ) ) {

	function xoha_shop_cross_sell_display() {

		$settings = xoha_woo_others()->woo_default_settings();
		extract($settings);

		xoha_shop_others_cart()->woo_load_listing( $cross_sell_style_template, $cross_sell_style_custom_template );

		$product_display_type = wc_get_loop_prop( 'product-display-type', 'grid' );
		if($product_display_type == 'list') {
			$cross_sell_column = 1;
		}

		wc_set_loop_prop( 'columns', $cross_sell_column);

		woocommerce_cross_sell_display( $limit = $cross_sell_column, $columns = $cross_sell_column, $orderby = 'rand', $order = 'desc' );

		xoha_shop_cross_sell_product_style_reset_loop_prop();  /* Reset Product Style Variables Setup */

	}

	add_action( 'woocommerce_cart_collaterals', 'xoha_shop_cross_sell_display', 15 );

}


/*
 * Reset Loop Prop
 */

if( ! function_exists( 'xoha_shop_cross_sell_product_style_reset_loop_prop' ) ) {

	function xoha_shop_cross_sell_product_style_reset_loop_prop() {

		$xoha_shop_loop_prop = wc_get_loop_prop('wdt-shop-loop-prop', array ());

		if( is_array($xoha_shop_loop_prop) && !empty($xoha_shop_loop_prop) ) {
			foreach( $xoha_shop_loop_prop as $loop_prop ) {
				unset($GLOBALS['woocommerce_loop'][$loop_prop]);
			}
		}

		unset($GLOBALS['woocommerce_loop']['columns']);
		unset($GLOBALS['woocommerce_loop']['wdt-shop-loop-prop']);

	}

}


/*
 * Cross Sell Heading
 */

if( ! function_exists( 'xoha_shop_cross_sells_products_heading' ) ) {

	function xoha_shop_cross_sells_products_heading($heading) {

        if( !function_exists( 'xoha_pro' ) ) {
            return $heading; // If Theme-Plugin is not activated
        }

		$title = xoha_customizer_settings( 'wdt-woo-cross-sell-title' );
		$heading = ( isset($title) && !empty($title) ) ? $title : $heading;

		return $heading;

	}

	add_filter( 'woocommerce_product_cross_sells_products_heading', 'xoha_shop_cross_sells_products_heading', 1 );

}