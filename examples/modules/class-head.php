<?php
/**
 * Module Name: Head
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-head.php
 * Version: 0.0.1
 * Description: Facilitates adding entries to <head> site wide or by page.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules;

class Head {

	public static function initialize() : void {
		add_action( 'wp_head', array( static::class, 'append' ), 2 );
		add_action( 'admin_head', array( static::class, 'append' ), PHP_INT_MIN );
		add_action( 'login_head', array( static::class, 'append' ), PHP_INT_MIN );
		return;
	}

	public static function append() : void {
		$page = basename( $_SERVER['SCRIPT_NAME'] );
		$elements = array_merge( apply_filters( 'append_head', array() ), apply_filters( "append_head-{$page}", array() ) );
		foreach ( $elements as $element ) {
			echo $element;
		}
		return;
	}
}