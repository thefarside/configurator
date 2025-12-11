<?php
/**
 * Module Name: MS Profile Name Full Name
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-profile-name-full-name.php
 * Version: 0.0.1
 * Description: Extends Configurator\Modules\Profile_Name_Full_Name to include multisite fields and GUI elements.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

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