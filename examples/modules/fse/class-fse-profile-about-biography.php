<?php

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