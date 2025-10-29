<?php

namespace Configurator\Modules;

class Prefetch {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_resource_hints', 2 );
		return;
	}
}