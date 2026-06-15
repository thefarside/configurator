<?php
/**
 * Module Name: Generator Link
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-generator-link.php
 * Version: 0.0.1
 * Description: Removes <meta name="generator"> from <head>.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Generator_Link {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_generator' );
		return;
	}
}