<?php

namespace Configurator\Modules\WC\FSE;

class WC_FSE_Product_Tags {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		return array_merge( $blocks, array(
			'woocommerce/product-tag',
		) );
	}
}