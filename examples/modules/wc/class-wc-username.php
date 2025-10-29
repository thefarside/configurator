<?php

namespace Configurator\Modules\WC;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class WC_Username {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_settings' ), PHP_INT_MAX );
		add_filter( 'woocommerce_account_settings', array( static::class, 'remove_admin_settings' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_save_account_details_required_fields', array( static::class, 'remove_errors' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-index.php', array( static::class, 'revise_template_sections' ), PHP_INT_MAX, 2 );
		add_action( 'woocommerce_add_error', array( static::class, 'update_login_error_messages' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_lost_password_message', array( static::class, 'update_lost_password_message' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_settings() : void {
		update_option( 'woocommerce_registration_generate_username', 'yes' );
		return;
	}

	public static function remove_admin_settings( array $account_settings ) : array {
		foreach ( $account_settings as $index => $setting ) {
			if ( 'woocommerce_registration_generate_username' === $setting['id'] ) {
				unset( $account_settings[ $index ] );
			}
		}
		return $account_settings;
	}

	public static function remove_errors( array $required_fields ) : array {
		unset( $required_fields['account_first_name'] );
		unset( $required_fields['account_last_name'] );
		return $required_fields;
	}

	public static function revise_template_sections( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		if( is_wc_endpoint_url( 'edit-account' )  ) {
			$first_name = $selector->querySelector( '//p[.//input[@id = "account_first_name"]]' );
			$last_name = $selector->querySelector( '//p[.//input[@id = "account_last_name"]]' );
			$first_name?->remove();
			$last_name?->remove();
		}
		if( is_account_page() && ! is_user_logged_in() ) {
			$login_name_label = $selector->querySelector( '//label[@for = "username"]' );
		}
		if( is_wc_endpoint_url( 'lost-password' ) ) {
			$login_name_label = $selector->querySelector( '//label[@for = "user_login"]' );
		}
		if ( isset( $login_name_label ) ) {
			$required_span = $document->createElement( 'span' );
			$required_span->setAttribute( 'class', 'required' );
			$required_span->nodeValue = '*';
			$login_name_label->nodeValue = 'Email Address ';
			$login_name_label->appendChild( $required_span );
		}
		return $document;
	}

	public static function update_login_error_messages( string $message ) : string {
		if ( 'Unknown email address. Check again or try your username.' === $message ) {
			return 'Unknown email address. Check again.';
		}
		if ( str_ends_with( $message, 'If you are unsure of your username, try your email address instead.' ) ) {
			return '<strong>Error:</strong> Invalid email address.';
		}
		if ( 'Invalid username or email.' === $message ) {
			return 'Invalid email address.';
		}
		if ( 'Enter a username or email address.' === $message ) {
			return 'Enter an email address.';
		}
		return $message;
	}

	public static function update_lost_password_message( string $message ) : string {
		return 'Lost your password? Please enter your email address. You will receive a link to create a new password via email.';
	}
}