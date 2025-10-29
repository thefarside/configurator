<?php

namespace Configurator\Helpers;

use DOMDocument;

class HTML_Parser {

	public static function initialize() : void {
		add_action( 'wp_loaded', array( static::class, 'parse_html' ), PHP_INT_MAX );
		return;
	}

	public static function parse_html() : void {
		ob_start( function( string $buffer ) : string {
			if ( $buffer ) {
				$document = new DOMDocument();
				$document->loadHTML( $buffer, LIBXML_SCHEMA_CREATE | LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD |  LIBXML_NOBLANKS );
				if ( 'html' === $document->documentElement->tagName ) {
					$selector = new DOMXPath( $document );
					$page = basename( $_SERVER['SCRIPT_NAME'] );
					$modified = apply_filters( "parse_html-{$page}" , $document, $selector );
					return $modified->saveHTML( $modified );
				}
			}
			return $buffer;
		} );
		return;
	}
}