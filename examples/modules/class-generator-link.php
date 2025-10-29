<?php

namespace Configurator\Modules;

class Generator_Link {

	public static function initialize() : void {
		remove_action( 'wp_head', 'wp_generator' );
		return;
	}
}