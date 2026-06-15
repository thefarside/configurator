<?php
/**
 * Module Name: WC Emails Password Change
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-emails-password-change.php
 * Version: 0.0.1
 * Description: Disables sending WooCommerce password change receipts to the site admin using password reset on the my-account page on the front-end.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules\WC;

use Configurator\Helpers\Return_Types;

class WC_Emails_Password_Change {

	public static function initialize() : void {
		add_filter( 'woocommerce_disable_password_change_notification', array( Return_Types::class, 'return_true' ), PHP_INT_MAX );
		return;
	}
}