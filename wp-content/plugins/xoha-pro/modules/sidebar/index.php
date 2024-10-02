<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !class_exists( 'XohaProSidebar' ) ) {
    class XohaProSidebar {

        private static $_instance = null;
        private $global_layout  = '';
        private $global_sidebar = '';
        private $hide_standard_sidebar   = '';

        private $sidebar_post_types = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->global_layout  = xoha_customizer_settings('global_sidebar_layout');
            $this->global_sidebar = xoha_customizer_settings('global_sidebar');
            $this->hide_standard_sidebar = xoha_customizer_settings('hide_standard_sidebar');

            if(empty( $this->global_sidebar ) && $this->hide_standard_sidebar){
                $this->global_layout = 'content-full-width';
            }

            $this->sidebar_post_types = apply_filters( 'sidebar_post_types', array( 'post', 'page') );

            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once XOHA_PRO_DIR_PATH.'modules/sidebar/customizer/index.php';
            include_once XOHA_PRO_DIR_PATH.'modules/sidebar/metabox/index.php';
        }

        function frontend() {
            add_action('xoha_after_main_css', array( $this, 'enqueue_assets' ) );
            add_filter('xoha_primary_classes', array( $this, 'primary_classes' ), 20 );
            add_filter('xoha_secondary_classes', array( $this, 'secondary_classes' ), 20 );
            add_filter('xoha_active_sidebars', array( $this, 'active_sidebars' ), 20 );
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-sidebar', XOHA_PRO_DIR_URL . 'modules/sidebar/assets/css/sidebar.css', false, XOHA_PRO_VERSION, 'all' );
        }

        function primary_classes( $primary_class ) {

            if( is_singular( $this->sidebar_post_types )  ) {
                $settings = get_post_meta( get_queried_object_id(), '_xoha_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'content-full-width' ) {
                        $primary_class = 'content-full-width';
                    }elseif( $settings['layout'] == 'with-left-sidebar' || $settings['layout'] == 'with-right-sidebar' ) {
                        $sidebars      = isset( $settings['sidebars'] ) ? $settings['sidebars'] : array();
                        $primary_class = count( $sidebars ) ? $settings['layout'] : 'content-full-width';
                    }elseif( $settings['layout'] == 'global-sidebar-layout' ) {
                        $primary_class = $this->global_layout;
                    }
                } else {
                    $primary_class = $this->global_layout;
                }
            } else if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') ) {
                $primary_class = $this->global_layout;
            }

            if( $primary_class == 'with-left-sidebar' ) {
                $primary_class = 'page-with-sidebar with-left-sidebar';
            }elseif( $primary_class == 'with-right-sidebar' ) {
                $primary_class = 'page-with-sidebar with-right-sidebar';
            }

            return $primary_class;
        }

        function secondary_classes( $secondary_class ) {
            if( is_singular( $this->sidebar_post_types )  ) {
                $settings = get_post_meta( get_queried_object_id(), '_xoha_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'global-sidebar-layout' ) {
                        $secondary_class = $this->global_layout;
                    } else {
                        $sidebars      = isset( $settings['sidebars'] ) ? $settings['sidebars'] : array();
                        $secondary_class = count( $sidebars ) ? $settings['layout'] : '';
                    }
                } else{
                    $secondary_class = $this->global_layout;
                }
            } else if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') ) {
            	$secondary_class = $this->global_layout;
            }

            if( $secondary_class == 'with-left-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-left-sidebar';
            }elseif( $secondary_class == 'with-right-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-right-sidebar';
            }

            return $secondary_class;
        }

        function active_sidebars( $sidebars = array() ) {

            if( is_singular( $this->sidebar_post_types )  ) {
                $settings = get_post_meta( get_queried_object_id(), '_xoha_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'global-sidebar-layout' ) {
                        $global_sidebar = $this->global_sidebar;
                        if( $global_sidebar ) {
                            $sidebars[] = $global_sidebar;
                        }
                        if($this->hide_standard_sidebar) {
                            unset($sidebars[array_search('xoha-standard-sidebar-1', $sidebars)]);
                        }
                    } else {
                        if(isset( $settings['sidebars'] )){
                            $sidebars = $settings['sidebars'];
                        }
                    }
                } else {
                    $sidebars[] = $this->global_sidebar;
                    if($this->hide_standard_sidebar) {
                        unset($sidebars[array_search('xoha-standard-sidebar-1', $sidebars)]);
                    }
                }
            } else if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') ) {
	            $global_sidebar = $this->global_sidebar;
	            if( $global_sidebar ) {
	                $sidebars[] = $global_sidebar;
	            }
                if($this->hide_standard_sidebar) {
                    unset($sidebars[array_search('xoha-standard-sidebar-1', $sidebars)]);
                }
            }

            return array_filter( $sidebars );

        }
    }
}

XohaProSidebar::instance();