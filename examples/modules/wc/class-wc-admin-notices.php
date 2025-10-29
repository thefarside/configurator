<?php

namespace Configurator\Modules\WC;

use Configurator\Helpers\Return_Types;

class WC_Admin_Notices {

	public static function initialize() : void {
		add_filter( 'woocommerce_show_admin_notice', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'woocommerce_helper_suppress_admin_notices', array( Return_Types::class, 'return_true' ), PHP_INT_MAX );
		return;
	}
}