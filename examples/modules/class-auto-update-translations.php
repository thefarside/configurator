<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Auto_Update_Translations {

	public static function initialize() : void {
		add_filter( 'async_update_translation', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'auto_update_translation', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}