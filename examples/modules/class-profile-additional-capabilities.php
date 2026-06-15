<?php
/**
 * Module Name: Profile Additonal Capabilities
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-profile-additional-capabilities.php
 * Version: 0.0.1
 * Description: Prevents "Additonal Capabilities" from displaying on user profile pages.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Profile_Additional_Capabilities {

	public static function initialize() : void {
		add_filter( 'additional_capabilities_display', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}