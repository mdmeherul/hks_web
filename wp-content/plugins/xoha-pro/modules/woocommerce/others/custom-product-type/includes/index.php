<?php


// Product Custom Type

if( ! function_exists( 'xoha_shop_woo_loop_product_custom_type' ) ) {

	function xoha_shop_woo_loop_product_custom_type($product_id) {

        $output = '';

        $product_show_custom_type = wc_get_loop_prop( 'product-show-custom-type' );
        $product_show_custom_type = ($product_show_custom_type == '' || (isset($product_show_custom_type) && $product_show_custom_type == 'true')) ? true : false;

        if( $product_show_custom_type ) {

            $settings = get_post_meta( $product_id, '_custom_product_type', true );

            if(isset($settings['custom-product-type']) && $settings['custom-product-type'] != '') {

                $woo_others_settings = xoha_woo_others()->woo_default_settings();
                $custom_product_types = explode(',', $woo_others_settings['custom_product_types']);

                if(isset($custom_product_types[$settings['custom-product-type']]) && !empty($custom_product_types[$settings['custom-product-type']])) {
                    $output .= '<div class="product-custom-type">';
                        $output .= '<span class="product-custom-type-label">'.$custom_product_types[$settings['custom-product-type']].'</span>';
                    $output .= '</div>';
                }
            }

        }

		echo xoha_html_output( $output );

    }

    add_action( 'xoha_woo_before_product_thumb_image', 'xoha_shop_woo_loop_product_custom_type', 10, 1 );

}