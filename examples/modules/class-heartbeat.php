<?php
/**
 * Module Name: Heartbeat
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-heartbeat.php
 * Version: 0.0.1
 * Description: Disables the WordPress heartbeat.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

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