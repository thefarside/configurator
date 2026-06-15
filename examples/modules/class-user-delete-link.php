<?php
/**
 * Module Name: User Delete Link
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-user-delete-link.php
 * Version: 0.0.1
 * Description: Removes the delete link for users under All Users.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class User_Delete_Link {

	public static function initialize() : void {
		add_filter( 'user_row_actions', array( static::class, 'remove_delete_action' ), PHP_INT_MAX, 1 );
		add_filter( 'bulk_actions-users', array( static::class, 'remove_delete_action' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_delete_action( array $rows ) : array {
		unset( $rows['delete'] );
		return $rows;
	}
}