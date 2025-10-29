<?php

namespace Configurator\Modules\WC;

class WC_Custom_Fields {

	public static string $foobar = '';

	public static function initialize() : void {
		add_action( 'add_meta_boxes', array( static::class, 'remove_meta_boxes' ), PHP_INT_MAX );
		add_action( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_new_product_editor_feature' ), PHP_INT_MAX, 1 );
	}

	public static function remove_meta_boxes() : void {
		remove_meta_box( 'postcustom', 'product', 'normal' );
		remove_meta_box( 'order_custom', 'woocommerce_page_wc-orders', 'normal' );
		return;
	}

	public static function disable_new_product_editor_feature( array $features ) : array {
		$features['product-custom-fields'] = false;
		return $features;
	}
}