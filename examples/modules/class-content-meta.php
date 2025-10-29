<?php

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