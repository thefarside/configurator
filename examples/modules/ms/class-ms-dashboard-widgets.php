<?php
/**
 * Module Name: MS Dashboard Widgets
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-dashboard-widgets.php
 * Version: 0.0.1
 * Description: Disables all the default widgets on the network dashboard.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\MS;

class MS_Dashboard_Widgets {

	public static function initialize() : void {
		add_action( 'wp_network_dashboard_setup', array( static::class, 'remove_network_widgets' ), PHP_INT_MAX );
		return;
	}

	public static function remove_network_widgets() : void {
		remove_meta_box( 'network_dashboard_right_now', 'dashboard-network', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard-network', 'side' );
		return;
	}
}