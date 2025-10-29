<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Screen_Options {

	public static function initialize() : void {
		add_filter( 'hidden_meta_boxes', array( Return_Types::class, 'return_empty_array' ), PHP_INT_MAX );
		add_filter( 'screen_options_show_screen', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}