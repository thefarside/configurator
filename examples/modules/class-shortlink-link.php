<?php

namespace Configurator\Modules;

class Shortlink_Link {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
		return;
	}
}