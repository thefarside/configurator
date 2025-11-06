<?php

namespace Configurator\Modules\WC\FSE;

use WP_Block_Patterns_Registry;

class WC_FSE_Editor_Patterns {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'unregister_editor_patterns' ), PHP_INT_MAX );
		return;
	}

	public static function unregister_editor_patterns() : void {
		$wc_patterns  = array(
			'woocommerce-blocks/banner',
			'woocommerce-blocks/content-right-with-image-left',
			'woocommerce-blocks/featured-category-cover-image',
			'woocommerce-blocks/featured-category-triple',
			'woocommerce-blocks/footer-large',
			'woocommerce-blocks/footer-simple-menu',
			'woocommerce-blocks/footer-with-3-menus',
			'woocommerce-blocks/form-image-grid-content-left',
			'woocommerce-blocks/header-centered-menu',
			'woocommerce-blocks/header-distraction-free',
			'woocommerce-blocks/header-essential',
			'woocommerce-blocks/header-large',
			'woocommerce-blocks/header-minimal',
			'woocommerce-blocks/heading-with-three-columns-of-content-with-link',
			'woocommerce-blocks/hero-product-3-split',
			'woocommerce-blocks/hero-product-chessboard',
			'woocommerce-blocks/hero-product-split',
			'woocommerce-blocks/centered-content-with-image-below',
			'woocommerce-blocks/just-arrived-full-hero',
			'woocommerce/no-products-found-clear-filters',
			'woocommerce/no-products-found',
			'woocommerce/page-coming-soon-default',
			'woocommerce/page-coming-soon-image-gallery',
			'woocommerce/page-coming-soon-minimal-left-image',
			'woocommerce/page-coming-soon-modern-black',
			'woocommerce/page-coming-soon-split-right-image',
			'woocommerce/page-coming-soon-with-header-footer',
			'woocommerce-blocks/product-collection-3-columns',
			'woocommerce-blocks/product-collection-4-columns',
			'woocommerce-blocks/product-collection-5-columns',
			'woocommerce-blocks/product-collection-featured-products-5-columns',
			'woocommerce-blocks/product-query-product-gallery',
			'woocommerce/product-search-form',
			'woocommerce-blocks/related-products',
			'woocommerce-blocks/social-follow-us-in-social-media',
			'woocommerce-blocks/testimonials-3-columns',
			'woocommerce-blocks/testimonials-single',
			'woocommerce-blocks/three-columns-with-images-and-content',
		);
		$registry = WP_Block_Patterns_Registry::get_instance();
		$all_patterns  = array_column( $registry->get_all_registered(), 'slug' );
		$diff_patterns = array_intersect( $wc_patterns, $all_patterns );
		foreach ( $diff_patterns as $pattern ) {
			unregister_block_pattern( $pattern );
		}
		return;
	}
}