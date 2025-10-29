<?php

namespace Configurator\Modules\WC;

class WC_Product_Block_Editor {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_feature' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_feature_setting', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
	}

	public static function disable_feature( array $features ) : array {
		$features['product-block-editor'] = false;
		return $features;
	}

	public static function remove_settings( array $feature_setting, string $feature_id ) : array {
		if ( 'product_block_editor' === $feature_id ) {
			return array();
		}
		return $feature_setting;
	}
}