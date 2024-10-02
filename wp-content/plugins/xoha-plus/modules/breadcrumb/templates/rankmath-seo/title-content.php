<section class="main-title-section-wrapper <?php echo esc_attr( $wrapper_classes );?>">
    <div class="main-title-section-container">
        <div class="container">
            <div class="main-title-section"><?php echo xoha_breadcrumb_title();?></div>
            <?php echo xoha_breadcrumbs( array( 'text' => $home, 'link' => $home_link ), $delimiter );?>
            <div class="main-title-section-shape">
                <div class="main-title-section-shape-inner"></div>
            </div>
        </div>
    </div>
    <div class="main-title-section-bg"></div>
</section>