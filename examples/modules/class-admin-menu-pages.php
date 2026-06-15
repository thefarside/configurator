<?php
/**
 * Module Name: Admin Menu Pages
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-admin-menu-pages.php
 * Version: 0.0.1
 * Description: Filter out entries in the admin menu.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Admin_Menu_Pages {

	public static function initialize() : void {
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_pages' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_menu_pages() : void {
		$blacklist = apply_filters( 'admin_menu_pages_blacklist', array() );
		foreach ( $blacklist as $entry ) {
			if ( is_array( $entry ) ) {
				remove_submenu_page( $entry[0], $entry[1] );
			}
			if ( is_string( $entry ) ) {
				remove_menu_page( $entry );
			}
		}
		return;
	}
}