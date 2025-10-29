<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Emails_Privacy_Erase {

	public static function initialize() : void {
		add_filter( 'parse_html-erase-personal-data.php', array( static::class, 'remove_enabler' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_enabler( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->querySelector( '//tr[.//input[@id = "send_confirmation_email"]]' );
		$settings?->remove();
		return $document;
	}
}