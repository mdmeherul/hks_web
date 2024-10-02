<?php
add_action( 'xoha_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'xoha-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, XOHA_THEME_VERSION, 'all');
}

add_action( 'xoha_footer', 'footer_content' );
function footer_content() {
    xoha_template_part( 'content', 'content', 'footer' );
}