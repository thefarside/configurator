<?php
/**
 * Module Name: Referrer Meta
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-referrer-meta.php
 * Version: 0.0.1
 * Description: Removes <meta name="referrer"> from <head> on wp-login.php.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules;

class Referrer_Meta {

	public static function initialize() : void {
		add_action( 'login_head', array( static::class, 'reprioritize_login_head' ), PHP_INT_MIN );
		return;
	}

	public static function reprioritize_login_head() : void {
		remove_action( 'login_head', 'wp_strict_cross_origin_referrer', 10 );
		return;
	}
}