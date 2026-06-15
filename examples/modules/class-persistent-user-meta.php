<?php
/**
 * Module Name: Persistent User Meta
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-persistent-user-meta.php
 * Version: 0.0.1
 * Description: Force all users to use specific settings, regardless of profile configuration.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Persistent_User_Meta {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'set_user_meta' ), PHP_INT_MAX );
		return;
	}

	public static function set_user_meta() : void {
		$user_meta = apply_filters( 'set_persistent_user_meta', array() );
		foreach ( $user_meta as $key => $value ) {
			update_user_meta( get_current_user_id(), $key, $value );
		}
		return;
	}
}