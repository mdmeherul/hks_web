<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WDTPortfolioDfListingsListing extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-default-widgets' ];
	}

	public function get_name() {
		return 'wdt-widget-df-listings-listing';
	}

	public function get_title() {
		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		return sprintf( esc_html__('%1$s Listing','wdt-portfolio'), $listing_plural_label );
	}

	public function get_style_depends() {
		return array ( 'swiper', 'wdt-modules-listing', 'wdt-modules-default', 'magnific-popup' );
	}

	public function get_script_depends() {
		return array ( 'swiper', 'wdt-frontend', 'jquery-cookies', 'jquery-magnific-popup' );
	}

	public function wdt_dynamic_register_controls() {
	}

	protected function register_controls() {

		$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
		$amenity_singular_label      = apply_filters( 'amenity_label', 'singular' );
		$amenity_plural_label        = apply_filters( 'amenity_label', 'plural' );

		$this->start_controls_section( 'listings_listing_default_section', array(
			'label' => esc_html__( 'General','wdt-portfolio'),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1'  => esc_html__('Type 1','wdt-portfolio'),
					'type2'  => esc_html__('Type 2','wdt-portfolio'),
					'type3'  => esc_html__('Type 3','wdt-portfolio'),
					'type4'  => esc_html__('Type 4','wdt-portfolio'),
					'type5'  => esc_html__('Type 5','wdt-portfolio'),
					'type6'  => esc_html__('Type 6','wdt-portfolio')
				),
				'description' => esc_html__('Choose type of layout you like to display.','wdt-portfolio'),
				'default'      => 'type1',
			) );

			$this->add_control( 'show_image_popup', array(
				'label'   => esc_html__('Show Gallery in Image Popup','wdt-portfolio'),
				'type'    => Controls_Manager::SELECT,
				'options'   => array(
					'no' 	=> esc_html__('No','wdt-portfolio'),
					'yes'  	=> esc_html__('Yes','wdt-portfolio'),
				),
				'condition' => array( 'type' => 'type6' ),
				'default'   => 'no'
			) );

			$this->add_control( 'post_per_page', array(
				'label'   => esc_html__( 'Post Per Page','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Number of posts to show per page. Rest of the posts will be displayed in pagination.','wdt-portfolio'),
				'default' => 4
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column','wdt-portfolio'),
					2  => esc_html__('II Columns','wdt-portfolio'),
					3  => esc_html__('III Columns','wdt-portfolio'),
					4  => esc_html__('IV Columns','wdt-portfolio')
				),
				'description' => esc_html__( 'Number of columns you like to display your items.','wdt-portfolio'),
				'condition'   => array( 'type' => array( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type10') ),
				'default'      => 1,
			) );

			$this->add_control( 'apply_isotope', array(
				'label'       => esc_html__( 'Apply Isotope','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__('Choose true if you like to apply isotope for your items.  Isotope won\'t work along with Carousel.','wdt-portfolio'),
				'default'      => 'true'
			) );

			$this->add_control( 'isotope_filter', array(
				'label'       => esc_html__( 'Isotope Filter','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''             => esc_html__( 'None','wdt-portfolio'),
					'category'     => esc_html__( 'Category','wdt-portfolio')
				),
				'condition'   => array( 'apply_isotope' => 'true' ),
				'description' => esc_html__('Choose isotope filter you like to use.','wdt-portfolio'),
				'default'      => ''
			) );

			$this->add_control( 'apply_child_of', array(
				'label'       => esc_html__( 'Apply Child Of','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'condition'   => array( 'apply_isotope' => 'true' ),
				'description' => esc_html__('If you wish to apply child of specified categories in filters, choose "True". If no categories specified in "Filter Options" this option won\'t work.','wdt-portfolio'),
				'default'      => 'false'
			) );

			$this->add_control( 'featured_items', array(
				'label'       => esc_html__( 'Featured Items','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__('Choose true if you like to display featured items.','wdt-portfolio'),
				'default'      => 'false'
			) );

			$this->add_control( 'excerpt_length', array(
				'label'   => esc_html__( 'Excerpt Length','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide excerpt length here.','wdt-portfolio'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type7', 'type8', 'type9', 'type10' ) ),
				'default' => 20
			) );

			$this->add_control( 'features_image_or_icon', array(
				'label'       => esc_html__( 'Features Image or Icon','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__('None','wdt-portfolio'),
					'image' => esc_html__('Image','wdt-portfolio'),
					'icon'  => esc_html__('Icon','wdt-portfolio')
				),
				'description' => esc_html__('Choose any of the option available to display features.','wdt-portfolio'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' ) ),
				'default'      => '',
			) );

			$this->add_control( 'features_include', array(
				'label'       => esc_html__( 'Features Include','wdt-portfolio'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.','wdt-portfolio'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' ) ),
				'default'      => '',
			) );

			$this->add_control( 'no_of_cat_to_display', array(
				'label'       => esc_html__( 'No. Of Categories to Display','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					0  => 0,
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4
				),
				'description' => esc_html__( 'Number of categories you like to display on your items.','wdt-portfolio'),
				'default'      => 2,
			) );

			$this->add_control( 'apply_equal_height', array(
				'label'       => esc_html__( 'Apply Equal Height','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'condition'   => array( 'apply_isotope' => 'false' ),
				'description' => esc_html__('Apply equal height for you items.','wdt-portfolio'),
				'default'      => 'false'
			) );

			$this->add_control( 'apply_custom_height', array(
				'label'       => esc_html__( 'Apply Custom Height','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__('Apply custom height for your entire section.','wdt-portfolio'),
				'default'      => 'false'
			) );

			$this->add_responsive_control( 'height', array(
                'label' => esc_html__( 'Height','wdt-portfolio'),
                'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide height for your section in "px" here.','wdt-portfolio'),
				'condition'   => array( 'apply_custom_height' => 'true' ),
                'devices' => array( 'desktop', 'tablet', 'mobile' ),
                'selectors' => array(
					'{{WRAPPER}} .wdt-listing-output-data-container' => 'height: {{SIZE}}px;',
				),
			) );

			$this->add_control( 'sidebar_widget', array(
				'label'       => esc_html__( 'Sidebar Widget','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => sprintf( esc_html__('%1$s 1) If you wish to show these items in sidebar set this to "True". %2$s %1$s 2) This options is not applicable for "Type 3", "Type 5" and "Type 7". %2$s','wdt-portfolio'), '<p>', '</p>' ),
				'default'      => 'false'
			) );

            $this->add_control( 'pagination_type', array(
				'label'       => esc_html__( 'Pagination Type','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''        => esc_html__('None','wdt-portfolio'),
					'numbered' => esc_html__('Numbered','wdt-portfolio'),
					'loadmore' => esc_html__('Load More','wdt-portfolio'),
					'infinity' => esc_html__('Infinity','wdt-portfolio')
				),
				'default'      => '',
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','wdt-portfolio'),
				'default' => ''
			) );

		$this->end_controls_section();

		$this->wdt_dynamic_register_controls();

		$this->start_controls_section( 'listings_listing_filter_section', array(
			'label' => esc_html__( 'Filter Options','wdt-portfolio'),
		) );

			$this->add_control( 'list_item_ids', array(
				'label'   => sprintf( esc_html__('%1$s Item Ids','wdt-portfolio'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item ids separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'category_ids', array(
				'label'   => sprintf( esc_html__('%1$s Category Ids','wdt-portfolio'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s category ids separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'tag_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s','wdt-portfolio'), $listing_singular_label, $amenity_plural_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas','wdt-portfolio'), $amenity_plural_label ),
				'default' => ''
			) );

		$this->end_controls_section();

		$this->start_controls_section( 'listings_listing_masonary_section', array(
			'label' => esc_html__( 'Masonary Options','wdt-portfolio'),
		) );

			$this->add_control( 'masonary_one_items', array(
				'label'   => esc_html__('One Column Items','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item positions separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'masonary_one_half_items', array(
				'label'   => esc_html__('One Half Column Items','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item positions separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'masonary_one_third_items', array(
				'label'   => esc_html__('One Third Column Items','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item positions separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'masonary_two_third_items', array(
				'label'   => esc_html__('Two Third Column Items','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item positions separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'masonary_one_fourth_items', array(
				'label'   => esc_html__('One Fourth Column Items','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item positions separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'masonary_three_fourth_items', array(
				'label'   => esc_html__('Three Fourth Column Items','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item positions separated by commas.','wdt-portfolio'), $listing_singular_label ),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'listings_listing_carousel_section', array(
			'label' => esc_html__( 'Carousel Options','wdt-portfolio'),
		) );

			$this->add_control( 'enable_carousel', array(
				'label'       => esc_html__( 'Enable Carousel','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'If you wish you can enable carousel for your item listings. Carousel won\'t work along with "Isotope" & "Equal Height" option.','wdt-portfolio'),
				'condition'   => array( 'apply_isotope' => 'false' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('Default','wdt-portfolio'),
					'fade'  => esc_html__('Fade','wdt-portfolio'),
				),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.','wdt-portfolio'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => ''
			) );

			$this->add_control( 'carousel_autoplay', array(
				'label'   => esc_html__( 'Auto Play','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.','wdt-portfolio'),
				'condition'   => array( 'enable_carousel' => 'true' ),
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
				'description' => sprintf( esc_html__('%1$s 1) Number slides of to show in view port. %2$s %1$s 2) 2,3,4 options not applicable for "type 3", "type 5", "type 7" and "type9". %2$s %1$s 3) If "Sidebar Widget" is set to "True", than "Slides Per View" will be set to "1". %2$s','wdt-portfolio'), '<p>', '</p>' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 2
			) );

			$this->add_control( 'carousel_loopmode', array(
				'label'       => esc_html__( 'Enable Loop Mode','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.','wdt-portfolio'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'       => esc_html__( 'Enable Mousewheel Control','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.','wdt-portfolio'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'       => esc_html__('Enable Bullet Pagination','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'To enable bullet pagination.','wdt-portfolio'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'       => esc_html__( 'Enable Arrow Pagination','wdt-portfolio'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','wdt-portfolio'),
					'true'  => esc_html__('True','wdt-portfolio'),
				),
				'description' => esc_html__( 'To enable arrow pagination.','wdt-portfolio'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'   => esc_html__( 'Space Between Sliders','wdt-portfolio'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.','wdt-portfolio'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default' => 30
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = wdtportfolio_elementor_instance()->wdt_parse_shortcode_attrs( $settings );
		echo do_shortcode('[wdt_listings_listing '.$attributes.' /]');
	}

}