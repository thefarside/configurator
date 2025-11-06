<?php

namespace Configurator\Modules\WC;

class WC_Dashboard {

	public static function initialize() : void {
		add_filter( 'woocommerce_account_menu_items', array( static::class, 'remove_account_menu_link' ), PHP_INT_MAX, 1 );
		add_filter( 'template_redirect', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		return;
	}

	public static function remove_account_menu_link( array $items ) : array {
		unset( $items['dashboard'] );
		return $items;
	}

	public static function disable_endpoints() : void {
		if ( ! function_exists( 'is_wc_endpoint_url' ) ) return;
		if ( is_account_page() && ! is_wc_endpoint_url() && is_user_logged_in() ) {
			$url = wc_get_account_endpoint_url( 'orders' );
			if ( ! wc_get_orders( array( 'customer_id' => get_current_user_id() ) ) ) {
				$url = wc_get_account_endpoint_url( 'edit-account' );
			}
			wp_safe_redirect( $url );
		}
		return;
	}
}