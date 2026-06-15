<?php
/**
 * Module Name: Title Link
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-title-link.php
 * Version: 0.0.1
 * Description: Removes <title> from <head>.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

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