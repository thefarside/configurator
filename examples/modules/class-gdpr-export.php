<?php

namespace Configurator\Modules;

use WP_User;

class GDPR_Export {

	public static function initialize() : void {
		add_filter( 'wp_privacy_additional_user_profile_data', array( static::class, 'add_meta' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function add_meta( array $additional_user_profile_data, WP_User $user ) : array {
		$meta = get_user_meta( $user->ID );
		$keys = array(
			'User Locale' => $meta['locale'][0],
			'User Capabilities' => var_export( unserialize( $meta['wp_capabilities'][0] ), true ),
			'User User Level' => $meta['wp_user_level'][0],
		);
		foreach ( $keys as $key => $value ) {
			if ( $value ) {
				array_push( $additional_user_profile_data, array (
					'name'  => $key,
					'value' => $value,
				) );
			}
		}
		return $additional_user_profile_data;
	}
}