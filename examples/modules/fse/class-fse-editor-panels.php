<?php
/**
 * Module Name: FSE Editor Panels
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-editor-panels.php
 * Version: 0.0.1
 * Description: Facilitates filtering out panels from Gutenberg editors.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\FSE;

class FSE_Editor_Panels {

	public static function initialize() : void {
		add_filter( 'unregister_site_editor_panels', array( static::class, 'unregister_site_editor_panels' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_site_editor_panels( array $panels ) : array {
		$blacklist = apply_filters( 'blacklist_editor_panels', array() );
		$panels = array_merge( $panels, $blacklist );
		return $panels;
	}
}