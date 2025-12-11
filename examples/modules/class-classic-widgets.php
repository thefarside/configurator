<?php
/**
 * Module Name: Classic Widgets
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-classic-widgets.php
 * Version: 0.0.1
 * Description: Disables using a block editor on the Widgets admin page.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Classic_Widgets {

	public static function initialize() : void {
		add_filter( 'gutenberg_use_widgets_block_editor', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'use_widgets_block_editor', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}