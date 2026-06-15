<?php
/**
 * Module Name: Profile Contact Website
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-profile-contact-website.php
 * Version: 0.0.1
 * Description: Removes the website field from user profile pages and related GUI elements from within the admin area.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Profile_Contact_Website {

	public static function initialize() : void {
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_field' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_field' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'remove_new_user_field' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_profile_field( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->querySelector( '//tr[@class = "user-url-wrap"]' );
		$settings?->remove();
		return $document;
	}
	
	public static function remove_new_user_field( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->querySelector( '//tr[.//input[@id = "url"]]' );
		$settings?->remove();
		return $document;
	}
}
