<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Footer_Version {

	public static function initialize() : void {
		add_filter( 'update_footer', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		return;
	}
}