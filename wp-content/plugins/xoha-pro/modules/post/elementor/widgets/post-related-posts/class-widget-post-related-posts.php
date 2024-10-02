<?php
use XohaElementor\Widgets\XohaElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Related_Posts extends XohaElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-related-posts';
    }

    public function get_title() {
        return esc_html__('Post - Related Posts', 'xoha-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'xoha-pro'),
        ) );

            $this->add_control( 'related_title', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Title', 'xoha-pro'),
                'default'     => esc_html__('Related Posts', 'xoha-pro'),
				'description' => esc_html__('Put the related posts section title.', 'xoha-pro'),
            ) );

            $this->add_control( 'related_column', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Column', 'xoha-pro'),
                'default' => 'one-third-column',
                'options' => array(
                    'one-column'  		=> esc_html__('I Column', 'xoha-pro'),
                    'one-half-column'  	=> esc_html__('II Columns', 'xoha-pro'),
                    'one-third-column'  => esc_html__('III Columns', 'xoha-pro'),
                ),
            ) );

            $this->add_control( 'related_count', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Count', 'xoha-pro'),
                'default'     => '3',
                'placeholder' => esc_html__( 'Put no.of related posts to show.', 'xoha-pro' ),
            ) );

            $this->add_control( 'related_excerpt', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Excerpt?', 'xoha-pro'),
                'label_on'     => esc_html__( 'Yes', 'xoha-pro' ),
                'label_off'    => esc_html__( 'No', 'xoha-pro' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'related_excerpt_length', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Excerpt Length', 'xoha-pro'),
                'default'     => '25',
                'condition' => array( 'related_excerpt' => 'yes' )
            ) );

            $this->add_control( 'related_carousel', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Carousel?', 'xoha-pro'),
                'label_on'     => esc_html__( 'Yes', 'xoha-pro' ),
                'label_off'    => esc_html__( 'No', 'xoha-pro' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'related_nav_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Navigation Style', 'xoha-pro'),
                'default' => '',
                'options' => array(
                    ''  		  => esc_html__('None', 'xoha-pro'),
                    'navigation'  => esc_html__('Navigations', 'xoha-pro'),
                    'pager'  	  => esc_html__('Pager', 'xoha-pro'),
                ),
				'condition' => array( 'related_carousel' => 'yes' )
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'xoha-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'xoha-pro')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

		$template_args['post_ID'] = $post_id;
		$template_args['related_Title'] = $related_title;
		$template_args['related_Column'] = $related_column;
		$template_args['related_Count'] = $related_count;
		$template_args['related_Excerpt'] = $related_excerpt;
		$template_args['related_Excerpt_Length'] = $related_excerpt_length;
		$template_args['related_Carousel'] = $related_carousel;
		$template_args['related_Nav_Style'] = $related_nav_style;

		$out .= '<div class="entry-related-posts-wrapper '.$el_class.'">';
           $out .= xoha_get_template_part( 'post', 'templates/post-extra/related_posts', '', $template_args );
		$out .= '</div>';

		echo $out;
	}

}