<?php
/**
 * Module Name: User Logins
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-user-logins.php
 * Version: 0.0.1
 * Description: Prevents non-admin roles from being able to login.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: \WP_User, \WP_Error
 */

namespace Configurator\Modules;

use WP_User;
use WP_Error;

class User_Logins {

	public static function initialize() : void {
		add_filter( 'authenticate' , array( static::class, 'restrict_authentication' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function restrict_authentication( null|WP_User|WP_Error $user ) : WP_User|null {
		if ( isset( $user->roles ) && array_intersect( ['administrator'], $user->roles ) ) {
			return $user;
		}
		return null;
	}
}