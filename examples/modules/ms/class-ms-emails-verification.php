<?php

namespace Configurator\Modules\MS;

use DOMDocument;

class MS_Emails_Verification {

	public static function initialize() : void {
		remove_action( 'add_site_option_new_admin_email', 'update_site_option_new_admin_email', 10 );
		remove_action( 'update_network_option_new_admin_email', 'update_site_option_new_admin_email', 10 );
		add_action( 'add_site_option_new_admin_email', array( static::class, 'change_network_email' ), PHP_INT_MIN, 2 );
		add_action( 'update_network_option_new_admin_email', array( static::class, 'change_network_email' ), PHP_INT_MIN, 2 );
		add_filter( 'parse_html-settings.php', array( static::class, 'remove_network_notice' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function change_network_email( string $old_value, string $value ) : void {
		delete_site_option( 'new_admin_email' );
		delete_site_option( 'network_admin_hash' );
		update_site_option( 'admin_email', $value );
		return;
	}

	public static function remove_network_notice( DOMDocument $document ) : DOMDocument {
		$notice = $document->getElementById( 'admin-email-desc' );
		$notice?->remove();
		return $document;
	}
}