<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Emails_Comments {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_settings' ), PHP_INT_MAX );
		add_filter( 'parse_html-options-discussion.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function disable_settings() : void {
		update_option( 'comments_notify', 0 );
		update_option( 'moderation_notify', 0 );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//th[text() = "Email me whenever"]]' );
		$setting?->remove();
		return $document;
	}
}