<?php

namespace Configurator\Modules\WC;

class WC_Tracking {

	public static function initialize() : void {
		add_filter( 'woocommerce_apply_user_tracking', array( static::class, 'disable_tracking' ), PHP_INT_MAX );
		add_filter( 'woocommerce_com_integration_settings', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_tracking() : false {
		if ( 'yes' === get_option( 'woocommerce_allow_tracking' ) ) {
			update_option( 'woocommerce_allow_tracking', 'no' );
		}
		return false;
	}

	public static function remove_settings( array $settings ) : array {
		return array_filter( $settings, function( array $setting ) : bool {
			return ! in_array( $setting['id'], array( 'tracking_options', 'woocommerce_allow_tracking' ) );
		} );
	}
}