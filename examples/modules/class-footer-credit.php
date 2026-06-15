<?php
/**
 * Module Name: Footer Credit
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-footer-credit.php
 * Version: 0.0.1
 * Description: Removes "Thank you for creating with WordPress." from the bottom of admin pages.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Footer_Credit {

	public static function initialize() : void {
		add_action( 'admin_footer_text', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		return;
	}
}