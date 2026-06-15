<?php
/**
 * Module Name: Emails Password Change
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-emails-password-change.php
 * Version: 0.0.1
 * Description: Disables sending password change receipt emails.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Emails_Password_Change {

	public static function initialize() : void {
		remove_action( 'after_password_reset', 'wp_password_change_notification' );
		add_filter( 'send_password_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}