<?php

namespace Configurator\Modules\MS;

class MS_User_Remove_Link {

	public static function initialize() : void {
		add_filter( 'user_row_actions', array( static::class, 'remove_remove_action' ), PHP_INT_MAX, 1 );
		add_filter( 'bulk_actions-users', array( static::class, 'remove_remove_action' ), PHP_INT_MAX, 1 );
		add_filter( 'bulk_actions-site-users-network', array( static::class, 'remove_remove_action' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_remove_action( array $rows ) : array {
		unset( $rows['remove'] );
		return $rows;
	}
}