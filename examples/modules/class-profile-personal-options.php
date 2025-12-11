<?php
/**
 * Module Name: Profile Personal Options
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-profile-personal-options.php
 * Version: 0.0.1
 * Description: Removes the "Personal Options" section from user profile pages.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Profile_Personal_Options {

	public static function initialize() : void {
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_section' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_section' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_profile_section( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//h2[text() = "Personal Options"] |
			//h2[text() = "Personal Options"]/following-sibling::table[1]
		' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		return $document;
	}
}