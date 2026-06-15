<?php
/**
 * Module Name: Custom Fields
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-custom-fields.php
 * Version: 0.0.1
 * Description: Removes the "Custom Fields" meta box from the non-FSE editors.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

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