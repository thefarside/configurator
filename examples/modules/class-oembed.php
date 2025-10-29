<?php

namespace Configurator\Modules;

class OEmbed {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		return;
	}
}