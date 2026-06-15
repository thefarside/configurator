<?php
/**
 * Module Name: Site Editor
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-site-editor.php
 * Version: 0.0.1
 * Description: Removes and disables the "Appearance > Editor" menu item and page.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Site_Editor {

	public static function initialize() : void {
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_page' ), PHP_INT_MAX );
		add_filter( 'set_302-site-editor.php', array( static::class, 'disable_endpoint' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_admin_menu_page() : void {
		remove_submenu_page( 'themes.php', 'site-editor.php' );
		return;
	}

	public static function disable_endpoint( string $url ) : string {
		if ( ! $url ) {
			return admin_url( 'themes.php' );
		}
		return $url;
	}
}