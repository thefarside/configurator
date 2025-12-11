<?php
/**
 * Module Name: Installs
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-installs.php
 * Version: 0.0.1
 * Description: Disables web installs.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Installs {

	public static function initialize() : void {
		add_filter( 'file_mod_allowed', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}