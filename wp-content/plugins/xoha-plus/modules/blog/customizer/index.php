<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaPlusCustomizerSiteBlog' ) ) {
    class XohaPlusCustomizerSiteBlog {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'xoha_plus_customizer_default', array( $this, 'default' ) );
        }

        function default( $option ) {

            $option['blog-post-layout']          = 'entry-grid';
            $option['blog-post-grid-list-style'] = 'wdt-classic';
            $option['blog-post-cover-style']     = 'wdt-classic';
            $option['blog-post-columns']         = 'one-half-column';
            $option['blog-list-thumb']           = 'entry-left-thumb';
            $option['blog-alignment']            = 'alignnone';
            $option['enable-equal-height']       = '0';
            $option['enable-no-space']           = '0';
            $option['enable-gallery-slider']     = '1';
            $option['blog-elements-position']    = array( 'feature_image', 'meta_group', 'title', 'content', 'read_more' );
            $option['blog-meta-position']        = array( 'category', 'tag' );
            $option['enable-post-format']        = '0';
            $option['enable-excerpt-text']       = '1';
            $option['blog-excerpt-length']       = '50';
            $option['enable-video-audio']        = '0';
            $option['blog-readmore-text']        = esc_html__('Read More', 'xoha-plus');
            $option['blog-image-hover-style']    = 'wdt-scalein';
            $option['blog-image-overlay-style']  = 'wdt-bt-gradient';
            $option['blog-pagination']           = 'pagination-numbered';

            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new Xoha_Customize_Panel(
                    $wp_customize,
                    'site-blog-main-panel',
                    array(
                        'title'    => esc_html__('Blog Settings', 'xoha-plus'),
                        'priority' => xoha_customizer_panel_priority( 'blog' )
                    )
                )
            );

            $wp_customize->add_section(
                new Xoha_Customize_Section(
                    $wp_customize,
                    'site-blog-archive-section',
                    array(
                        'title'    => esc_html__('Blog Archives', 'xoha-plus'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 10,
                    )
                )
            );


            /**
             * Option : Archive Post Layout
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Post Layout', 'xoha-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'xoha_blog_archive_layout_options', array(
                        'entry-grid' => array(
                            'label' => esc_html__( 'Grid', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-grid.png'
                        ),
                        'entry-list' => array(
                            'label' => esc_html__( 'List', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-list.png'
                        ),
                        'entry-cover' => array(
                            'label' => esc_html__( 'Cover', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-cover.png'
                        ),
                    ))
                )
            ));

            /**
             * Option : Post Grid, List Style
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'xoha-plus' ),
                    'choices' => apply_filters('blog_post_grid_list_style_update', array(
                        'wdt-classic' => esc_html__('Classic', 'xoha-plus'),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' )
                )
            ));

            /**
             * Option : Post Cover Style
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'xoha-plus' ),
                    'choices' => apply_filters('blog_post_cover_style_update', array(
                        'wdt-classic' => esc_html__('Classic', 'xoha-plus')
                    )),
                    'dependency'   => array( 'blog-post-layout', '==', 'entry-cover' )
                )
            ));

            /**
             * Option : Post Columns
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Columns', 'xoha-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'xoha_blog_archive_columns_options', array(
                        'one-column' => array(
                            'label' => esc_html__( 'One Column', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/one-column.png'
                        ),
                        'one-half-column' => array(
                            'label' => esc_html__( 'One Half Column', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/one-half-column.png'
                        ),
                        'one-third-column' => array(
                            'label' => esc_html__( 'One Third Column', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/one-third-column.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : List Thumb
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control_Radio_Image(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'List Type', 'xoha-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'xoha_blog_archive_list_thumb_options', array(
                        'entry-left-thumb' => array(
                            'label' => esc_html__( 'Left Thumb', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-left-thumb.png'
                        ),
                        'entry-right-thumb' => array(
                            'label' => esc_html__( 'Right Thumb', 'xoha-plus' ),
                            'path' => XOHA_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-right-thumb.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', '==', 'entry-list' ),
                )
            ));

            /**
             * Option : Post Alignment
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Elements Alignment', 'xoha-plus' ),
                    'choices' => array(
                      'alignnone'   => esc_html__('None', 'xoha-plus'),
                      'alignleft'   => esc_html__('Align Left', 'xoha-plus'),
                      'aligncenter' => esc_html__('Align Center', 'xoha-plus'),
                      'alignright'  => esc_html__('Align Right', 'xoha-plus'),
                    ),
                    'dependency'   => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : Equal Height
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[enable-equal-height]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Switch(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[enable-equal-height]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Equal Height', 'xoha-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                            'off' => esc_attr__( 'No', 'xoha-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );

            /**
             * Option : No Space
             */
            /*$wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[enable-no-space]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Switch(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[enable-no-space]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable No Space', 'xoha-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                            'off' => esc_attr__( 'No', 'xoha-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );*/

            /**
             * Option : Gallery Slider
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Switch(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Gallery Slider', 'xoha-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                            'off' => esc_attr__( 'No', 'xoha-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Divider : Blog Gallery Slider Bottom
             */
            $wp_customize->add_control(
                new Xoha_Customize_Control_Separator(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-gallery-slider-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Blog Elements
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control_Sortable(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Elements Positioning', 'xoha-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'xoha_archive_post_elements_options', array(
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
                    )),
                )
            ));

            /**
             * Option : Blog Meta Elements
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control_Sortable(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Meta Group Positioning', 'xoha-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'xoha_blog_archive_meta_elements_options', array(
                        'author'        => esc_html__('Author', 'xoha-plus'),
                        'date'          => esc_html__('Date', 'xoha-plus'),
                        'comment'       => esc_html__('Comments', 'xoha-plus'),
                        'category'      => esc_html__('Categories', 'xoha-plus'),
                        'tag'           => esc_html__('Tags', 'xoha-plus'),
                        'social'        => esc_html__('Social Share', 'xoha-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'xoha-plus'),
                    )),
                    'description' => esc_html__('Note: Use max 3 items for better results.', 'xoha-plus'),
                )
            ));

            /**
             * Divider : Blog Meta Elements Bottom
             */
            $wp_customize->add_control(
                new Xoha_Customize_Control_Separator(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-meta-elements-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Post Format
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[enable-post-format]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Switch(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[enable-post-format]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Post Format', 'xoha-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                            'off' => esc_attr__( 'No', 'xoha-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Enable Excerpt
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Switch(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Excerpt Text', 'xoha-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                            'off' => esc_attr__( 'No', 'xoha-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Excerpt Text
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Excerpt Length', 'xoha-plus' ),
                        'description' => esc_html__('Put Excerpt Length', 'xoha-plus'),
                        'input_attrs' => array(
                            'value' => 25,
                        ),
                        'dependency'  => array( 'enable-excerpt-text', '==', 'true' ),
                    )
                )
            );

            /**
             * Option : Enable Video Audio
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[enable-video-audio]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control_Switch(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[enable-video-audio]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Video & Audio for Posts', 'xoha-plus'),
                        'description' => esc_html__('YES! to display video & audio, instead of feature image for posts', 'xoha-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'xoha-plus' ),
                            'off' => esc_attr__( 'No', 'xoha-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Option : Readmore Text
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Xoha_Customize_Control(
                    $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Read More Text', 'xoha-plus' ),
                        'description' => esc_html__('Put the read more text here', 'xoha-plus'),
                        'input_attrs' => array(
                            'value' => esc_html__('Read More', 'xoha-plus'),
                        )
                    )
                )
            );

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Hover Style', 'xoha-plus' ),
                    'choices' => array(
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
                    'description' => esc_html__('Choose image hover style to display archives pages.', 'xoha-plus'),
                )
            ));

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Overlay Style', 'xoha-plus' ),
                    'choices' => array(
                      'wdt-default'           => esc_html__('None', 'xoha-plus'),
                      'wdt-fixed'             => esc_html__('Fixed', 'xoha-plus'),
                      'wdt-tb'                => esc_html__('Top to Bottom', 'xoha-plus'),
                      'wdt-bt'                => esc_html__('Bottom to Top', 'xoha-plus'),
                      'wdt-rl'                => esc_html__('Right to Left', 'xoha-plus'),
                      'wdt-lr'                => esc_html__('Left to Right', 'xoha-plus'),
                      'wdt-middle'            => esc_html__('Middle', 'xoha-plus'),
                      'wdt-middle-radial'     => esc_html__('Middle Radial', 'xoha-plus'),
                      'wdt-tb-gradient'       => esc_html__('Gradient - Top to Bottom', 'xoha-plus'),
                      'wdt-bt-gradient'       => esc_html__('Gradient - Bottom to Top', 'xoha-plus'),
                      'wdt-rl-gradient'       => esc_html__('Gradient - Right to Left', 'xoha-plus'),
                      'wdt-lr-gradient'       => esc_html__('Gradient - Left to Right', 'xoha-plus'),
                      'wdt-radial-gradient'   => esc_html__('Gradient - Radial', 'xoha-plus'),
                      'wdt-flash'             => esc_html__('Flash', 'xoha-plus'),
                      'wdt-circle'            => esc_html__('Circle', 'xoha-plus'),
                      'wdt-hm-elastic'        => esc_html__('Horizontal Elastic', 'xoha-plus'),
                      'wdt-vm-elastic'        => esc_html__('Vertical Elastic', 'xoha-plus'),
                    ),
                    'description' => esc_html__('Choose image overlay style to display archives pages.', 'xoha-plus'),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                )
            ));

            /**
             * Option : Pagination
             */
            $wp_customize->add_setting(
                XOHA_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Xoha_Customize_Control(
                $wp_customize, XOHA_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Pagination Style', 'xoha-plus' ),
                    'choices' => array(
                      'pagination-default'        => esc_html__('Older & Newer', 'xoha-plus'),
                      'pagination-numbered'       => esc_html__('Numbered', 'xoha-plus'),
                      'pagination-loadmore'       => esc_html__('Load More', 'xoha-plus'),
                      'pagination-infinite-scroll'=> esc_html__('Infinite Scroll', 'xoha-plus'),
                    ),
                    'description' => esc_html__('Choose pagination style to display archives pages.', 'xoha-plus')
                )
            ));

        }
    }
}

XohaPlusCustomizerSiteBlog::instance();