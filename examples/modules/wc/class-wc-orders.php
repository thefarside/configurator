<?php

namespace Configurator\Modules\WC;

class WC_Orders {

	public static function initialize() : void {
		add_filter( 'woocommerce_account_menu_items', array( static::class, 'remove_account_menu_link' ), PHP_INT_MAX, 1 );
		add_filter( 'template_redirect', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		return;
	}

	public static function remove_account_menu_link( array $items ) : array {
		if ( ! wc_get_orders( array( 'customer_id' => get_current_user_id() ) ) ) {
			unset( $items['orders'] );
		}
		return $items;
	}

	public static function disable_endpoints() : void {
		if( is_wc_endpoint_url( 'orders' ) && ! wc_get_orders( array( 'customer_id' => get_current_user_id() ) ) ) {
			wp_safe_redirect( wc_get_account_endpoint_url( 'edit-account' ) );
		}
		return;
	}
}