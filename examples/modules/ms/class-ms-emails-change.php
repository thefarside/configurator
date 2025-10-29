<?php

namespace Configurator\Modules\MS;

use Configurator\Helpers\Return_Types;

class MS_Emails_Change {

	public static function initialize() : void {
		add_filter( 'send_network_admin_email_change_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}