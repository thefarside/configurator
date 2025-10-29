<?php

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