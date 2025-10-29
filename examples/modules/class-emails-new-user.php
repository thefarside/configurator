<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\Return_Types;

class Emails_New_User {

	public static function initialize() : void {
		add_filter( 'wp_send_new_user_notification_to_admin', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'parse_html-user-new.php', array( static::class, 'set_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function set_settings( DOMDocument $document ) : DOMDocument {
		$checkbox = $document->getElementById( 'send_user_notification' );
		$checkbox?->removeAttribute( 'checked' );
		return $document;
	}
}