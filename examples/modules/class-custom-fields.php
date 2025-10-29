<?php

namespace Configurator\Modules;

class Custom_Fields {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'remove_metaboxes' ), PHP_INT_MAX );
		return;
	}

	public static function remove_metaboxes() : void {
		$post_types = get_post_types( array(
			'public' => true,
			'_builtin' => true,
		) );
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'custom-fields' ) ) {
				remove_post_type_support( $post_type, 'custom-fields' );
			}
		}
		remove_meta_box( 'postcustom', 'wp_block', 'normal' );
		return;
	}
}