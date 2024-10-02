<?php
namespace XohaElementor\Widgets;

use Elementor\Widget_Base;

abstract class XohaElementorWidgetBase extends Widget_Base {
	/**
	 * Get categories
	 */

	public function get_categories() {
		return [ 'xoha-widgets' ];
	}

	public function xoha_post_categories(){
		$terms = get_terms( array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
		));

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name;
			}
		}

		return $options;
	}

	public function xoha_get_elementor_page_list(){
		$pagelist = get_posts(array(
			'post_type' => 'elementor_library',
			'showposts' => 999,
		));

		if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
			foreach ( $pagelist as $post ) {
				$options[ $post->ID ] = esc_html__( $post->post_title, 'xoha-plus' );
			}
	        return $options;
		}
	}

	public function xoha_post_ids(){
		$posts = get_posts( array(
			'post_type'  => 'post',
			'post_status'=> 'publish',
			'numberposts' => -1
		));

		if ( ! empty( $posts ) && ! is_wp_error( $posts ) ){
			foreach ( $posts as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		return $options;
	}

}