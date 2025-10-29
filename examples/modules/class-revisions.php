<?php

namespace Configurator\Modules;

class Revisions {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'remove_metaboxes' ), PHP_INT_MAX );
		return;
	}

	public static function remove_metaboxes() : void {
		$post_types = get_post_types( array(
			'public' => true,
			'_builtin' => true,
		) );
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'revisions' ) ) {
				remove_post_type_support( $post_type, 'revisions' );
			}
		}
		return;
	}
}