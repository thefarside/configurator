<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Title_Link {

	public static function initialize() : void {
		add_filter( 'parse_html-' . basename( $_SERVER['SCRIPT_NAME'] ), array( static::class, 'remove_title' ), PHP_INT_MIN, 2 );
		return;
	}

	public static function remove_title( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$title = $selector->querySelector( '//title' );
		$title?->remove();
		return $document;
	}
}