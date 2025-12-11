<?php
/**
 * Module Name: Page Attributes
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-page-attributes.php
 * Version: 0.0.1
 * Description: Removes the "Page Attributes" meta box from the classic post editor.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules;

class Page_Attributes {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'remove_metaboxes' ), PHP_INT_MAX );
		return;
	}

	public static function remove_metaboxes() : void {
		remove_meta_box( 'pageparentdiv', 'page', 'side' );
		return;
	}
}