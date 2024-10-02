<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Text_Link {

	private static $_instance = null;

	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Initialize depandant class
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-text-link';
	}

	public function title() {
		return esc_html__( 'Text Link', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/text-link/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function create_elementor_controls($elementor_object) {

		$elementor_object->start_controls_section( 'wdt_section_content', array(
			'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
		));

		$elementor_object->add_control( 'title', array(
				'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => array(
					'active' => true,
				),
				'placeholder' => esc_html__( 'Enter your title', 'wdt-elementor-addon' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'wdt-elementor-addon' ),
		) );

		$elementor_object->add_control( 'link',array(
			'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' ),
			'default'     => array( 'url' => '#' ),
		) );

		$elementor_object->add_control( 'title_tag', array(
			'label'   => esc_html__( 'Title Tag', 'wdt-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => array(
				'div'  => esc_html__( 'Div', 'wdt-elementor-addon' ),
				'h1'   => esc_html__( 'H1', 'wdt-elementor-addon' ),
				'h2'   => esc_html__( 'H2', 'wdt-elementor-addon' ),
				'h3'   => esc_html__( 'H3', 'wdt-elementor-addon' ),
				'h4'   => esc_html__( 'H4', 'wdt-elementor-addon' ),
				'h5'   => esc_html__( 'H5', 'wdt-elementor-addon' ),
				'h6'   => esc_html__( 'H6', 'wdt-elementor-addon' ),
				'span' => esc_html__( 'Span', 'wdt-elementor-addon' ),
				'p'    => esc_html__( 'P', 'wdt-elementor-addon' )
			)
		));
		
		$elementor_object->add_responsive_control(
			'align',
			array(
				'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
						'icon' => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
						'icon' => 'eicon-text-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
						'icon' => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justified', 'wdt-elementor-addon' ),
						'icon' => 'eicon-text-align-justify',
					),
				),
				'default' => '',
				'selectors' => array(
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				),
		) );

		$elementor_object->end_controls_section();


		// Styles

			// Item
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'item',
					'title' => esc_html__( 'Item', 'wdt-elementor-addon' ),
					'styles' => array (
						'alignment' => array (
							'field_type' => 'alignment',
							'default' => 'center',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder, {{WRAPPER}} .wdt-heading-holder > .wdt-heading-separator-wrapper .wdt-heading-separator, {{WRAPPER}} .wdt-heading-holder > .wdt-heading-title-wrapper .wdt-heading-title, {{WRAPPER}} .wdt-heading-holder > .wdt-heading-subtitle-wrapper .wdt-heading-subtitle' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder',
							'condition' => array ()
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder',
							'condition' => array ()
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'box_shadow' => array (
							'field_type' => 'box_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder',
							'condition' => array ()
						)
					)
				));

			// Title
				$this->cc_style->get_style_controls($elementor_object, array (
					'slug' => 'title',
					'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'styles' => array (
						'vertical_align' => array (
							'field_type' => 'vertical_align',
							'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
							'options' => array (
								'start' => array (
									'title' => esc_html__( 'Start', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-top',
								),
								'center' => array (
									'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-middle',
								),
								'end' => array (
									'title' => esc_html__( 'End', 'wdt-elementor-addon' ),
									'icon' => 'eicon-v-align-bottom',
								)
							),
							'default' => 'center',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'align-items: {{VALUE}};'
							),
							'condition' => array ()
						),
						'margin' => array (
							'field_type' => 'margin',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'padding' => array (
							'field_type' => 'padding',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'typography' => array (
							'field_type' => 'typography',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						),
						'color' => array (
							'field_type' => 'color',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'color: {{VALUE}};'
							),
							'condition' => array ()
						),
						'background' => array (
							'field_type' => 'background',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						),
						'border' => array (
							'field_type' => 'border',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						),
						'border_radius' => array (
							'field_type' => 'border_radius',
							'selector' => array (
								'{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
							'condition' => array ()
						),
						'box_shadow' => array (
							'field_type' => 'box_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						),
						'text_shadow' => array (
							'field_type' => 'text_shadow',
							'selector' => '{{WRAPPER}} .wdt-heading-holder .wdt-heading-title-wrapper .wdt-heading-title',
							'condition' => array ()
						)
					)
				));
	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if( !empty( $settings['link']['url'] ) ){
			$target = ( $settings['link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
			$nofollow = ( $settings['link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';

			$title = ( isset( $settings['title'] ) && ( !empty( $settings['title'] ) ) ) ? $settings['title'] : '';

			$output .= '<'.esc_attr($settings['title_tag']).' class="wdt-text-link-title-wrapper">';
				$output .= '<a href="'.esc_url( $settings['link']['url'] ).'"'. $target . $nofollow.'>' . esc_html( $title ) . ' <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1200 60" style="enable-background:new 0 0 1200 60;" xml:space="preserve"> <path d="M0,56.5c0,0,298.7,0,399.3,0C448.3,56.5,514,46,597,46c77.3,0,135,10.5,201,10.5c96,0,402,0,402,0"/></svg> </a>';
			$output .= '</'.esc_attr($settings['title_tag']).'>';
		}

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_text_link' ) ) {
    function wedesigntech_widget_base_text_link() {
		return WeDesignTech_Widget_Base_Text_Link::instance();
    }
}