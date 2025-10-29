<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Emails_Change {

	public static function initialize() : void {
		add_filter( 'send_email_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'send_site_admin_email_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}