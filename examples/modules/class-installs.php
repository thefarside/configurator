<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Installs {

	public static function initialize() : void {
		add_filter( 'file_mod_allowed', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}