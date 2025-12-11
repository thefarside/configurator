<?php
/**
 * Module Name: WC Menus Metaboxes
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-menus-metaboxes.php
 * Version: 0.0.1
 * Description: Removes "WooCommerce Endpoints" from theme "Menus" when using a non-FSE theme.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\WC;

class WC_Menus_Metaboxes {

	public static function initialize() : void {
		add_action( 'admin_head', array( static::class, 'remove_menu_metaboxes' ), PHP_INT_MAX );
		return;
	}

	public static function remove_menu_metaboxes() : void {
		remove_meta_box( 'add-post-type-product', 'nav-menus', 'side' );
		remove_meta_box( 'add-product_cat', 'nav-menus', 'side' );
		remove_meta_box( 'add-product_tag', 'nav-menus', 'side' );
		remove_meta_box( 'woocommerce_endpoints_nav_link', 'nav-menus', 'side' );
		return;
	}
}