<?php
/**
 * Module Name: FSE Profile About Biography
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-profile-about-biography.php
 * Version: 0.0.1
 * Description: Removes the author biography block from Gutenberg editors.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\FSE;

class FSE_Profile_About_Biography {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		return array_merge( $blocks, array(
			'core/post-author-biography',
		) );
	}
}