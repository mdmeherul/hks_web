<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProCustomizerBlogPost' ) ) {
    class XohaProCustomizerBlogPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'xoha_pro_customizer_default', array( $this, 'default' ) );
			add_action( 'customize_register', array( $this, 'register' ), 20 );
        }

        function default( $option ) {

            $option['enable_title'] 		  = '0';
            $option['enable_image_lightbox']  = '0';
			$option['enable_disqus_comments'] = '0';
			$option['enable_related_article'] = '1';
			$option['post_disqus_shortname']  = '';
			$option['post_dynamic_elements']  = array( 'content', 'navigation', 'comment_box', 'related_posts' );
			$option['rposts_title']    		  = esc_html__('Related Posts', 'xoha-pro');
			$option['rposts_column']   		  = 'one-third-column';
			$option['rposts_count']    		  = '3';
			$option['rposts_excerpt']  		  = '1';
			$option['rposts_excerpt_length']  = '25';
			$option['rposts_carousel']  	  = '0';
			$option['rposts_carousel_nav']    = '';
			$option['post_commentlist_style'] = 'rounded';

            return $option;
        }

        function register( $wp_customize ) {

			/**
			 * Option : Post Title
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[enable_title]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Switch(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[enable_title]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Title', 'xoha-pro'),
						'description' => esc_html__('YES! to enable the title of single post.', 'xoha-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
							'off' => esc_attr__( 'No', 'xoha-pro' )
						)
					)
				)
			);

			/**
			 * Option : Post Elements
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Sortable(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
						'type' => 'wdt-sortable',
						'label' => esc_html__( 'Post Elements Positioning', 'xoha-pro'),
						'section' => 'site-blog-post-section',
						'choices' => apply_filters( 'xoha_blog_post_dynamic_elements', array(
							'author'		=> esc_html__('Author', 'xoha-pro'),
							'author_bio' 	=> esc_html__('Author Bio', 'xoha-pro'),
							'category'    	=> esc_html__('Categories', 'xoha-pro'),
							'comment' 		=> esc_html__('Comments', 'xoha-pro'),
							'comment_box' 	=> esc_html__('Comment Box', 'xoha-pro'),
							'content'    	=> esc_html__('Content', 'xoha-pro'),
							'date'     		=> esc_html__('Date', 'xoha-pro'),
							'image'			=> esc_html__('Feature Image', 'xoha-pro'),
							'navigation'    => esc_html__('Navigation', 'xoha-pro'),
							'tag'  			=> esc_html__('Tags', 'xoha-pro'),
							'title'      	=> esc_html__('Title', 'xoha-pro'),
							'likes_views'   => esc_html__('Likes & Views', 'xoha-pro'),
							'related_posts' => esc_html__('Related Posts', 'xoha-pro'),
							'social'  		=> esc_html__('Social Share', 'xoha-pro'),
						)
					),
				)
			));

			/**
			 * Option : Image Lightbox
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Switch(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Feature Image Lightbox', 'xoha-pro'),
						'description' => esc_html__('YES! to enable lightbox for feature image. Will not work in "Overlay" style.', 'xoha-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
							'off' => esc_attr__( 'No', 'xoha-pro' )
						)
					)
				)
			);

			/**
			 * Option : Related Article
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[enable_related_article]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Switch(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[enable_related_article]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Related Article', 'xoha-pro'),
						'description' => esc_html__('YES! to enable related article at right hand side of post.', 'xoha-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
							'off' => esc_attr__( 'No', 'xoha-pro' )
						)
					)
				)
			);

			/**
			 * Option : Disqus Comments
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Switch(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Disqus Comments', 'xoha-pro'),
						'description' => esc_html__('YES! to enable disqus platform comments module.', 'xoha-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
							'off' => esc_attr__( 'No', 'xoha-pro' )
						)
					)
				)
			);

			/**
			 * Option : Disqus Short Name
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
						'type'    	  => 'textarea',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Shortname', 'xoha-pro' ),
						'input_attrs' => array(
							'placeholder' => 'disqus',
						),
						'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Disqus Description
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[post_disqus_description]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Description(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[post_disqus_description]', array(
						'type'    	  => 'wdt-description',
						'section'     => 'site-blog-post-section',
						'description' => esc_html__('Your site\'s unique identifier', 'xoha-pro').' '.'<a href="'.esc_url('https://help.disqus.com/customer/portal/articles/466208').'" target="_blank">'.esc_html__('What is this?', 'xoha-pro').'</a>',
						'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Comment List Style
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[post_commentlist_style]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new Xoha_Customize_Control(
				$wp_customize, XOHA_CUSTOMISER_VAL . '[post_commentlist_style]', array(
					'type'    => 'select',
					'section' => 'site-blog-post-section',
					'label'   => esc_html__( 'Comments List Style', 'xoha-pro' ),
					'choices' => array(
						'rounded' 	=> esc_html__('Rounded', 'xoha-pro'),
						'square'   	=> esc_html__('Square', 'xoha-pro'),
					),
					'description' => esc_html__('Choose comments list style to display single post.', 'xoha-pro'),
					'dependency' => array( 'enable_disqus_comments', '!=', 'true' ),
				)
			));

			/**
			 * Option : Post Related Title
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[rposts_title]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[rposts_title]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Related Posts Section Title', 'xoha-pro' ),
						'description' => esc_html__('Put the related posts section title here', 'xoha-pro'),
						'input_attrs' => array(
							'value'	=> esc_html__('Related Posts', 'xoha-pro'),
						)
					)
				)
			);

			/**
			 * Option : Related Columns
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[rposts_column]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
				$wp_customize, XOHA_CUSTOMISER_VAL . '[rposts_column]', array(
					'type' => 'wdt-radio-image',
					'label' => esc_html__( 'Columns', 'xoha-pro'),
					'section' => 'site-blog-post-section',
					'choices' => apply_filters( 'xoha_blog_post_related_columns', array(
						'one-column' => array(
							'label' => esc_html__( 'One Column', 'xoha-pro' ),
							'path' => XOHA_PRO_DIR_URL . 'modules/post/customizer/images/one-column.png'
						),
						'one-half-column' => array(
							'label' => esc_html__( 'One Half Column', 'xoha-pro' ),
							'path' => XOHA_PRO_DIR_URL . 'modules/post/customizer/images/one-half-column.png'
						),
						'one-third-column' => array(
							'label' => esc_html__( 'One Third Column', 'xoha-pro' ),
							'path' => XOHA_PRO_DIR_URL . 'modules/post/customizer/images/one-third-column.png'
						),
					)),
				)
			));

			/**
			 * Option : Related Count
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[rposts_count]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[rposts_count]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'No.of Posts to Show', 'xoha-pro' ),
						'description' => esc_html__('Put the no.of related posts to show', 'xoha-pro'),
						'input_attrs' => array(
							'value'	=> 3,
						),
					)
				)
			);

			/**
			 * Option : Enable Excerpt
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[rposts_excerpt]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Switch(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[rposts_excerpt]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Excerpt Text', 'xoha-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
							'off' => esc_attr__( 'No', 'xoha-pro' )
						)
					)
				)
			);

			/**
			 * Option : Excerpt Text
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Excerpt Length', 'xoha-pro' ),
						'description' => esc_html__('Put Excerpt Length', 'xoha-pro'),
						'input_attrs' => array(
							'value'	=> 25,
						),
						'dependency' => array( 'rposts_excerpt', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Related Carousel
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[rposts_carousel]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new Xoha_Customize_Control_Switch(
					$wp_customize, XOHA_CUSTOMISER_VAL . '[rposts_carousel]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Carousel', 'xoha-pro'),
						'description' => esc_html__('YES! to enable carousel related posts', 'xoha-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'xoha-pro' ),
							'off' => esc_attr__( 'No', 'xoha-pro' )
						)
					)
				)
			);

			/**
			 * Option : Related Carousel Nav
			 */
			$wp_customize->add_setting(
				XOHA_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new Xoha_Customize_Control(
				$wp_customize, XOHA_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
					'type'    => 'select',
					'section' => 'site-blog-post-section',
					'label'   => esc_html__( 'Navigation Style', 'xoha-pro' ),
					'choices' => array(
						'' 			 => esc_html__('None', 'xoha-pro'),
						'navigation' => esc_html__('Navigations', 'xoha-pro'),
						'pager'   	 => esc_html__('Pager', 'xoha-pro'),
					),
					'description' => esc_html__('Choose navigation style to display related post carousel.', 'xoha-pro'),
					'dependency' => array( 'rposts_carousel', '==', 'true' ),
				)
			));

        }
    }
}

XohaProCustomizerBlogPost::instance();