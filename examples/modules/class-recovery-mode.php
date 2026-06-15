<?php
/**
 * Module Name: Recovery Mode
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-recovery-mode.php
 * Version: 0.0.1
 * Description: Disables recovery mode.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Recovery_Mode {

	public static function initialize() : void {
		add_filter( 'wp_fatal_error_handler_enabled', array( Return_Types::class, 'return_false' ), PHP_INT_MAX, 1 );
		return;
	}
}