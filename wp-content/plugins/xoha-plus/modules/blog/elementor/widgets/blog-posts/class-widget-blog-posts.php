<?php
use XohaElementor\Widgets\XohaElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Blog_Posts extends XohaElementorWidgetBase {

    public function get_name() {
        return 'wdt-blog-posts';
    }

    public function get_title() {
        return esc_html__('Blog Posts', 'xoha-plus');
    }

    public function get_icon() {
		return 'eicon-posts-grid wdt-icon';
	}

	public function get_style_depends() {
		return array( 'swiper', 'wdt-blogcarousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'wdt-blogcarousel' );
	}

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'xoha-plus'),
        ) );

            $this->add_control( 'query_posts_by', array(
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('Query posts by', 'xoha-plus'),
                'default' => 'category',
                'options' => array(
                    'category'  => esc_html__('From Category (for Posts only)', 'xoha-plus'),
                    'ids'       => esc_html__('By Specific IDs', 'xoha-plus'),
                )
            ) );

            $this->add_control( '_post_categories', array(
                'label'       => esc_html__( 'Categories', 'xoha-plus' ),
                'type'        => Controls_Manager:: SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $this->xoha_post_categories(),
                'condition'   => array( 'query_posts_by' => 'category' )
            ) );

            $this->add_control( '_post_ids', array(
                'label'       => esc_html__( 'Select Specific Posts', 'xoha-plus' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $this->xoha_post_ids(),
                'condition' => array( 'query_posts_by' => 'ids' )
            ) );

            $this->add_control( 'count', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Post Counts', 'xoha-plus'),
                'default'     => '5',
                'placeholder' => esc_html__( 'Enter post count', 'xoha-plus' ),
            ) );

            $this->add_control( 'blog_post_layout', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Layout', 'xoha-plus'),
                'default' => 'entry-grid',
                'options' => array(
                    'entry-grid'  => esc_html__('Grid', 'xoha-plus'),
                    'entry-list'  => esc_html__('List', 'xoha-plus'),
                    'entry-cover' => esc_html__('Cover', 'xoha-plus'),
                )
            ) );

            $this->add_control( 'blog_post_grid_list_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Style', 'xoha-plus'),
                'default' => 'wdt-classic',
                'options' => apply_filters( 'blog_post_grid_list_style_update', array(
                    'wdt-classic' => esc_html__('Classic', 'xoha-plus'),
                )),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_post_cover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Style', 'xoha-plus'),
                'default' => 'wdt-classic',
                'options' => apply_filters('blog_post_cover_style_update', array(
                    'wdt-classic' => esc_html__('Classic', 'xoha-plus')
                )),
                'condition' => array( 'blog_post_layout' => 'entry-cover' )
            ) );

            $this->add_control( 'blog_post_columns', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Columns', 'xoha-plus'),
                'default' => 'one-third-column',
                'options' => array(
                    'one-column'        => esc_html__('I Column', 'xoha-plus'),
                    'one-half-column'   => esc_html__('II Columns', 'xoha-plus'),
                    'one-third-column'  => esc_html__('III Columns', 'xoha-plus'),
                    'one-fourth-column' => esc_html__('IV Columns', 'xoha-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'blog_list_thumb', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('List Type', 'xoha-plus'),
                'default' => 'entry-left-thumb',
                'options' => array(
                    'entry-left-thumb'  => esc_html__('Left Thumb', 'xoha-plus'),
                    'entry-right-thumb' => esc_html__('Right Thumb', 'xoha-plus'),
                ),
                'condition' => array( 'blog_post_layout' => 'entry-list' )
            ) );

            $this->add_control( 'blog_alignment', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Elements Alignment', 'xoha-plus'),
                'default' => 'alignnone',
                'options' => array(
                    'alignnone'   => esc_html__('None', 'xoha-plus'),
                    'alignleft'   => esc_html__('Align Left', 'xoha-plus'),
                    'aligncenter' => esc_html__('Align Center', 'xoha-plus'),
                    'alignright'  => esc_html__('Align Right', 'xoha-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_equal_height', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Equal Height?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_no_space', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable No Space?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_gallery_slider', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Display Gallery Slider?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Element', 'xoha-plus'),
                'default' => 'feature_image',
                'options' => array(
                    'feature_image' => esc_html__('Feature Image', 'xoha-plus'),
                    'title'         => esc_html__('Title', 'xoha-plus'),
                    'content'       => esc_html__('Content', 'xoha-plus'),
                    'read_more'     => esc_html__('Read More', 'xoha-plus'),
                    'meta_group'    => esc_html__('Meta Group', 'xoha-plus'),
                    'author'        => esc_html__('Author', 'xoha-plus'),
                    'date'          => esc_html__('Date', 'xoha-plus'),
                    'comment'       => esc_html__('Comments', 'xoha-plus'),
                    'category'      => esc_html__('Categories', 'xoha-plus'),
                    'tag'           => esc_html__('Tags', 'xoha-plus'),
                    'social'        => esc_html__('Social Share', 'xoha-plus'),
                    'likes_views'   => esc_html__('Likes & Views', 'xoha-plus'),
                ),
            ) );

            $this->add_control( 'blog_elements_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => esc_html__('Elements & Positioning', 'xoha-plus'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'title' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Element', 'xoha-plus'),
                'default' => 'author',
                'options' => array(
                    'author'       => esc_html__('Author', 'xoha-plus'),
                    'date'         => esc_html__('Date', 'xoha-plus'),
                    'comment'      => esc_html__('Comments', 'xoha-plus'),
                    'category'     => esc_html__('Categories', 'xoha-plus'),
                    'tag'          => esc_html__('Tags', 'xoha-plus'),
                    'social'       => esc_html__('Social Share', 'xoha-plus'),
                    'likes_views'  => esc_html__('Likes & Views', 'xoha-plus'),
                ),
            ) );

            $this->add_control( 'blog_meta_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => esc_html__('Meta Group Positioning', 'xoha-plus'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'author' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $this->add_control( 'enable_post_format', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Post Format?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'enable_video_audio', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Display Video & Audio for Posts?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
                'description'  => esc_html__( 'YES! to display video & audio, instead of feature image for posts', 'xoha-plus' ),
            ) );

            $this->add_control( 'enable_excerpt_text', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Excerpt Text?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'blog_excerpt_length', array(
                'type'      => Controls_Manager::NUMBER,
                'label'     => esc_html__('Excerpt Length', 'xoha-plus'),
                'default'   => '25',
                'condition' => array( 'enable_excerpt_text' => 'yes' )
            ) );

            $this->add_control( 'blog_readmore_text', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Read More Text', 'xoha-plus'),
                'default'     => esc_html__('Read More', 'xoha-plus'),
            ) );

            $this->add_control( 'blog_image_hover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Image Hover Style', 'xoha-plus'),
                'default' => 'wdt-default',
                'options' => array(
                    'wdt-default'     => esc_html__('Default', 'xoha-plus'),
                    'wdt-blur'        => esc_html__('Blur', 'xoha-plus'),
                    'wdt-bw'          => esc_html__('Black and White', 'xoha-plus'),
                    'wdt-brightness'  => esc_html__('Brightness', 'xoha-plus'),
                    'wdt-fadeinleft'  => esc_html__('Fade InLeft', 'xoha-plus'),
                    'wdt-fadeinright' => esc_html__('Fade InRight', 'xoha-plus'),
                    'wdt-hue-rotate'  => esc_html__('Hue-Rotate', 'xoha-plus'),
                    'wdt-invert'      => esc_html__('Invert', 'xoha-plus'),
                    'wdt-opacity'     => esc_html__('Opacity', 'xoha-plus'),
                    'wdt-rotate'      => esc_html__('Rotate', 'xoha-plus'),
                    'wdt-rotate-alt'  => esc_html__('Rotate Alt', 'xoha-plus'),
                    'wdt-scalein'     => esc_html__('Scale In', 'xoha-plus'),
                    'wdt-scaleout'    => esc_html__('Scale Out', 'xoha-plus'),
                    'wdt-sepia'       => esc_html__('Sepia', 'xoha-plus'),
                    'wdt-tint'        => esc_html__('Tint', 'xoha-plus'),
                ),
                'description' => esc_html__('Note: Fade, Rotate & Scale Styles will not work for Gallery Sliders.', 'xoha-plus'),
            ) );

            $this->add_control( 'blog_image_overlay_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Image Overlay Style', 'xoha-plus'),
                'default' => 'wdt-default',
                'options' => array(
                    'wdt-default'         => esc_html__('None', 'xoha-plus'),
                    'wdt-fixed'           => esc_html__('Fixed', 'xoha-plus'),
                    'wdt-tb'              => esc_html__('Top to Bottom', 'xoha-plus'),
                    'wdt-bt'              => esc_html__('Bottom to Top', 'xoha-plus'),
                    'wdt-rl'              => esc_html__('Right to Left', 'xoha-plus'),
                    'wdt-lr'              => esc_html__('Left to Right', 'xoha-plus'),
                    'wdt-middle'          => esc_html__('Middle', 'xoha-plus'),
                    'wdt-middle-radial'   => esc_html__('Middle Radial', 'xoha-plus'),
                    'wdt-tb-gradient'     => esc_html__('Gradient - Top to Bottom', 'xoha-plus'),
                    'wdt-bt-gradient'     => esc_html__('Gradient - Bottom to Top', 'xoha-plus'),
                    'wdt-rl-gradient'     => esc_html__('Gradient - Right to Left', 'xoha-plus'),
                    'wdt-lr-gradient'     => esc_html__('Gradient - Left to Right', 'xoha-plus'),
                    'wdt-radial-gradient' => esc_html__('Gradient - Radial', 'xoha-plus'),
                    'wdt-flash'           => esc_html__('Flash', 'xoha-plus'),
                    'wdt-circle'          => esc_html__('Circle', 'xoha-plus'),
                    'wdt-hm-elastic'      => esc_html__('Horizontal Elastic', 'xoha-plus'),
                    'wdt-vm-elastic'      => esc_html__('Vertical Elastic', 'xoha-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_pagination', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Pagination Style', 'xoha-plus'),
                'default' => 'older_newer',
                'options' => array(
                    ''                => esc_html__('None', 'xoha-plus'),
                    'older_newer'     => esc_html__('Older & Newer', 'xoha-plus'),
                    'numbered'        => esc_html__('Numbered', 'xoha-plus'),
                    'load_more'       => esc_html__('Load More', 'xoha-plus'),
                    'infinite_scroll' => esc_html__('Infinite Scroll', 'xoha-plus'),
                    'carousel'        => esc_html__('Carousel', 'xoha-plus'),
                ),
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'xoha-plus'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'xoha-plus')
            ) );

        $this->end_controls_section();

		$this->start_controls_section( 'blog_carousel_section', array(
			'label'     => esc_html__( 'Carousel Settings', 'xoha-plus' ),
			'condition' => array( 'blog_pagination' => 'carousel' ),
		) );
			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'xoha-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'xoha-plus' ),
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Default', 'xoha-plus' ),
					'fade' => esc_html__( 'Fade', 'xoha-plus' ),
	            ),
	        ) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'xoha-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'xoha-plus' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 2,
	        ) );

			$this->add_control( 'carousel_loopmode', array(
				'label'        => esc_html__( 'Enable Loop Mode', 'xoha-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'xoha-plus'),
				'label_on'     => esc_html__( 'yes', 'xoha-plus' ),
				'label_off'    => esc_html__( 'no', 'xoha-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'        => esc_html__( 'Enable Mousewheel Control', 'xoha-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'xoha-plus'),
				'label_on'     => esc_html__( 'yes', 'xoha-plus' ),
				'label_off'    => esc_html__( 'no', 'xoha-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'        => esc_html__( 'Enable Bullet Pagination', 'xoha-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable bullet pagination.', 'xoha-plus'),
				'label_on'     => esc_html__( 'yes', 'xoha-plus' ),
				'label_off'    => esc_html__( 'no', 'xoha-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'        => esc_html__( 'Enable Arrow Pagination', 'xoha-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable arrow pagination.', 'xoha-plus'),
				'label_on'     => esc_html__( 'yes', 'xoha-plus' ),
				'label_off'    => esc_html__( 'no', 'xoha-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => esc_html__( 'Arrow Type', 'xoha-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'xoha-plus' ),
				'options'     => array(
					''      => esc_html__('Default', 'xoha-plus'),
					'type2' => esc_html__('Type 2', 'xoha-plus'),
				),
				'condition'   => array( 'carousel_arrowpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_scrollbar', array(
				'label'        => esc_html__( 'Enable Scrollbar', 'xoha-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable scrollbar for your carousel.', 'xoha-plus'),
				'label_on'     => esc_html__( 'yes', 'xoha-plus' ),
				'label_off'    => esc_html__( 'no', 'xoha-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

		$this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

		$media_carousel_attributes_string = $container_class = $wrapper_class = $item_class = '';

		if( $blog_pagination == 'carousel' ) {

			$media_carousel_attributes = array ();

			array_push( $media_carousel_attributes, 'data-carouseleffect="'.esc_attr($settings['carousel_effect']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselslidesperview="'.esc_attr($settings['carousel_slidesperview']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselloopmode="'.esc_attr($settings['carousel_loopmode']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselmousewheelcontrol="'.esc_attr($settings['carousel_mousewheelcontrol']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselbulletpagination="'.esc_attr($settings['carousel_bulletpagination']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselarrowpagination="'.esc_attr($settings['carousel_arrowpagination']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselscrollbar="'.esc_attr($settings['carousel_scrollbar']).'"' );

			if( !empty( $media_carousel_attributes ) ) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$container_class = 'swiper-container';
			$wrapper_class = 'swiper-wrapper';
			$item_class = 'swiper-slide';

			$out .= '<div class="wdt-post-list-carousel-container">';
		}

		$out .= '<div class="wdt-posts-list-wrapper '.esc_attr($container_class).' '.esc_attr($el_class).'" '.xoha_html_output($media_carousel_attributes_string).'>';

		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
		$warning = esc_html__('No Posts Found','xoha-plus');

        if( !empty( $_post_categories ) && $query_posts_by == 'category' ) {
            $_post_categories = implode( ',', $_post_categories );
			$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'cat' => $_post_categories, 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
			$warning = esc_html__('No Posts Found in Category ','designthemes-theme').$_post_categories;
		} elseif( $query_posts_by == 'ids' && !empty( $_post_ids ) ) {
            $args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'post__in' => $_post_ids, 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
            $warning = esc_html__('No Posts Found in Criteria ','designthemes-theme').$_post_categories;
        }

		if( !empty( $_post_not_in ) ) {
			$args['post__not_in'] = array( $_post_not_in );
            $settings['blog_excerpt_length'] = $settings['blog_excerpt_length2'];
		}

		$rposts = new WP_Query( $args );
		if ( $rposts->have_posts() ) :

           	do_action( 'call_blog_elementor_sc_filters', $settings );

            $holder_class = '';
            if($wrapper_class == '') {
                $holder_class = xoha_get_archive_post_holder_class();
            }
            $combine_class = xoha_get_archive_post_combine_class();

            $post_style    = xoha_get_archive_post_style();
            $template_args['Post_Style'] = $post_style;
            $template_args = array_merge( $template_args, xoha_archive_blog_post_params() );
            $template_args = apply_filters( 'xoha_blog_archive_elem_order_params', $template_args );

            // css enqueue
            wp_enqueue_style( 'xoha-plus-blog', XOHA_PLUS_DIR_URL . 'modules/blog/assets/css/blog.css', false, XOHA_PLUS_VERSION, 'all');

            $file_path = XOHA_PRO_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
            if ( file_exists( $file_path ) ) {
                wp_enqueue_style( 'wdt-blog-archive-'.esc_attr($post_style), XOHA_PRO_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, XOHA_PRO_VERSION, 'all');
            } else {
                $file_path = XOHA_PLUS_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
                if ( file_exists( $file_path ) ) {
                    wp_enqueue_style( 'wdt-blog-archive-'.esc_attr($post_style), XOHA_PLUS_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, XOHA_PLUS_VERSION, 'all');
                }
            }

            $out .="<div class='tpl-blog-holder ".$holder_class." ".$wrapper_class."'>";
            if($wrapper_class == '') {
                $out .= "<div class='grid-sizer ".$combine_class."'></div>";
            }

                while( $rposts->have_posts() ) :
                    $rposts->the_post();
                    $post_ID = get_the_ID();

                    $out .= '<div class="'.esc_attr($combine_class.' '.$item_class).'">';
                        $out .= '<article id="post-'.esc_attr($post_ID).'" class="' . implode( ' ', get_post_class( '', $post_ID ) ) . '">';

                            $template_args['ID'] = $post_ID;
                            $out .= xoha_get_template_part( 'blog', 'templates/'.esc_attr($post_style).'/post', '', $template_args );
                        $out .= '</article>';
                    $out .= '</div>';
                endwhile;

			wp_reset_postdata($rposts);

            $out .= '</div>';

			if( $blog_pagination == 'numbered' ):

				$out .= '<div class="pagination blog-pagination">'.xoha_pagination($rposts).'</div>';

			elseif( $blog_pagination == 'older_newer' ):

				$out .= '<div class="pagination blog-pagination"><div class="newer-posts">'.get_previous_posts_link( '<i class="wdticon-angle-left"></i>'.esc_html__(' Newer Posts', 'xoha-plus') ).'</div>';
				$out .= '<div class="older-posts">'.get_next_posts_link( esc_html__('Older Posts ', 'xoha-plus').'<i class="wdticon-angle-right"></i>', $rposts->max_num_pages ).'</div></div>';

			elseif( $blog_pagination == 'load_more' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

				$out .= "<div class='pagination blog-pagination'><a class='loadmore-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' href='javascript:void(0);' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'>".esc_html__('Load More', 'xoha-plus')."</a></div>";

			elseif( $blog_pagination == 'infinite_scroll' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

                $out .= "<div class='pagination blog-pagination'><div class='infinite-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'></div></div>";

			elseif( $blog_pagination == 'carousel' ):

				$out .= '<div class="wdt-products-pagination-holder">';

					if( $settings['carousel_bulletpagination'] == 'true' ) {
						$out .= '<div class="wdt-products-bullet-pagination"></div>';
					}

					if( $settings['carousel_scrollbar'] == 'true' ) {
						$out .= '<div class="wdt-products-scrollbar"></div>';
					}

					if( $settings['carousel_arrowpagination'] == 'true' ) {
						$out .= '<div class="wdt-products-arrow-pagination '.esc_attr($settings['carousel_arrowpagination_type']).'">';
							$out .= '<a href="#" class="wdt-products-arrow-prev">'.esc_html__('Prev', 'xoha-plus').'</a>';
							$out .= '<a href="#" class="wdt-products-arrow-next">'.esc_html__('Next', 'xoha-plus').'</a>';
						$out .= '</div>';
					}

				$out .= '</div>';

			endif;

		else:
			$out .= "<div class='wdt-warning-box'>{$warning}</div>";
		endif;

		$out .= '</div>';

		if( $blog_pagination == 'carousel' ) {
			$out .= '</div>';
		}

        echo xoha_html_output($out);
    }

}