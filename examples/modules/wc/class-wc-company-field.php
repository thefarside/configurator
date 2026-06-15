<?php
/**
 * Module Name: WC Company Field
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-company-field.php
 * Version: 0.0.1
 * Description: Removes "Company" field from billing and shipping addresses on user accounts/profiles.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\WC;

class WC_Company_Field {

	public static function initialize() : void {
		add_filter( 'woocommerce_default_address_fields', array( static::class, 'remove_front_end_field' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_customer_meta_fields', array( static::class, 'remove_user_edit_fields' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_admin_billing_fields', array( static::class, 'remove_order_edit_field' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_admin_shipping_fields', array( static::class, 'remove_order_edit_field' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_front_end_field( array $fields ) : array {
		unset( $fields['company'] );
		return $fields;
	}

	public static function remove_user_edit_fields( array $fields ) : array {
		unset( $fields['billing']['fields']['billing_company'] );
		unset( $fields['shipping']['fields']['shipping_company'] );
		return $fields;
	}

	public static function remove_order_edit_field( array $fields ) : array {
		unset( $fields['company'] );
		return $fields;
	}
}