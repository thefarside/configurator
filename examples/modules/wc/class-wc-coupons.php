<?php

namespace Configurator\Modules\WC;

class WC_Coupons {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_settings' ), PHP_INT_MAX );
		add_filter( 'woocommerce_general_settings', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_settings() : void {
		update_option( 'woocommerce_enable_coupons', 'no' );
		return;
	}

	public static function remove_settings( array $settings ) : array {
		return array_filter( $settings, function( array $setting ) : bool {
			return ! in_array( $setting['id'], array(
				'woocommerce_enable_coupons',
				'woocommerce_calc_discounts_sequentially',
			) );
		} );
	}
}