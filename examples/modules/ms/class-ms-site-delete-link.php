<?php

namespace Configurator\Modules\MS;

class MS_Site_Delete_Link {

	public static function initialize() : void {
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_pages' ), PHP_INT_MAX );
		add_filter( 'set_302-ms-delete-site.php', array( static::class, 'disable_endpoint' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_admin_menu_pages() : void {
		remove_submenu_page( 'tools.php', 'ms-delete-site.php' );
		return;
	}

	public static function disable_endpoint( string $url ) : string {
		if ( ! $url ) {
			return admin_url();
		}
		return $url;
	}
}