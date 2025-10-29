<?php

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