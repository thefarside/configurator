<?php

namespace Configurator\Modules\WC;

use DOMDocument;

class WC_Analytics {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_feature' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_settings_features', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_feature( array $features ) : array {
		$features['analytics'] = false;
		return $features;
	}

	public static function remove_settings( array $features_controller ) : array {
		return array_filter( $features_controller, function( array $feature ) : bool {
			return ! in_array( $feature['id'], array( 'woocommerce_analytics_enabled' ) );
		} );
	}
}