<?php
/**
 * Module Name: WC Legacy Reports
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-legacy-reports.php
 * Version: 0.0.1
 * Description: Rolls back WooCommerce "Reports" to the old version and fixes/removes warnings.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: \DOMDocument
 */

namespace Configurator\Modules\WC;

use DOMDocument;

class WC_Legacy_Reports {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'force_compatibility' ), PHP_INT_MAX );
		add_filter( 'woocommerce_settings_features', array( static::class, 'remove_setting' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-admin.php', array( static::class, 'remove_deprecated_message' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function force_compatibility() : void {
		if ( 'yes' === get_option( 'woocommerce_custom_orders_table_enabled' ) ) {
			update_option( 'woocommerce_custom_orders_table_data_sync_enabled', 'yes' );
		} else {
			update_option( 'woocommerce_custom_orders_table_data_sync_enabled', 'no' );
		}
		return;
	}

	public static function remove_setting( array $features_controller ) : array {
		foreach ( $features_controller as $index => $feature ) {
			if ( 'woocommerce_custom_orders_table_data_sync_enabled' === $feature['id'] ) {
				unset( $features_controller[ $index ] );
			}
		}
		return $features_controller;
	}

	public static function remove_deprecated_message( DOMDocument $document ) : DOMDocument {
		if ( isset( $_GET['page'] ) && 'wc-reports' === $_GET['page'] ) {
			$section = $document->getElementById( 'message' );
			$section?->remove();
		}
		return $document;
	}
}