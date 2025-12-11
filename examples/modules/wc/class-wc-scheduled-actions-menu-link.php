<?php
/**
 * Module Name: WC Scheduled Actions Menu Link
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-scheduled-actions-menu-link.php
 * Version: 0.0.1
 * Description: Removes "Scheduled Actions" from the Tools menu.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\WC;

class WC_Scheduled_Actions_Menu_Link {

	public static function initialize() : void {
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_pages' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_menu_pages() : void {
		remove_submenu_page( 'tools.php', 'action-scheduler' );
		return;
	}
}