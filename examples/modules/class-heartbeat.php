<?php
/**
 * Module Name: Heartbeat
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-heartbeat.php
 * Version: 0.0.2
 * Description: Disables the WordPress heartbeat.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Heartbeat {

	public static function initialize() :void {
		add_action( 'admin_init', array( static::class, 'deregister' ), PHP_INT_MAX );
		add_filter( 'doing_it_wrong_trigger_error', array( static::class, 'unregister_error' ), PHP_INT_MAX, 3 );
		return;
	}

	public static function deregister() : void {
		wp_deregister_script( 'heartbeat' );
		return;
	}

	public static function unregister_error( bool $trigger, string $function_name, string $message ) : bool {
		if ( str_contains( $message, '"wp-auth-check" was enqueued with dependencies that are not registered' ) ||
			 str_contains( $message, '"autosave" was enqueued with dependencies that are not registered' )
		) {
			return false;
		}
		return $trigger;
	}

}