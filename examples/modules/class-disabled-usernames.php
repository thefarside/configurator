<?php

namespace Configurator\Modules;

use WP_Error;
use stdClass;
use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Disabled_Usernames {

	public static function initialize() : void {
		add_action( 'wp_pre_insert_user_data', array( static::class, 'revise_user_data' ), PHP_INT_MAX, 4 );
		add_action( 'user_profile_update_errors', array( static::class, 'revise_errors' ), PHP_INT_MAX, 3 );
		add_filter( 'parse_html-profile.php', array( static::class, 'revise_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'revise_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	private static function validate_user_login( string $new, string $old ) : array {
		if ( empty( $new ) ) {
			return array( 'empty_user_login', '<strong>Error:</strong> Cannot create a user with an empty login name.' );
		}
		if ( strlen( $new ) > 60 ) {
			return array( 'user_login_too_long', '<strong>Error:</strong> Username may not be longer than 60 characters.' );
		}
		if ( username_exists( $new ) && $new !== $old ) {
			return array( 'existing_user_login', '<strong>Error:</strong> Sorry, that username already exists!' );
		}
		if ( ! validate_username( $new ) ) {		
			return array( 'invalid_username', '<strong>Error:</strong> Sorry, that username is not allowed.' );
		}
		return array();
	}

	public static function revise_user_data( array $data, bool $update, int|null $user_id, array $userdata ) : array {
		$error = static::validate_user_login( $_POST['user_login'], $userdata['user_login'] );
		if ( ! $error ) {
			$data['user_login'] = $_POST['user_login'];
			$data['user_nicename'] = sanitize_title( sanitize_user( $_POST['user_login'], true ) );
		}
		return $data;
	}

	public static function revise_errors( WP_Error $errors, bool $update, stdClass $user ) : WP_Error {
		$error = static::validate_user_login( $_POST['user_login'], $user->user_login );
		if ( $error ) {
			$errors->add( $error[0], $error[1] );
		}
		return $errors;
	}

	public static function revise_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$username = $selector->querySelector( '//input[@id="user_login"]' );
		$username?->removeAttribute( 'readonly' );
		$warning = $selector->querySelector( '//span[text() = "Usernames cannot be changed."]' );
		$warning?->remove();
		return $document;
	}
}