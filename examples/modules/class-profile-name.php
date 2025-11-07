<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Profile_Name {

	public static function initialize() : void {
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_section' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_section' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_profile_section( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//h2[text() = "Name"] |
			//h2[text() = "Name"]/following-sibling::table[1]
		' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		return $document;
	}
}