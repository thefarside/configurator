<?php

namespace Configurator\Modules\WC\FSE;

use WP_Block_Patterns_Registry;

class WC_FSE_Editor_Patterns {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'unregister_editor_patterns' ), PHP_INT_MAX );
	}

	public static function unregister_editor_patterns() : void {
		$wc_patterns  = array(
			'woocommerce-blocks/banner',
			'woocommerce-blocks/discount-banner-with-image',
			'woocommerce-blocks/discount-banner',
			'woocommerce-blocks/featured-category-cover-image',
			'woocommerce-blocks/featured-category-focus',
			'woocommerce-blocks/featured-category-triple',
			'woocommerce-blocks/featured-products-fresh-and-tasty',
			'woocommerce-blocks/product-filters',
			'woocommerce-blocks/footer-large-dark',
			'woocommerce-blocks/footer-large',
			'woocommerce-blocks/footer-simple-dark',
			'woocommerce-blocks/footer-simple-menu',
			'woocommerce-blocks/footer-simple',
			'woocommerce-blocks/footer-with-2-menus-dark',
			'woocommerce-blocks/footer-with-2-menus',
			'woocommerce-blocks/footer-with-3-menus',
			'woocommerce-blocks/header-centered-menu',
			'woocommerce-blocks/header-essential-dark',
			'woocommerce-blocks/header-essential',
			'woocommerce-blocks/header-large-dark',
			'woocommerce-blocks/header-large',
			'woocommerce-blocks/header-minimal',
			'woocommerce-blocks/hero-product-3-split',
			'woocommerce-blocks/hero-product-chessboard',
			'woocommerce-blocks/hero-product-split',
			'woocommerce-blocks/just-arrived-full-hero',
			'woocommerce/no-products-found-clear-filters',
			'woocommerce/no-products-found',
			'woocommerce-blocks/product-collection-3-columns',
			'woocommerce-blocks/product-collection-4-columns',
			'woocommerce-blocks/product-collection-5-columns',
			'woocommerce-blocks/product-collection-banner',
			'woocommerce-blocks/product-collection-featured-products-5-columns',
			'woocommerce-blocks/product-collection-full-grid',
			'woocommerce-blocks/product-collection-grid',
			'woocommerce-blocks/product-collection-rows',
			'woocommerce-blocks/product-collection-simple-grid',
			'woocommerce-blocks/product-collections-featured-collection',
			'woocommerce-blocks/product-collections-featured-collections',
			'woocommerce-blocks/product-collections-newest-arrivals',
			'woocommerce-blocks/product-details-listing',
			'woocommerce-blocks/product-details-pattern',
			'woocommerce-blocks/featured-products-2-cols',
			'woocommerce-blocks/product-hero-2-col-2-row',
			'woocommerce-blocks/product-hero',
			'woocommerce-blocks/product-listing-with-gallery-and-description',
			'woocommerce-blocks/product-query-4-column-product-row',
			'woocommerce-blocks/product-query-large-image-product-gallery',
			'woocommerce-blocks/product-query-minimal-product-list',
			'woocommerce-blocks/product-query-product-gallery',
			'woocommerce-blocks/product-query-product-list-with-1-1-images',
			'woocommerce-blocks/product-query-product-list-with-full-product-description',
			'woocommerce/product-search-form',
			'woocommerce-blocks/related-products',
			'woocommerce-blocks/shop-by-price',
			'woocommerce-blocks/small-discount-banner-with-image',
			'woocommerce-blocks/social-follow-us-in-social-media',
			'woocommerce-blocks/alt-image-and-text',
			'woocommerce-blocks/testimonials-3-columns',
			'woocommerce-blocks/testimonials-single',
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