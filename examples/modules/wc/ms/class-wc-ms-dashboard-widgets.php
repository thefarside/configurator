<?php
/**
 * Module Name: WC MS Dashboard Widgets
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/ms/class-wc-ms-dashboard-widgets.php
 * Version: 0.0.1
 * Description: Disables all WooCommerce widgets on the network dashboard.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\WC\MS;

class WC_MS_Dashboard_Widgets {

	public static function initialize() : void {
		add_action( 'wp_dashboard_setup', array( static::class, 'remove_network_widgets' ), PHP_INT_MAX );
		return;
	}

	public static function remove_network_widgets() : void {
		remove_meta_box( 'woocommerce_network_orders', 'dashboard', 'normal' );
		return;
	}
}