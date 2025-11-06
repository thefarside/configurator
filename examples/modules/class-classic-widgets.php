<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Classic_Widgets {

	public static function initialize() : void {
		add_filter( 'gutenberg_use_widgets_block_editor', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'use_widgets_block_editor', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}