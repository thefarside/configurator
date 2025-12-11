<?php
/**
 * Module Name: Canonical Link
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-canonical-link.php
 * Version: 0.0.1
 * Description: Removes default <link rel="canonical> entries from <head>.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules;

class Canonical_Link {

	public static function initialize() : void {
		remove_action( 'wp_head', 'rel_canonical' );
		add_action( 'admin_head', array( static::class, 'reprioritize_admin_head' ), PHP_INT_MIN );
		return;
	}

	public static function reprioritize_admin_head() : void {
		remove_action( 'admin_head', 'wp_admin_canonical_url' );
		return;
	}
}