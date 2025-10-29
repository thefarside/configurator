<?php

namespace Configurator\Modules;

use DOMDocument;

class Emails_Verification {

	public static function initialize() : void {
		remove_action( 'personal_options_update', 'send_confirmation_on_profile_email' );
		add_action( 'personal_options_update', array( static::class, 'change_profile_email' ), PHP_INT_MIN, 1 );
		remove_action( 'add_option_new_admin_email', 'update_option_new_admin_email', 10 );
		remove_action( 'update_option_new_admin_email', 'update_option_new_admin_email', 10 );
		add_action( 'add_option_new_admin_email', array( static::class, 'change_site_email' ), PHP_INT_MIN, 2 );
		add_action( 'update_option_new_admin_email', array( static::class, 'change_site_email' ), PHP_INT_MIN, 2 );
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_notice' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-options-general.php', array( static::class, 'remove_site_notice' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function change_profile_email( int $user_id ) : void {
		wp_update_user( array(
			'ID' => $user_id,
			'user_email' => $_POST['email'],
		) );
		return;
	}

	public static function change_site_email( string $old_value, string $value ) : void {
		delete_option( 'new_admin_email' );
		delete_option( 'adminhash' );
		update_option( 'admin_email', $value );
		return;
	}

	public static function remove_profile_notice( DOMDocument $document ) : DOMDocument {
		$notice = $document->getElementById( 'email-description' );
		$notice?->remove();
		return $document;
	}

	public static function remove_site_notice( DOMDocument $document ) : DOMDocument {
		$notice = $document->getElementById( 'new-admin-email-description' );
		$notice?->remove();
		return $document;
	}
}