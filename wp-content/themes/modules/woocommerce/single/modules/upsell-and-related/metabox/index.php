<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Xoha_Shop_Metabox_Single_Upsell_Related' ) ) {
    class Xoha_Shop_Metabox_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

			add_filter( 'xoha_shop_product_custom_settings', array( $this, 'xoha_shop_product_custom_settings' ), 10 );

		}

        function xoha_shop_product_custom_settings( $options ) {

			$ct_dependency      = array ();
			$upsell_dependency  = array ( 'show-upsell', '==', 'true');
			$related_dependency = array ( 'show-related', '==', 'true');
			if( function_exists('xoha_shop_single_module_custom_template') ) {
				$ct_dependency['dependency'] 	= array ( 'product-template', '!=', 'custom-template');
				$upsell_dependency 				= array ( 'product-template|show-upsell', '!=|==', 'custom-template|true');
				$related_dependency 			= array ( 'product-template|show-related', '!=|==', 'custom-template|true');
			}

			$product_options = array (

				array_merge (
					array(
						'id'         => 'show-upsell',
						'type'       => 'select',
						'title'      => esc_html__('Show Upsell Products', 'xoha'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-upsell' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'xoha' ),
							'true'         => esc_html__( 'Show', 'xoha'),
							null           => esc_html__( 'Hide', 'xoha'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'upsell-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Column', 'xoha'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'xoha' ),
						1              => esc_html__( 'One Column', 'xoha' ),
						2              => esc_html__( 'Two Columns', 'xoha' ),
						3              => esc_html__( 'Three Columns', 'xoha' ),
						4              => esc_html__( 'Four Columns', 'xoha' ),
					),
					'dependency' => $upsell_dependency
				),

				array(
					'id'         => 'upsell-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Limit', 'xoha'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'xoha' ),
						1              => esc_html__( 'One', 'xoha' ),
						2              => esc_html__( 'Two', 'xoha' ),
						3              => esc_html__( 'Three', 'xoha' ),
						4              => esc_html__( 'Four', 'xoha' ),
						5              => esc_html__( 'Five', 'xoha' ),
						6              => esc_html__( 'Six', 'xoha' ),
						7              => esc_html__( 'Seven', 'xoha' ),
						8              => esc_html__( 'Eight', 'xoha' ),
						9              => esc_html__( 'Nine', 'xoha' ),
						10              => esc_html__( 'Ten', 'xoha' ),
					),
					'dependency' => $upsell_dependency
				),

				array_merge (
					array(
						'id'         => 'show-related',
						'type'       => 'select',
						'title'      => esc_html__('Show Related Products', 'xoha'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-related' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'xoha' ),
							'true'         => esc_html__( 'Show', 'xoha'),
							null           => esc_html__( 'Hide', 'xoha'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'related-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Column', 'xoha'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'xoha' ),
						2              => esc_html__( 'Two Columns', 'xoha' ),
						3              => esc_html__( 'Three Columns', 'xoha' ),
						4              => esc_html__( 'Four Columns', 'xoha' ),
					),
					'dependency' => $related_dependency
				),

				array(
					'id'         => 'related-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Limit', 'xoha'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'xoha' ),
						1              => esc_html__( 'One', 'xoha' ),
						2              => esc_html__( 'Two', 'xoha' ),
						3              => esc_html__( 'Three', 'xoha' ),
						4              => esc_html__( 'Four', 'xoha' ),
						5              => esc_html__( 'Five', 'xoha' ),
						6              => esc_html__( 'Six', 'xoha' ),
						7              => esc_html__( 'Seven', 'xoha' ),
						8              => esc_html__( 'Eight', 'xoha' ),
						9              => esc_html__( 'Nine', 'xoha' ),
						10              => esc_html__( 'Ten', 'xoha' ),
					),
					'dependency' => $related_dependency
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Xoha_Shop_Metabox_Single_Upsell_Related::instance();