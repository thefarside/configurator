<?php
/**
 * Module Name: WC Admin Notices
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-admin-notices.php
 * Version: 0.0.1
 * Description: Disables WooCommerce admin notices in the admin area.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules\WC;

use Configurator\Helpers\Return_Types;

class WC_Admin_Notices {

	public static function initialize() : void {
		add_filter( 'woocommerce_show_admin_notice', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'woocommerce_helper_suppress_admin_notices', array( Return_Types::class, 'return_true' ), PHP_INT_MAX );
		return;
	}
}