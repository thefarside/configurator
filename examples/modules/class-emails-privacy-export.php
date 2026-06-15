<?php
/**
 * Module Name: Emails Privacy Export
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-emails-privacy-export.php
 * Version: 0.0.1
 * Description: Disables confirmation emails for personal data export and removes the related GUI elements.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Emails_Privacy_Export {

	public static function initialize() : void {
		add_filter( 'parse_html-export-personal-data.php', array( static::class, 'remove_enabler' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_enabler( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->querySelector( '//tr[.//input[@id = "send_confirmation_email"]]' );
		$settings?->remove();
		return $document;
	}
}