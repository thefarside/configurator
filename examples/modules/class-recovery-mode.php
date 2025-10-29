<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Recovery_Mode {

	public static function initialize() : void {
		add_filter( 'wp_fatal_error_handler_enabled', array( Return_Types::class, 'return_false' ), PHP_INT_MAX, 1 );
		return;
	}
}