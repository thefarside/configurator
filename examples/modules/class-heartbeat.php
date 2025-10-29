<?php

namespace Configurator\Modules;

class Heartbeat {

	public static function initialize() :void {
		add_action( 'admin_init', array( static::class, 'deregister' ), PHP_INT_MAX );
		return;
	}

	public static function deregister() : void {
		wp_deregister_script( 'heartbeat' );
		return;
	}
}