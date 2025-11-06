<?php

namespace Configurator\Modules\WC;

class WC_Marketing {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'remove_marketing_task' ), PHP_INT_MAX, 1 );
		add_filter( 'set_302-admin.php', array( static::class, 'set_marketing_redirect' ), PHP_INT_MAX, 1 );
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_page' ), PHP_INT_MAX );
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'set_legacy_coupon_menu' ), PHP_INT_MAX, 1 );
		remove_filter( 'woocommerce_admin_shared_settings', array( 'Automattic\WooCommerce\Internal\Admin\Marketing', 'component_settings' ), 30 );
		return;
	}

	public static function remove_marketing_task( array $features ) : array {
		$features['remote-free-extensions'] = false;
		return $features;
	}

	public static function set_marketing_redirect( string $url ) : string {
		if ( isset( $_GET['page'] ) && 'wc-admin' === $_GET['page'] && isset( $_GET['path'] ) && '/marketing' === $_GET['path'] ) {
			return '?page=wc-admin';
		}
		return $url;
	}

	public static function remove_admin_menu_page() : void {
		remove_menu_page( 'woocommerce-marketing' );
		return;
	}

	public static function set_legacy_coupon_menu( array $features ) : array {
		$features['coupons'] = false;
		return $features;
	}
}