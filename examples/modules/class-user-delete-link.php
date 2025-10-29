<?php

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