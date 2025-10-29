<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Profile_Additonal_Capabilities {

	public static function initialize() : void {
		add_filter( 'additional_capabilities_display', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}