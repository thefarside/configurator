<?php

namespace Configurator\Modules\WC;

use Configurator\Helpers\HTTP_Status_Codes;

class WC_Download_Permissions {

	public static function initialize() : void {
		add_action( 'add_meta_boxes', array( static::class, 'remove_meta_boxes' ), PHP_INT_MAX );
		add_filter( 'woocommerce_order_actions', array( static::class, 'remove_order_action' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_account_menu_items', array( static::class, 'remove_account_menu_link' ), PHP_INT_MAX, 1 );
		add_filter( 'template_redirect', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		return;
	}

	private static function order_has_downloads() : bool {
		if ( isset( $_GET['id'] ) ) {
			$order = wc_get_order( $_GET['id'] );
			if ( $order->get_downloadable_items() ) {
				return true;
			}
		}
		return false;
	}

	public static function remove_meta_boxes() : void {
		if ( ! static::order_has_downloads() ) {
			remove_meta_box( 'woocommerce-order-downloads', 'woocommerce_page_wc-orders', 'normal' );
		}
		return;
	}

	public static function remove_order_action( array $actions ) : array {
		if ( ! static::order_has_downloads() ) {
			unset( $actions['regenerate_download_permissions'] );
		}
		return $actions;
	}

	public static function remove_account_menu_link( array $items ) : array {
		if ( ! WC()->customer->get_downloadable_products() ) {
			unset( $items['downloads'] );
		}
		return $items;
	}

	public static function disable_endpoints() : void {
		if ( ! WC()->customer->get_downloadable_products() && is_wc_endpoint_url( 'downloads' ) ) {
			HTTP_Status_Codes::set_404();
		}
		return;
	}
}