<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Emails_Password_Change {

	public static function initialize() : void {
		remove_action( 'after_password_reset', 'wp_password_change_notification' );
		add_filter( 'send_password_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}