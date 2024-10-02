<?php
if ( ! function_exists( 'xoha_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 */
	function xoha_template_part( $module, $template, $slug = '', $params = array() ) {
		echo xoha_get_template_part( $module, $template, $slug, $params );
	}
}

if ( ! function_exists( 'xoha_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 */
	function xoha_get_template_part( $module, $template, $slug = '', $params = array() ) {

		$file_path = '';
		$html      =  '';

		$template_path = XOHA_MODULE_DIR . '/' . $module;
		$temp_path = $template_path . '/' . $template;

		if ( ! empty( $temp_path ) ) {
			if ( ! empty( $slug ) ) {
				$file_path = "{$temp_path}-{$slug}.php";
				if ( ! file_exists( $file_path ) ) {
					$file_path = $temp_path . '.php';
				}
			} else {
				$file_path = $temp_path . '.php';
			}
		}

		$file_path = apply_filters( 'xoha_get_template_plugin_part', $file_path, $module, $template, $slug);

		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}

		if ( $file_path && file_exists( $file_path ) ) {
			ob_start();
			include( $file_path );
			$html = ob_get_clean();
		}

		return $html;
	}
}

if ( ! function_exists( 'xoha_get_page_id' ) ) {
	function xoha_get_page_id() {

		$page_id = get_queried_object_id();

		if( is_archive() || is_search() || is_404() || ( is_front_page() && is_home() ) ) {
			$page_id = -1;
		}

		return $page_id;
	}
}

/* Convert hexdec color string to rgb(a) string */
if ( ! function_exists( 'xoha_hex2rgba' ) ) {
	function xoha_hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		if(empty($color)) {
			return $default;
		}

		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
				return $default;
		}

		$rgb =  array_map('hexdec', $hex);

		if($opacity){
			if(abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = implode(",",$rgb).','.$opacity;
		} else {
			$output = implode(",",$rgb);
		}

		return $output;

	}
}

if ( ! function_exists( 'xoha_html_output' ) ) {
	function xoha_html_output( $html ) {
		return apply_filters( 'xoha_html_output', $html );
	}
}


if ( ! function_exists( 'xoha_theme_defaults' ) ) {
	/**
	 * Function to load default values
	 */
	function xoha_theme_defaults() {

		$defaults = array (
			'primary_color' => '#0a6375',
			'primary_color_rgb' => xoha_hex2rgba('#0a6375', false),
			'secondary_color' => '#f6b7ab',
			'secondary_color_rgb' => xoha_hex2rgba('#f6b7ab', false),
			'tertiary_color' => '#ffefe4',
			'tertiary_color_rgb' => xoha_hex2rgba('#ffefe4', false),
			'body_bg_color' => '#ffffff',
			'body_bg_color_rgb' => xoha_hex2rgba('#ffffff', false),
			'body_text_color' => '#6D6F79',
			'body_text_color_rgb' => xoha_hex2rgba('#6D6F79', false),
			'headalt_color' => '#060f11',
			'headalt_color_rgb' => xoha_hex2rgba('#060f11', false),
			'link_color' => '#060f11',
			'link_color_rgb' => xoha_hex2rgba('#060f11', false),
			'link_hover_color' => '#0a6375',
			'link_hover_color_rgb' => xoha_hex2rgba('#0a6375', false),
			'border_color' => '#a8a4a0',
			'border_color_rgb' => xoha_hex2rgba('#a8a4a0', false),
			'accent_text_color' => '#ffffff',
			'accent_text_color_rgb' => xoha_hex2rgba('#ffffff', false),

			'body_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 400,
				'fs-desktop' => 18,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.5,
				'lh-desktop-unit' => ''
			),
			'h1_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 700,
				'fs-desktop' => 80,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.3,
				'lh-desktop-unit' => ''
			),
			'h2_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 700,
				'fs-desktop' => 60,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.3,
				'lh-desktop-unit' => ''
			),
			'h3_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 700,
				'fs-desktop' => 45,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.3,
				'lh-desktop-unit' => ''
			),
			'h4_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 700,
				'fs-desktop' => 40,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.3,
				'lh-desktop-unit' => ''
			),
			'h5_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 700,
				'fs-desktop' => 30,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.3,
				'lh-desktop-unit' => ''
			),
			'h6_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 700,
				'fs-desktop' => 24,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.3,
				'lh-desktop-unit' => ''
			),
			'extra_typo' => array (
				'font-family' => "Outfit",
				'font-fallback' => '"Outfit", sans-serif',
				'font-weight' => 500,
				'fs-desktop' => 18,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.1,
				'lh-desktop-unit' => ''
			),

		);

		return $defaults;

	}
}