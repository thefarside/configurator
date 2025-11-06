<?php

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