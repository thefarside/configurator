<?php
/**
 * Module Name: oEmbed
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-oembed.php
 * Version: 0.0.1
 * Description: Removes all oEmbed <link>'s from <head>.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules;

class OEmbed {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		return;
	}
}