<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Lazy_Loading {

	public static function initialize() : void {
		add_filter( 'wp_lazy_loading_enabled', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}