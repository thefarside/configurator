<?php

namespace Configurator\Modules\WC;

class WC_Patterns_AI {

	public static function initialize() : void {
		add_filter( 'register_post_type_args', array( static::class, 'disable_export' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function disable_export( array $args, string $post_type ) : array {
		if ( 'patterns_ai_data' === $post_type ) {
			$args['can_export'] = false;
		}
		return $args;
	}
}