<?php
/**
 * Module Name: MS Emails Change
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-emails-change.php
 * Version: 0.0.1
 * Description: Disables sending changed password notification receipt to old network admin.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules\MS;

use Configurator\Helpers\Return_Types;

class MS_Emails_Change {

	public static function initialize() : void {
		add_filter( 'send_network_admin_email_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}