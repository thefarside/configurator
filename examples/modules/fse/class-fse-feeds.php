<?php
/**
 * Module Name: FSE Feeds
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-feeds.php
 * Version: 0.0.1
 * Description: Removes feed blocks from Gutenberg editors.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\FSE
 */

namespace Configurator\Modules\FSE;

use Configurator\Helpers\FSE;

class FSE_Feeds {

	public static function initialize() : void {
		add_action( 'admin_init', array( FSE::class, 'customizer_fix' ), PHP_INT_MAX );
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		return array_merge( $blocks, array(
			'core/rss',
		) );
	}

}