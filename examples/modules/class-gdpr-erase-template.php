<?php

namespace Configurator\Modules;

class GDPR_Erase_Template {

	public static function initialize() : void {
		add_filter( 'wp_privacy_personal_data_erasers', array( static::class, 'register' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function register( array $erasers ) : array {
		$erasers[__CLASS__] = array(
			'eraser_friendly_name' => 'Modify > GDPR Erase Template',
			'callback' => array( static::class, 'eraser' ),
		);
		return $erasers;
	}

	public static function eraser( string $email_address ) : array {
		$user = get_user_by( 'email', $email_address );
		if ( $user ) {
			//erase stuff...
			$removed = true;
			$retained = ! $removed;
		} else {
			$removed = false;
			$retained = false;
		}
		return array(
			'items_removed'  => $removed,
			'items_retained' => $retained,
			'messages'       => array(),
			'done'           => true,
		);
	}
}