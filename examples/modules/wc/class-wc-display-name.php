<?php

namespace Configurator\Modules\WC;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class WC_Display_Name {

	public static function initialize() : void {
		add_filter( 'woocommerce_save_account_details_required_fields', array( static::class, 'remove_error' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-index.php', array( static::class, 'remove_template_section' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_error( array $required_fields ) : array {
		unset( $required_fields['account_display_name'] );
		return $required_fields;
	}

	public static function remove_template_section( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		if( is_wc_endpoint_url( 'edit-account' )  ) {
			$section = $selector->querySelector( '//p[.//input[@id = "account_display_name"]]' );
			$section?->remove();
		}
		return $document;
	}
}