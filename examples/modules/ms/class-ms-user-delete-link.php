<?php
/**
 * Module Name: MS User Delete Link 
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-user-delete-link.php
 * Version: 0.0.1
 * Description: Extends Configurator\Modules\User_Delete_Link to include multisite fields and GUI elements.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\MS;

class MS_User_Delete_Link {

	public static function initialize() : void {
		add_filter( 'ms_user_row_actions', array( static::class, 'remove_delete_action' ), PHP_INT_MAX, 1 );
		add_filter( 'bulk_actions-users-network', array( static::class, 'remove_delete_action' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_delete_action( array $rows ) : array {
		unset( $rows['delete'] );
		return $rows;
	}
}