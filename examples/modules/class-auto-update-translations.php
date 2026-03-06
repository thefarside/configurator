<?php
/**
 * Module Name: Auto Update Translations
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-auto-update-translations.php
 * Version: 0.0.1
 * Description: Disables language auto updates.
 * Requires at least: 6.9.1
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Auto_Update_Translations {

	public static function initialize() : void {
		add_filter( 'async_update_translation', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'auto_update_translation', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}