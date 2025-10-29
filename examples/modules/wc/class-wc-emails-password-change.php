<?php

namespace Configurator\Modules\WC;

use Configurator\Helpers\Return_Types;

class WC_Emails_Password_Change {

	public static function initialize() : void {
		add_filter( 'woocommerce_disable_password_change_notification', array( Return_Types::class, 'return_true' ), PHP_INT_MAX );
		return;
	}
}