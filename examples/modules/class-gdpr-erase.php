<?php

namespace Configurator\Modules;

class GDPR_Erase {

	public static function initialize() : void {
		add_filter( 'wp_privacy_personal_data_erasers', array( static::class, 'register' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function register( array $erasers ) : array {
		$erasers[__CLASS__] = array(
			'eraser_friendly_name' => 'Modify > Erase',
			'callback' => array( static::class, 'eraser' ),
		);
		return $erasers;
	}

	public static function eraser( string $email_address ) : array {
		$user = get_user_by( 'email', $email_address );
		if ( $user ) {
			$posts = get_posts( array(
				'title' => $email_address,
				'name' => 'export_personal_data',
				'post_type' => 'user_request',
				'post_status' => get_post_stati(),
			 ) );
			foreach ( $posts as $post ) {
				wp_delete_post( $post->ID, true );
			}
			$removed = wp_delete_user( $user->ID );
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