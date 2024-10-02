<?php

namespace XohaElementor\Widgets;
use XohaElementor\Widgets\Xoha_Shop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Xoha_Shop_Widget_Product_Summary_Extend extends Xoha_Shop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'xoha-pro' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => esc_html__( 'Share / Follow Type', 'xoha-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'xoha-pro'),
					'share'  => esc_html__('Share', 'xoha-pro'),
					'follow' => esc_html__('Follow', 'xoha-pro'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'xoha-pro' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => esc_html__( 'Social Icon Style', 'xoha-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'xoha-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'xoha-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'xoha-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'xoha-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'xoha-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'xoha-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => esc_html__( 'Social Icon Radius', 'xoha-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'xoha-pro' ),
					'rounded' => esc_html__( 'Rounded', 'xoha-pro' ),
					'circle'  => esc_html__( 'Circle', 'xoha-pro' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => esc_html__( 'Social Icon Inline Alignment', 'xoha-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'xoha-pro' ),
				'label_off'    => esc_html__( 'no', 'xoha-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'xoha-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}