<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Xoha WordPress theme
 */

function xoha_tgmpa_plugins_register() {

	// Get array of recommended plugins.

    $theme_required_plugin_lists = array();
    $url = 'https://api.wordpress.org/plugins/info/1.0/unyson';
    $api_response = wp_remote_get( $url );
    if ( is_array( $api_response ) && ! is_wp_error( $api_response ) ) {
        if( isset($api_response['response']) && !empty($api_response['response']) ) {
            if ( 404 == $api_response['response']['code'] && 'Not Found' == $api_response['response']['message'] ) {
                $unyson_plugin = array(
                    array(
                        'name'               => esc_html__('Unyson', 'xoha'),
                        'slug'               => 'unyson',
                        'source'             => XOHA_MODULE_DIR . '/plugins/unyson.zip',
                        'required'           => true,
                        'version'            => '2.7.28',
                        'force_activation'   => false,
                        'force_deactivation' => false,
                    )
                );
            } else {
                $unyson_plugin = array(
                    array(
                        'name'     => esc_html__('Unyson', 'xoha'),
                        'slug'     => 'unyson',
                        'required' => true,
                    )
                );
            }
        }
    }

	$plugins_list = array(
        array(
            'name'               => esc_html__('Xoha Plus', 'xoha'),
            'slug'               => 'xoha-plus',
            'source'             => XOHA_MODULE_DIR . '/plugins/xoha-plus.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Xoha Pro', 'xoha'),
            'slug'               => 'xoha-pro',
            'source'             => XOHA_MODULE_DIR . '/plugins/xoha-pro.zip',
            'required'           => true,
            'version'            => '1.0.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Elementor', 'xoha'),
            'slug'     => 'elementor',
            'required' => true,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Elementor Addon', 'xoha'),
            'slug'               => 'wedesigntech-elementor-addon',
            'source'             => XOHA_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.zip',
            'required'           => true,
            'version'            => '1.0.3',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Portfolio', 'xoha'),
            'slug'               => 'wedesigntech-portfolio',
            'source'             => XOHA_MODULE_DIR . '/plugins/wedesigntech-portfolio.zip',
            'required'           => true,
            'version'            => '1.0.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Contact Form 7', 'xoha'),
            'slug'     => 'contact-form-7',
            'required' => true,
        )
	);

    $theme_required_plugin_lists = array_merge( $unyson_plugin, $plugins_list );
    $plugins = apply_filters('xoha_required_plugins_list', $theme_required_plugin_lists);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'xoha_theme',
		'domain'       => 'xoha',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'xoha_tgmpa_plugins_register' );