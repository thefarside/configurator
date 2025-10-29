<?php

namespace Configurator\Modules\WC;

class WC_Addresses {

	public static function initialize() : void {
		add_filter( 'woocommerce_account_menu_items', array( static::class, 'remove_account_menu_link' ), PHP_INT_MAX, 1 );
		add_filter( 'template_redirect', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_filter( 'woocommerce_customer_meta_fields', array( static::class, 'remove_user_edit_fields' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_account_menu_link( array $items ) : array {
		if ( ! wc_get_orders( array( 'customer_id' => get_current_user_id() ) ) ) {
			unset( $items['edit-address'] );
		}
		return $items;
	}

	public static function disable_endpoints() : void {
		if( is_wc_endpoint_url( 'edit-address' ) && ! wc_get_orders( array( 'customer_id' => get_current_user_id() ) ) ) {
			wp_safe_redirect( wc_get_account_endpoint_url( 'edit-account' ) );
		}
		return;
	}

	public static function remove_user_edit_fields( array $fields ) : array {
		$user_id = get_current_user_id();
		if ( isset( $_GET['user_id'] ) ) {
			$user_id = $_GET['user_id'];
		}
		if ( ! wc_get_orders( array( 'customer_id' => $user_id ) ) ) {
			unset( $fields['billing'] );
			unset( $fields['shipping'] );
		}
		return $fields;
	}
}