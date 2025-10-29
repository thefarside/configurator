<?php

namespace Configurator\Modules;

use WP_Error;

class Mail_Tool {

	public static function initialize() : void {
		add_filter( 'wp_mail_from', array( static::class, 'set_wp_mail_from' ), PHP_INT_MAX, 1 );
		add_action( 'wp_mail_succeeded', array( static::class, 'mail_dumper' ), PHP_INT_MAX, 1 );
		add_action( 'wp_mail_failed', array( static::class, 'mail_dumper' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function set_wp_mail_from( string $from_email ) : string {
		return apply_filters( 'set_wp_mail_from', $from_email );
	}

	public static function mail_dumper( array|WP_Error $mail_data ) : void {
		if ( is_array( $mail_data ) ) {
			$data = $mail_data;
		} else {
			$data = $mail_data->error_data['wp_mail_failed'];
		}
		$options = apply_filters( 'log_mail', array() );
		if ( $options ) {
			file_put_contents(
				trailingslashit( WP_CONTENT_DIR ) . sanitize_file_name( $options['file'] ),
				json_encode( array( time() => $data ), $options['json_flags'] ) . PHP_EOL,
				$options['file_flags']
			);
		}
		return;
	}
}