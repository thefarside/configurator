<?php

namespace Configurator\Modules;

class GDPR_Export_Template {

	public static function initialize() : void {
		add_filter( 'wp_privacy_personal_data_exporters', array( static::class, 'register' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function register( array $exporters ) : array {
		$exporters[__CLASS__] = array(
			'exporter_friendly_name' => 'Modify > GDPR Export Template',
			'callback' => array( static::class, 'exporter' ),
		);
		return $exporters;
	}

	public static function exporter( string $email_address ) : array {
		$user = get_user_by( 'email', $email_address );
		$data = array();
		if ( $user ) {
			array_push( $data, array (
				'group_id'    => 'plugin-id',
				'group_label' => 'Plugin',
				'group_description' => "User's plugin data.",
				'item_id'     => "{$user->ID}",
				'data'        => array(
					array(
						'name'  => 'Label',
						'value' => 'value',
					),
					array(
						'name'  => 'Label',
						'value' => 'value',
					),
				),
			) );
		}
		return array(
			'data' => $data,
			'done' => true,
		);
	}
}