<?php
/**
 * Module Name: FSE Avatars
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-avatars.php
 * Version: 0.0.1
 * Description: Removes the avatar block from Gutenberg editors.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\FSE;

class FSE_Avatars {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		array_push( $blocks, 'core/avatar' );
		return $blocks;
	}
}