<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WDTPortfolioSpMediaImages extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-singlepage-widgets' ];
	}

	public function get_name() {
		return 'wdt-widget-sp-media-images';
	}

	public function get_title() {
		return esc_html__( 'Media - Images','wdt-portfolio');
	}

	public function get_style_depends() {
		return array ('wdt-media-images-frontend');
	}

	public function get_script_depends() {
		return array ('wdt-media-images-frontend');
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'media_images_default_section', array(
			'label' => esc_html__( 'General','wdt-portfolio'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','wdt-portfolio'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','wdt-portfolio'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'image_size', array(
				'label'       => esc_html__( 'Thumbnail Sizes','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'thumbnail'    => esc_html__('Thumbnail','wdt-portfolio'),
					'medium'       => esc_html__('Medium','wdt-portfolio'),
					'medium_large' => esc_html__('Medium Large','wdt-portfolio'),
					'large'        => esc_html__('Large','wdt-portfolio'),
					'full'         => esc_html__('Full','wdt-portfolio'),
				),
				'description' => esc_html__( 'Choose any of the above image sizes.','wdt-portfolio'),
				'default'      => 'full',
			) );

			$this->add_control( 'show_image_description', array(
				'label'       => esc_html__( 'Show Image Description','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__('Choose "True" if you like to show image description in carousel.','wdt-portfolio'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_featured_image', array(
				'label'       => esc_html__( 'Include Feature Image','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__('Choose "True" if you like to include featured image in this gallery.','wdt-portfolio'),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'       => esc_html__( 'Class','wdt-portfolio'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','wdt-portfolio'),
				'default'     => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'media_images_carousel_section', array(
			'label' => esc_html__( 'Carousel Options','wdt-portfolio'),
		) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('Default','wdt-portfolio'),
					'fade'  => esc_html__('Fade','wdt-portfolio'),
				),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.','wdt-portfolio'),
				'default'      => ''
			) );

			$this->add_control( 'carousel_autoplay', array(
				'label'   => esc_html__( 'Auto Play','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.','wdt-portfolio'),
				'default' => ''
			) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				),
				'description' => esc_html__( 'Number slides of to show in view port.','wdt-portfolio'),
				'default'      => 2
			) );

			$this->add_control( 'carousel_loopmode', array(
				'label'   => esc_html__( 'Enable Loop Mode','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.','wdt-portfolio'),
				'default'     => 'false'
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'   => esc_html__( 'Enable Mousewheel Control','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.','wdt-portfolio'),
				'default'     => 'false'
			) );

			$this->add_control( 'carousel_verticaldirection', array(
				'label'   => esc_html__('Enable Vertical Direction','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'To make your slides to navigate vertically.','wdt-portfolio'),
				'default'     => 'false'
			) );

			$this->add_control( 'carousel_paginationtype', array(
				'label'   => esc_html__( 'Pagination Type','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''            => esc_html__('None','wdt-portfolio'),
					'bullets'     => esc_html__('Bullets','wdt-portfolio'),
					'fraction'    => esc_html__('Fraction','wdt-portfolio'),
					'progressbar' => esc_html__('Progress Bar','wdt-portfolio'),
					'scrollbar'   => esc_html__('Scroll Bar','wdt-portfolio'),
					'thumbnail'   => esc_html__('Thumbnail','wdt-portfolio')
				),
				'description' => esc_html__( 'Choose pagination type you like to use.','wdt-portfolio'),
				'default'      => ''
			) );

			$this->add_control( 'carousel_numberofthumbnails', array(
				'label'   => esc_html__('Number of Thumbnails','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				),
				'description' => esc_html__( 'Number of thumbnails to show.','wdt-portfolio'),
				'condition'   => array( 'carousel_paginationtype' => 'thumbnail' ),
				'default'     => 3
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'   => esc_html__( 'Enable Arrow Pagination','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'To enable arrow pagination.','wdt-portfolio'),
				'default'     => 'false'
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'   => esc_html__( 'Arrow Type','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'type1' => esc_html__('Type 1','wdt-portfolio'),
					'type2' => esc_html__('Type 2','wdt-portfolio'),
					'type3' => esc_html__('Type 3','wdt-portfolio')
				),
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.','wdt-portfolio'),
				'default'     => 'type1'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'       => esc_html__( 'Space Between Sliders','wdt-portfolio'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.','wdt-portfolio'),
				'default'     => ''
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = wdtportfolio_elementor_instance()->wdt_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[wdt_sp_media_images '.$attributes.' /]');

		echo $output;

	}

}