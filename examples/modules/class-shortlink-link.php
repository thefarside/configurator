<?php
/**
 * Module Name: Shortlink Link
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-shortlink-link.php
 * Version: 0.0.1
 * Description: Removes <link rel='shortlink'> from <head>.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules;

class Shortlink_Link {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
		return;
	}
}