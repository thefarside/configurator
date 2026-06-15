<?php
/**
 * Module Name: Profile About
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-profile-about.php
 * Version: 0.0.1
 * Description: Removes the "About" section from the user profile page.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Profile_About {

	public static function initialize() : void {
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_section' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_section' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_profile_section( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//h2[contains( text(), "About" )] |
			//h2[contains( text(), "About" )]/following-sibling::table[1]
		' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		return $document;
	}
}