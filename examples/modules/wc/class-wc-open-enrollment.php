<?php

namespace Configurator\Modules\WC;

class WC_Open_Enrollment {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_settings' ), PHP_INT_MAX );
		add_filter( 'woocommerce_account_settings', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_settings() : void {
		update_option( 'woocommerce_enable_signup_and_login_from_checkout', 'no' );
		update_option( 'woocommerce_enable_myaccount_registration', 'no' );
		update_option( 'woocommerce_registration_generate_username', 'no' );
		update_option( 'woocommerce_registration_generate_password', 'no' );
		return;
	}

	public static function remove_settings( array $account_settings ) : array {
		$removals = array(
			'woocommerce_enable_signup_and_login_from_checkout',
			'woocommerce_enable_myaccount_registration',
			'woocommerce_registration_generate_username',
			'woocommerce_registration_generate_password',
		);
		foreach ( $account_settings as $index => $setting ) {
			if ( in_array( $setting['id'], $removals ) ) {
				unset( $account_settings[ $index ] );
			}
		}
		return $account_settings;
	}
}