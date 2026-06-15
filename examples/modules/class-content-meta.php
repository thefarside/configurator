<?php
/**
 * Module Name: Content Meta
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-content-meta.php
 * Version: 0.0.1
 * Description: Replaces any old <meta http-equiv="Content-Type" content="XXX"> entries with the new <meta charset="XXX"> syntax.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Content_Meta {

	public static function initialize() : void {
		add_filter( 'parse_html-' . basename( $_SERVER['SCRIPT_NAME'] ), array( static::class, 'update_meta' ), PHP_INT_MIN, 2 );
		return;
	}

	public static function update_meta( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$old_meta = $selector->querySelector( '//meta[translate( @http-equiv, "content-type", "CONTENT-TYPE" )]' );
		if ( $old_meta ) {
			$new_meta = $document->createElement( 'meta' );
			$new_meta->setAttribute( 'charset', get_option( 'blog_charset' ) );
			$head = $selector->querySelector( '//head' );
			$head->prepend( $new_meta );
			$old_meta->remove();
		}
		return $document;
	}
}