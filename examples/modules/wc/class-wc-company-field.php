<?php

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