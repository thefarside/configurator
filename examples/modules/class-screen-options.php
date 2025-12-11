<?php
/**
 * Module Name: Screen Options
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-screen-options.php
 * Version: 0.0.1
 * Description: Removes the screen options tab from admin pages.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Screen_Options {

	public static function initialize() : void {
		add_filter( 'hidden_meta_boxes', array( Return_Types::class, 'return_empty_array' ), PHP_INT_MAX );
		add_filter( 'screen_options_show_screen', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}