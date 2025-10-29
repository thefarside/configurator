<?php

namespace Configurator\Modules\MS;

class MS_Profile_Name_Full_Name {

	public static function initialize() : void {
		add_filter( 'wpmu_users_columns', array( static::class, 'revise_users_column' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_site-users-network_columns', array( static::class, 'revise_users_column' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function revise_users_column( array $columns ) : array {
		unset( $columns['name'] );
		return $columns;
	}
}