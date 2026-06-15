<?php
/**
 * Module Name: Avatars
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-avatars.php
 * Version: 0.0.1
 * Description: Disables use of avatars and removes related GUI elements.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Avatars {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_option' ), PHP_INT_MAX );
		add_filter( 'parse_html-options-discussion.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function disable_option() : void {
		update_option( 'show_avatars', 0 );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$section = $selector->query( '
			//h2[text() = "Avatars"] |
			//h2[text() = "Avatars"]/following-sibling::p[1] |
			//h2[text() = "Avatars"]/following-sibling::table[1]
		' );
		foreach ( $section as $entry ) {
			$entry->remove();
		}
		return $document;
	}
}