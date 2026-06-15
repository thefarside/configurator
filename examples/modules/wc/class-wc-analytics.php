<?php
/**
 * Module Name: WC Analytics
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-analytics.php
 * Version: 0.0.1
 * Description: Disables WooCommerce "Analytics" and removes related GUI elements.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\WC;

class WC_Analytics {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_feature' ), PHP_INT_MAX, 1 );
		add_action( 'admin_init', array( static::class, 'disable_setting' ), PHP_INT_MAX );
		add_filter( 'woocommerce_settings_features', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_setting() : void {
		update_option( 'woocommerce_analytics_enabled', 'no' );
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