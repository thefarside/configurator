<?php
/**
 * Module Name: Required Email
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-required-email.php
 * Version: 0.0.1
 * Description: Disables the requirement for user emails and removes related notices.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument, \WP_Error
 */

namespace Configurator\Modules;

use WP_Error;
use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Required_Email {

	public static function initialize() : void {
		add_action( 'user_profile_update_errors', array( static::class, 'remove_profile_errors' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'remove_new_user_field_requirement' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'remove_required_email_notice' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_required_email_notice' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_required_email_notice' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_profile_errors( WP_Error $errors ) : WP_Error {
		$errors->remove('empty_email');
		return $errors;
	}

	public static function remove_new_user_field_requirement( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$field = $selector->querySelector( '//tr[.//input[@id = "email"]]' );
		$field?->removeAttribute( 'class' );
		$field?->setAttribute( 'class', 'form-field' );
		return $document;
	}

	public static function remove_required_email_notice( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$notice = $selector->querySelector( '//label[@for = "email"]/span[@class = "description"]' );
		$notice?->remove();
		return $document;
	}
}