<?php

namespace Configurator\Modules\WC;

class WC_Order_Attribution {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_order_attribution' ), PHP_INT_MAX );
		add_filter( 'woocommerce_settings_features', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_settings( array $features_controller ) : array {
		return array_filter( $features_controller, function( array $feature ) : bool {
			return ! in_array( $feature['id'], array( 'woocommerce_feature_order_attribution_enabled' ) );
		} );
	}

	public static function disable_order_attribution() : void {
		update_option( 'woocommerce_feature_order_attribution_enabled', 'no' );
		return;
	}
}