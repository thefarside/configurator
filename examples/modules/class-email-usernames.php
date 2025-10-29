<?php

namespace Configurator\Modules;

use WP_Error;
use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Email_Usernames {

	public static function initialize() : void {
		add_filter( 'pre_user_login', array( static::class, 'validate_email_login' ), PHP_INT_MAX, 1 );
		add_action( 'wp_pre_insert_user_data', array( static::class, 'override_login_name' ), PHP_INT_MAX, 4 );
		add_filter( 'registration_errors', array( static::class, 'remove_errors' ), PHP_INT_MAX, 1 );
		add_action( 'user_profile_update_errors', array( static::class, 'remove_errors' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_users_columns', array( static::class, 'revise_columns' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'override_new_user_field_requirement' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_setting' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_setting' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-wp-login.php', array( static::class, 'revise_login_output' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function validate_email_login( string $sanitized_user_login ) : string {
		if ( isset( $_POST['email'] ) ) {
			return sanitize_user( $_POST['email'], true );
		}
		if ( isset( $_POST['user_email'] ) ) {
			return sanitize_user( $_POST['user_email'], true );
		}
		return $sanitized_user_login;
	}

	public static function override_login_name( array $data, bool $update, int|null $user_id, array $userdata ) : array {
		$data['user_login'] = sanitize_user( $userdata['user_email'], true );
		$data['user_nicename'] = sanitize_title( $userdata['user_email'], true );
		return $data;
	}

	public static function remove_errors( WP_Error $errors ) : WP_Error {
		$errors->remove( 'user_login' );
		$errors->remove( 'empty_username' );
		return $errors;
	}

	public static function revise_columns( array $columns ) : array {
		$columns['username'] = $columns['email'];
		unset( $columns['email'] );
		return $columns;
	}

	public static function override_new_user_field_requirement( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$input = $selector->querySelector( '//input[@id = "user_login"]' );
		$form = $selector->querySelector( '//form[@id = "createuser"]' );
		$row = $selector->querySelector( '//tr[.//input[@id = "user_login"]]' );
		$input?->setAttribute( 'type', 'hidden' );
		$form?->append( $input ?? '' );
		$row?->remove();
		return $document;
	}

	public static function remove_profile_setting( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$username = $selector->querySelector( '//tr[.//input[@id = "user_login"]]' );
		$username?->remove();
		return $document;
	}

	public static function revise_login_output( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$replacements = array();
		$replacements['reset_notice'][0]['node'] = $selector->querySelector( '//body[contains( @class, "lostpassword" )]//div[contains( @class, "notice" )]/p' );
		$replacements['reset_notice'][0]['search'] = 'username or ';
		$replacements['reset_notice'][0]['replace'] = '';
		$replacements['reset_error'][0]['node'] = $selector->querySelector( '//body[contains( @class, "lostpassword" )]//div[@id = "login_error"]/p' )?->childNodes?->item( 1 );
		$replacements['reset_error'][0]['search'] = 'username or ';
		$replacements['reset_error'][0]['replace'] = '';
		$replacements['login_error'][0]['node'] = $selector->querySelector( '//body[contains( @class, "login" )]//div[@id = "login_error"]/p[text()[contains( ., "The username" )]]' )?->childNodes?->item( 1 );
		$replacements['login_error'][0]['search'] = 'The username ';
		$replacements['login_error'][0]['replace'] = '';
		$replacements['login_error'][1]['node'] = $selector->querySelector( '//body[contains( @class, "login" )]//div[@id = "login_error"]/p[text()[contains( ., "The username" )]]' )?->childNodes?->item( 3 );
		$replacements['login_error'][1]['search'] = 'is not registered on this site. If you are unsure of your username, try your email address instead.';
		$replacements['login_error'][1]['replace'] = 'is not a valid email address.';
		$replacements['login_error'][2]['node'] = $selector->querySelector( '//body[contains( @class, "login" )]//div[@id = "login_error"]/p[text()[contains( ., "Unknown email" )]]' );
		$replacements['login_error'][2]['search'] = ' or try your username';
		$replacements['login_error'][2]['replace'] = '';
		$replacements['login_error'][3]['node'] = $selector->querySelector( '//ul[contains( @class, "login-error-list" )]//li' )?->childNodes?->item( 1 );
		$replacements['login_error'][3]['search'] = 'username';
		$replacements['login_error'][3]['replace'] = 'email';
		$replacements['login_error'][4]['node'] = $selector->querySelector( '//body[contains( @class, "login" )]//div[@id = "login_error"]/p[text()[contains( ., "username, " )]]' )?->childNodes?->item( 1 );
		$replacements['login_error'][4]['search'] = 'username, ';
		$replacements['login_error'][4]['replace'] = '';
		$replacements['user_login_label'][0]['node'] = $selector->querySelector( '//label[@for = "user_login"]' );
		$replacements['user_login_label'][0]['search'] = 'Username or ';
		$replacements['user_login_label'][0]['replace'] = '';
		$replacements['user_email_label'][0]['node'] = $selector->querySelector( '//label[@for = "user_email"]' );
		$replacements['user_email_label'][0]['search'] = 'Email';
		$replacements['user_email_label'][0]['replace'] = 'Email Address';
		foreach ( $replacements as $replacement ) {
			foreach ( $replacement as $iteration ) {
				if( $iteration['node'] ) {
					$iteration['node']->nodeValue = str_replace( $iteration['search'], $iteration['replace'], $iteration['node']->nodeValue );
				}
			}
		}
		$user_login = $selector->querySelector( '//p[.//label[text() = "Username"]]' );
		$user_login?->remove();
		return $document;
	}
}