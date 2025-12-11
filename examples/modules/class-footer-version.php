<?php
/**
 * Module Name: Footer Version
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-footer-version.php
 * Version: 0.0.1
 * Description: Removes "Version X.X" from the bottom of admin pages.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Footer_Version {

	public static function initialize() : void {
		add_filter( 'update_footer', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		return;
	}
}