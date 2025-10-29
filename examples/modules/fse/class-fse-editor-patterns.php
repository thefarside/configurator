<?php

namespace Configurator\Modules\FSE;

use WP_Block_Patterns_Registry;

class FSE_Editor_Patterns {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'unregister_editor_patterns' ), PHP_INT_MAX );
	}

	public static function unregister_editor_patterns() : void {
		$blacklist = apply_filters( 'blacklist_editor_patterns', array() );
		$registry = WP_Block_Patterns_Registry::get_instance();
		$all_patterns = array_column( $registry->get_all_registered(), 'name' );
		$diff_patterns = array_intersect( $blacklist, $all_patterns );
		foreach ( $diff_patterns as $pattern ) {
			unregister_block_pattern( $pattern );
		}
		return;
	}
}