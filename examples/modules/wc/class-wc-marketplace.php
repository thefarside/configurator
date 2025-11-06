<?php

namespace Configurator\Modules\WC;

use Configurator\Helpers\Return_Types;
use Automattic\WooCommerce\Admin\Notes\Notes;
use Automattic\WooCommerce\Internal\Admin\Notes\WooSubscriptionsNotes;

class WC_Marketplace {

	public static function initialize() : void {
		add_filter( 'woocommerce_allow_marketplace_suggestions', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_action( 'admin_init', array( static::class, 'disable_settings' ), PHP_INT_MAX );
		add_filter( 'woocommerce_com_integration_settings', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_marketplace_menu_items', array( Return_Types::class, 'return_empty_array' ), PHP_INT_MAX );
		add_filter( 'set_302-admin.php', array( static::class, 'set_redirect' ), PHP_INT_MAX, 1 );
		add_action( 'admin_head', array( static::class, 'remove_admin_note' ), PHP_INT_MAX );
		return;
	}

	public static function disable_settings() : void {
		update_option( 'woocommerce_show_marketplace_suggestions', 'no' );
		return;
	}

	public static function remove_settings( array $settings ) : array {
		return array_filter( $settings, function( array $setting ) : bool {
			return ! in_array( $setting['id'], array( 'marketplace_suggestions', 'woocommerce_show_marketplace_suggestions' ) );
		} );
	}

	public static function set_redirect( string $url ) : string {
		if ( isset( $_GET['page'] ) && 'wc-admin' === $_GET['page'] && isset( $_GET['path'] ) && '/extensions' === $_GET['path'] ) {
			return '?page=wc-admin';
		}
		return $url;
	}

	public static function remove_admin_note() : void {
		if ( ! class_exists( 'Automattic\WooCommerce\Admin\Notes\Notes' ) ) return;
		remove_action( 'admin_head', array( WooSubscriptionsNotes::class, 'admin_head' ) );
		Notes::delete_notes_with_name( 'wc-admin-wc-helper-connection' );
		return;
	}
}