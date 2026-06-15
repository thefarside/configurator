<?php
/**
 * Module Name: Admin Notices
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-admin-notices.php
 * Version: 0.0.1
 * Description: Disables all admin notices in the admin area.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Admin_Notices {

	public static function initialize() : void  {
		add_action( 'admin_menu', array( static::class, 'remove_notices' ), PHP_INT_MAX );
		return;
	}

	public static function remove_notices() : void  {
		remove_all_actions( 'admin_notices' );
		return;
	}
}