<?php
add_action( 'wp_enqueue_scripts', 'xoha_child_enqueue_styles', 100);
function xoha_child_enqueue_styles() {
	wp_enqueue_style( 'xoha-parent', get_theme_file_uri('/style.css') );
}