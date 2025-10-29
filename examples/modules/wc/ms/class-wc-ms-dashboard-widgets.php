<?php

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