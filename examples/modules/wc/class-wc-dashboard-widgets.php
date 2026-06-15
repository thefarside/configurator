<?php
/**
 * Module Name: WC Dashboard Widgets
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-dashboard-widgets.php
 * Version: 0.0.1
 * Description: Disables all the default WooCommerce widgets on the dashboard.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\WC;

class WC_Dashboard_Widgets {

	public static function initialize() : void {
		add_action( 'wp_dashboard_setup', array( static::class, 'remove_widgets' ), PHP_INT_MAX );
		return;
	}

	public static function remove_widgets() : void {
		remove_meta_box( 'wc_admin_dashboard_setup', 'dashboard', 'normal' );
		remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal' );
		remove_meta_box( 'woocommerce_dashboard_recent_reviews', 'dashboard', 'normal' );
		return;
	}
}