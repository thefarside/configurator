<?php
/**
 * Module Name: WC Payments Menu Link
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-payments-menu-link.php
 * Version: 0.0.1
 * Description: Removes the WooCommerce "Payments" link from the admin menu.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\WC;

class WC_Payments_Menu_Link {

	public static function initialize() : void {
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_page' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_menu_page() : void {
		remove_menu_page( 'admin.php?page=wc-settings&tab=checkout&from=PAYMENTS_MENU_ITEM' );
		return;
	}
}