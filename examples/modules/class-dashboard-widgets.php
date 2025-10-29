<?php

namespace Configurator\Modules;

class Dashboard_Widgets {

	public static function initialize() : void {
		add_action( 'wp_dashboard_setup', array( static::class, 'remove_widgets' ), PHP_INT_MAX );
		return;
	}

	public static function remove_widgets() : void {
		remove_action( 'welcome_panel', 'wp_welcome_panel' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
		return;
	}
}