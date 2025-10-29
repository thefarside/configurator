<?php

namespace Configurator\Modules\WC;

class WC_Email_Insights {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_settings' ), PHP_INT_MAX );
		add_filter( 'woocommerce_email_settings', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_settings() : void {
		update_option( 'woocommerce_merchant_email_notifications', 'no' );
		return;
	}

	public static function remove_settings( array $settings ) : array {
		foreach ( $settings as $index => $setting ) {
			if ( isset( $setting['id'] ) && ( 'email_merchant_notes' === $setting['id'] || 'woocommerce_merchant_email_notifications' === $setting['id'] ) ) {
				unset( $settings[ $index ] );
			}
		}
		return $settings;
	}
}