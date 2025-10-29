<?php

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