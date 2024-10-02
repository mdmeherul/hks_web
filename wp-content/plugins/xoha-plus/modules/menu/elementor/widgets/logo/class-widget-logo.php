<?php
use XohaElementor\Widgets\XohaElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;

class Elementor_Logo extends XohaElementorWidgetBase {

    public function get_name() {
        return 'wdt-logo';
    }

    public function get_title() {
        return esc_html__('Logo', 'xoha-plus');
    }

    public function get_style_depends() {
        return array( 'wdt-logo' );
    }

    public function get_icon() {
		return 'eicon-logo wdt-icon';
	}

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'xoha-plus'),
        ) );

            $this->add_control( 'logo_type', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Logo Type', 'xoha-plus'),
                'default' => 'theme-logo',
                'options' => array(
                    'theme-logo'  => esc_html__('Logo', 'xoha-plus'),
                    'custom-image'  => esc_html__('Custom Image', 'xoha-plus'),
                    'text' => esc_html__('Title', 'xoha-plus'),
                    'text-desc' => esc_html__('Title and Description', 'xoha-plus'),
                )
            ) );

                $this->add_control( 'theme_logo_type', array(
                    'type'    => Controls_Manager::SELECT,
    				'label'   => esc_html__('Logo', 'xoha-plus'),
                    'default' => 'logo',
                    'options' => array(
                        'logo'  => esc_html__('Logo', 'xoha-plus'),
                        'light-logo'  => esc_html__('Light Logo', 'xoha-plus'),
                    ),
                    'condition' => array( 'logo_type' => 'theme-logo' )
                ) );

    			$this->add_control( 'image', array(
    				'type'      => Controls_Manager::MEDIA,
    				'label'     => esc_html__( 'Image', 'xoha-plus' ),
    				'default'   => array( 'url' => Utils::get_placeholder_image_src(), ),
    				'condition' => array( 'logo_type' => 'custom-image' )
    			) );

    			$this->add_responsive_control( 'image_width', array(
    				'label'           => esc_html__( 'Image Width (px)', 'xoha-plus' ),
    				'type'            => Controls_Manager::NUMBER,
    				'min'             => 10,
    				'max'             => 500,
    				'step'            => 1,
                    'desktop_default'      => 150,
                    'laptop_default'       => 150,
                    'tablet_default'       => 100,
                    'tablet_extra_default' => 100,
                    'mobile_default'       => 100,
                    'mobile_extra_default' => 100,
    				'condition' => array( 'logo_type' => array( 'theme-logo', 'custom-image' ) ),
                    'selectors' => array(
                        '{{WRAPPER}} div.wdt-logo-container img' => 'max-width: {{VALUE}}px; width: {{VALUE}}px;'
                    ),
    			) );

    			$this->add_control( 'logo_text', array(
    				'label'     => esc_html__( 'Site Title', 'xoha-plus' ),
    				'type'      => Controls_Manager::TEXT,
    				'default'   => get_bloginfo ( 'name' ),
    				'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
    			) );

    			$this->add_control( 'logo_tagline', array(
    				'label'     => esc_html__( 'Site Tagline', 'xoha-plus' ),
    				'type'      => Controls_Manager::TEXT,
    				'default'   => get_bloginfo ( 'description' ),
    				'condition' => array( 'logo_type' => array( 'text-desc' ) )
    			) );

            $this->add_responsive_control( 'item_align', array(
                'label'        => esc_html__( 'Alignment?', 'xoha-plus' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','xoha-plus'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','xoha-plus'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','xoha-plus'), 'icon' => 'eicon-h-align-right' ),
                )
            ) );

        $this->end_controls_section();

        $this->start_controls_section( 'wdt_section_color', array(
            'label' => esc_html__( 'Color', 'xoha-plus'),
        	'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
        ) );

			$this->add_control( 'site_title_color_info', array(
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Site Title Color', 'xoha-plus' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			));

            $this->add_control( 'default_item_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Item Color', 'xoha-plus'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'xoha-plus'),
                    'secondary_color' => esc_html__('Theme Secondary', 'xoha-plus'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'xoha-plus'),
                    'custom'		  => esc_html__('Custom Color', 'xoha-plus'),
                    'none'			  => esc_html__('None', 'xoha-plus')
                ),
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

            $this->add_control( 'default_bg_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('BG Color', 'xoha-plus'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'xoha-plus'),
                    'secondary_color' => esc_html__('Theme Secondary', 'xoha-plus'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'xoha-plus'),
                    'custom'		  => esc_html__('Custom Color', 'xoha-plus'),
                    'none'			  => esc_html__('None', 'xoha-plus')
                ),
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

            $this->add_control( 'default_border_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Border Color', 'xoha-plus'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'xoha-plus'),
                    'secondary_color' => esc_html__('Theme Secondary', 'xoha-plus'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'xoha-plus'),
                    'custom'		  => esc_html__('Custom Color', 'xoha-plus'),
                    'none'			  => esc_html__('None', 'xoha-plus')
                ),
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

			$this->add_control( 'default_custom_item_color', array(
				'label'     => esc_html__( 'Item Color', 'xoha-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div.wdt-logo-container .site-title' => 'color: {{VALUE}}' ),
				'condition' => array( 'default_item_color' => array( 'custom' ) )
			) );

			$this->add_control( 'default_custom_bg_color', array(
				'label'     => esc_html__( 'BG Color', 'xoha-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div.wdt-logo-container .site-title' => 'background-color: {{VALUE}}' ),
				'condition' => array( 'default_bg_color' => array( 'custom' ) )
			) );

			$this->add_control( 'default_custom_border_color', array(
				'label'     => esc_html__( 'Border Color', 'xoha-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#c50000',
				'selectors' => array( '{{WRAPPER}} div.wdt-logo-container .site-title' => 'border-color: {{VALUE}}' ),
				'condition' => array( 'default_border_color' => array( 'custom' ) )
			) );

			$this->add_control( 'site_desc_color_info', array(
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Site Description Color', 'xoha-plus' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => array( 'logo_type' => array( 'text-desc' ) )
			));

            $this->add_control( 'desc_default_item_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Item Color', 'xoha-plus'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'xoha-plus'),
                    'secondary_color' => esc_html__('Theme Secondary', 'xoha-plus'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'xoha-plus'),
                    'custom'		  => esc_html__('Custom Color', 'xoha-plus'),
                    'none'			  => esc_html__('None', 'xoha-plus')
                ),
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

            $this->add_control( 'desc_default_bg_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('BG Color', 'xoha-plus'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'xoha-plus'),
                    'secondary_color' => esc_html__('Theme Secondary', 'xoha-plus'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'xoha-plus'),
                    'custom'		  => esc_html__('Custom Color', 'xoha-plus'),
                    'none'			  => esc_html__('None', 'xoha-plus')
                ),
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

            $this->add_control( 'desc_default_border_color', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Border Color', 'xoha-plus'),
                'default' => 'none',
                'options' => array(
                    'primary_color'   => esc_html__('Theme Primary', 'xoha-plus'),
                    'secondary_color' => esc_html__('Theme Secondary', 'xoha-plus'),
                    'tertiary_color'  => esc_html__('Theme Tertiary', 'xoha-plus'),
                    'custom'		  => esc_html__('Custom Color', 'xoha-plus'),
                    'none'			  => esc_html__('None', 'xoha-plus')
                ),
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

			$this->add_control( 'desc_default_custom_item_color', array(
				'label'     => esc_html__( 'Item Color', 'xoha-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div.wdt-logo-container .site-description' => 'color: {{VALUE}}' ),
				'condition' => array( 'desc_default_item_color' => array( 'custom' ), 'logo_type' => array( 'text-desc' ) )
			) );

			$this->add_control( 'desc_default_custom_bg_color', array(
				'label'     => esc_html__( 'BG Color', 'xoha-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#da0000',
				'selectors' => array( '{{WRAPPER}} div.wdt-logo-container .site-description' => 'background-color: {{VALUE}}' ),
				'condition' => array( 'desc_default_bg_color' => array( 'custom' ), 'logo_type' => array( 'text-desc' ) )
			) );

			$this->add_control( 'desc_default_custom_border_color', array(
				'label'     => esc_html__( 'Border Color', 'xoha-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#c50000',
				'selectors' => array( '{{WRAPPER}} div.wdt-logo-container .site-description' => 'border-color: {{VALUE}}' ),
				'condition' => array( 'desc_default_border_color' => array( 'custom' ), 'logo_type' => array( 'text-desc' ) )
			) );

        $this->end_controls_section();

        $this->start_controls_section( 'wdt_section_typhography', array(
            'label' => esc_html__( 'Typography', 'xoha-plus'),
        	'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
        ) );

            $this->add_control( 'use_theme_fonts', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Use theme default font family?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => array( 'logo_type' => array( 'text', 'text-desc' ) )
            ) );

 			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'     => esc_html__('Site Title', 'xoha-plus'),
				'name'      => 'site_title_typo',
				'selector'  => '{{WRAPPER}} div.wdt-logo-container .site-title',
				'condition' => array( 'use_theme_fonts!' => 'yes' )
			) );

            $this->add_control( 'use_theme_fonts_desc', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Use theme default font family?', 'xoha-plus'),
                'label_on'     => esc_html__( 'Yes', 'xoha-plus' ),
                'label_off'    => esc_html__( 'No', 'xoha-plus' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => array( 'logo_type' => array( 'text-desc' ) )
            ) );

 			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'     => esc_html__('Site Description', 'xoha-plus'),
				'name'      => 'site_desc_typo',
				'selector'  => '{{WRAPPER}} div.wdt-logo-container .site-description',
				'condition' => array( 'use_theme_fonts_desc!' => 'yes', 'logo_type' => array( 'text-desc' ) )
			) );

		$this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        extract($settings);

		$output = '';

        if($_element_id != '') {
            $el_id = 'xoha-'.esc_attr($_element_id);
        } else {
        	$el_id = 'xoha-'.esc_attr($this->get_id());
        }

        $css_classes = array(
            'wdt-logo-container'
        );

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

        # CUSTOM CSS
        $custom_css = '';
        $custom_css .= $this->xoha_generate_css( $settings );

        # OUTPUT
        $logo = '';

        if( ( $logo_type == 'text' || $logo_type == 'text-desc' ) && !empty( $logo_text ) ) {
            $logo .= !empty( $logo_text ) ?  '<span class="site-title">'. esc_html($logo_text) .'</span>' : '';
        }

        if( $logo_type == 'text-desc' && !empty( $logo_tagline ) ) {
            $logo .= !empty( $logo_tagline ) ?  '<i class="site-description">' . esc_html($logo_tagline) . '</i>' : '';
        }

        if( $logo_type == 'theme-logo' ) {
            if( $theme_logo_type == 'logo' ) {
                $logo = get_theme_mod( 'custom_logo' );
                $url  = wp_get_attachment_image_url( $logo, 'full' );

                if( empty( $url ) ) {
                    $url = XOHA_ROOT_URI.'/assets/images/logo.png';
                }
            } elseif( $theme_logo_type == 'light-logo' ) {
                $alogo = xoha_customizer_settings( 'custom_alt_logo' );
                $url = wp_get_attachment_image_url( $alogo, 'full' );
                if( empty( $url ) ) {
                    $url = XOHA_ROOT_URI.'/assets/images/light-logo.png';
                }
            }

            $logo = '<img src="'.esc_url( $url ).'" alt="'.esc_attr( get_bloginfo('name') ).'"/>';
        }

        if( $logo_type == 'custom-image' ) {
            $logo = wp_get_attachment_image($image['id'], 'full');
        }

        $output .= '<div id="' . esc_attr($el_id) . '" class="' . esc_attr($css_class) . '">';
        $output .= '  <a href="'.esc_url( home_url( '/' ) ).'" rel="home">'.xoha_html_output($logo).'</a>';
        $output .= '</div>';

        if( !empty( $custom_css ) ) {
            $this->xoha_print_css( $custom_css );
        }

        echo xoha_html_output($output);
	}

	function xoha_generate_css( $attrs ) {

        $css = $breakpoint_css = '';

        if(isset( $attrs['_element_id'] ) && $attrs['_element_id'] != '') {
            $attrs['el_id'] = 'xoha-'.esc_attr($attrs['_element_id']);
        } else {
        	$attrs['el_id'] = 'xoha-'.esc_attr($this->get_id());
        }

        if( ( $attrs['logo_type'] == 'text' || $attrs['logo_type'] == 'text-desc' ) && !empty( $attrs['logo_text'] ) ) {

            $font_style = '';

            # Color
            $t_color = '';
            if( $attrs['default_item_color'] == 'custom' &&  !empty( $attrs['default_custom_item_color'] ) ) {
                $t_color = $attrs['default_custom_item_color'];
            } else {
                $t_color = $this->xoha_current_skin( $attrs['default_item_color'] );
            }
            $font_style .= ( !empty( $t_color ) ) ? 'color:'.esc_attr($t_color).';' : '';

            # BG Color
            $t_bg_color = '';
            if( $attrs['default_bg_color'] == 'custom' &&  !empty( $attrs['default_custom_bg_color'] ) ) {
                $t_bg_color = $attrs['default_custom_bg_color'];
            } else {
                $t_bg_color = $this->xoha_current_skin( $attrs['default_bg_color'] );
            }
            $font_style .= ( !empty( $t_bg_color ) ) ? 'background-color:'.esc_attr($t_bg_color).'; padding:4px;' : '';

            # Border Color
            $t_border_color = '';
            if( $attrs['default_border_color'] == 'custom' &&  !empty( $attrs['default_custom_border_color'] ) ) {
                $t_border_color = $attrs['default_custom_border_color'];
            } else {
                $t_border_color = $this->xoha_current_skin( $attrs['default_border_color'] );
            }
            $font_style .= ( !empty( $t_border_color ) ) ? 'border-style:solid; border-width:1px; border-color:'.esc_attr($t_border_color).'; ' : '';

            $css .= !empty( $font_style ) ? "\n".'div#'.esc_attr( $attrs['el_id'] ).' .site-title {'.esc_attr($font_style).'}' : '';
        }

        if( $attrs['logo_type'] == 'text-desc' && !empty( $attrs['logo_tagline'] ) ) {

            $font_style = '';

            # Color
            $t_color = '';
            if( $attrs['desc_default_item_color'] == 'custom' &&  !empty( $attrs['desc_default_custom_item_color'] ) ) {
                $t_color = $attrs['desc_default_custom_item_color'];
            } else {
                $t_color = $this->xoha_current_skin( $attrs['desc_default_item_color'] );
            }
            $font_style .= ( !empty( $t_color ) ) ? 'color:'.esc_attr($t_color).';' : '';

            # BG Color
            $t_bg_color = '';
            if( $attrs['desc_default_bg_color'] == 'custom' &&  !empty( $attrs['desc_default_custom_bg_color'] ) ) {
                $t_bg_color = $attrs['desc_default_custom_bg_color'];
            } else {
                $t_bg_color = $this->xoha_current_skin( $attrs['desc_default_bg_color'] );
            }
            $font_style .= ( !empty( $t_bg_color ) ) ? 'background-color:'.esc_attr($t_bg_color).'; padding:4px;' : '';

            # Border Color
            $t_border_color = '';
            if( $attrs['desc_default_border_color'] == 'custom' &&  !empty( $attrs['desc_default_custom_border_color'] ) ) {
                $t_border_color = $attrs['desc_default_custom_border_color'];
            } else {
                $t_border_color = $this->xoha_current_skin( $attrs['desc_default_border_color'] );
            }
            $font_style .= ( !empty( $t_border_color ) ) ? 'border-style:solid; border-width:1px; border-color:'.esc_attr($t_border_color).'; ' : '';

            $css .= !empty( $font_style ) ? "\n".'div#'.esc_attr( $attrs['el_id'] ).' .site-description {'.esc_attr($font_style).'}' : '';
        }

        return $css;
    }

    function xoha_print_css( $css ) {

        if( !empty( $css ) ) {
            wp_register_style( 'wdt-elementor-logo-inline', '', array (), XOHA_PLUS_VERSION, 'all' );
            wp_enqueue_style( 'wdt-elementor-logo-inline' );
            wp_add_inline_style( 'wdt-elementor-logo-inline', $css );
        }
    }

    function xoha_current_skin( $code = 'primary_color' ) {

        $color = '';
        $mode  = xoha_customizer_settings( 'use_predefined_skin' );

        if( $mode ) {
            $skin  = xoha_customizer_settings( 'predefined_skin' );
            $skin  = xoha_customizer_settings( $skin );
            $color = $skin[$code];
        } else {
            $color = xoha_customizer_settings( $code );
        }

        return $color;
    }

}