<?php

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