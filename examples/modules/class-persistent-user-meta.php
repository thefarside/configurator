<?php

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