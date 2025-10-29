<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Footer_Credit {

	public static function initialize() : void {
		add_action( 'admin_footer_text', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		return;
	}
}