<?php
/**
 * Module Name: Emails Change
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-emails-change.php
 * Version: 0.0.1
 * Description: Disables sending changed password notification receipt.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Emails_Change {

	public static function initialize() : void {
		add_filter( 'send_email_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'send_site_admin_email_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}