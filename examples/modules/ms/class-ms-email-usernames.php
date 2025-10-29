<?php

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_Email_Usernames {

	public static function initialize() : void {
		add_filter( 'pre_user_login', array( static::class, 'validate_email_login' ), PHP_INT_MAX, 1 );
		add_filter( 'signup_blog_init', array( static::class, 'override_signup_blogname' ), PHP_INT_MAX, 1 );
		add_filter( 'wpmu_validate_user_signup', array( static::class, 'override_signup_name' ), PHP_INT_MAX, 1 );
		add_filter( 'wpmu_users_columns', array( static::class, 'revise_columns' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_site-users-network_columns', array( static::class, 'revise_columns' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-wp-signup.php', array( static::class, 'revise_signup_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-site-users.php', array( static::class, 'revise_site_users_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'override_new_user_field_requirement' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function validate_email_login( string $sanitized_user_login ) : string {
		if ( isset( $_POST['user']['email'] ) ) {
			return sanitize_user( $_POST['user']['email'], true );
		}
		return $sanitized_user_login;
	}

	public static function override_signup_blogname( array $signup_blog_defaults ) : array {
		$signup_blog_defaults['user_name'] = '';
		return $signup_blog_defaults;
	}

	public static function override_signup_name( array $result ) : array {
		$result['user_name'] = $result['user_email'];
		$result['errors']->remove( 'user_name' );
		return $result;
	}

	public static function revise_columns( array $columns ) : array {
		$columns['username'] = $columns['email'];
		unset( $columns['email'] );
		return $columns;
	}

	public static function revise_signup_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$input = $selector->querySelector( '//input[@id = "user_name"]' );
		$input?->setAttribute( 'type', 'hidden' );
		$input?->setAttribute( 'value', ' ' );
		$description = $selector->querySelector( '//p[@id = "wp-signup-username-description"]' );
		$description?->remove();
		$label = $selector->querySelector( '//label[@for = "user_name"]' );
		$label?->remove();
		$greeting = $selector->querySelector( '//*[text()[contains( ., "Welcome back, ." )]]' );
		if ( $greeting ) {
			$greeting->nodeValue = str_ireplace( 'Welcome back, .', 'Welcome back!', $greeting->nodeValue );
		}
		foreach ( $selector->query( '//*[text()[contains( ., "username" )]]' ) as $text ) {
			$text->nodeValue = str_ireplace( 'a username', 'an account', $text->nodeValue );
		}
		return $document;
	}

	public static function revise_site_users_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$form = $selector->querySelector( '//form[@id = "newuser"]' );
		$row = $selector->querySelector( '//tr[.//input[@id = "user_username"]]' );
		$input = $selector->querySelector( '//input[@id = "user_username"]' );
		$label = $selector->querySelector( '//th[.//label[text() = "Username"]]' );
		$input?->setAttribute( 'type', 'hidden' );
		$input?->setAttribute( 'value', ' ' );
		$form?->append( $input  ?? '' );
		$row?->remove();
		if ( $label ) {
			$label->nodeValue = 'Email';
		}
		return $document;
	}

	public static function override_new_user_field_requirement( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$form_create = $selector->querySelector( '//form[@id = "createuser"]' );
		$row_create = $selector->querySelector( '//tr[.//input[@id = "user_login"]]' );
		$input_create = $selector->querySelector( '//input[@id = "user_login"]' );
		$input_create?->setAttribute( 'type', 'hidden' );
		$form_create?->append( $input_create ?? '' );
		$row_create?->remove();
		$form_add = $selector->querySelector( '//form[@id = "adduser"]' );
		$row_add = $selector->querySelector( '//tr[.//input[@id = "username"]]' );
		$input_add = $selector->querySelector( '//input[@id = "username"]' );
		$label_add = $selector->querySelector( '//th[.//label[text() = "Email or Username"]]' );
		$input_add?->setAttribute( 'type', 'hidden' );
		$form_add?->append( $input_add ?? '' );
		$row_add?->remove();
		if ( $label_add ) {
			$label_add->nodeValue = 'Email';
		}
		return $document;
	}
}