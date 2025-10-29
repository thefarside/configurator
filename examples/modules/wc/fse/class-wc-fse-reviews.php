<?php

namespace Configurator\Modules\WC\FSE;

class WC_FSE_Reviews {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		return array_merge( $blocks, array(
			'woocommerce/product-rating-stars',
			'woocommerce/product-rating-counter',
			'woocommerce/product-average-rating',
			'woocommerce/all-reviews',
			'woocommerce/product-top-rated',
			'woocommerce/rating-filter',
			//'woocommerce/filter-wrapper',
			'woocommerce/reviews-by-category',
			'woocommerce/reviews-by-product',
			'woocommerce/product-rating',
		) );
	}
}