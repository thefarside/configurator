<?php

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