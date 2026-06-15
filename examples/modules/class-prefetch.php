<?php
/**
 * Module Name: Prefetch
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-prefetch.php
 * Version: 0.0.1
 * Description: Disables "prefetch" <link>'s sitewide.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Prefetch {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_resource_hints', 2 );
		return;
	}
}