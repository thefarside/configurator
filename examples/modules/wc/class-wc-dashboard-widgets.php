<?php

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