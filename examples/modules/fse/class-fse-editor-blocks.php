<?php
/**
 * Module Name: FSE Editor Blocks
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-editor-blocks.php
 * Version: 0.0.1
 * Description: Facilitates filtering out blocks from Gutenberg editors.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\FSE;

class FSE_Editor_Blocks {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		$blacklist = apply_filters( 'blacklist_editor_blocks', array() );
		$blocks = array_merge( $blocks, $blacklist );
		return $blocks;
	}
}