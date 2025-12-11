<?php
/**
 * Module Name: MS Customizer
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-customizer.php
 * Version: 0.0.1
 * Description: Removes the multisite specific "Appearance > Customize" admin menu item that appears for non-FSE themes.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\MS;

class MS_Customizer {

	public static function initialize() : void {
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_pages' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_menu_pages() : void {
		remove_submenu_page( 'themes.php', 'customize.php?return=' . urlencode( $_SERVER['REQUEST_URI'] ) );
		return;
	}
}