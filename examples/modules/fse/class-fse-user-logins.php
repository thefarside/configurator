<?php
/**
 * Module Name: FSE User Logins
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-user-logins.php
 * Version: 0.0.1
 * Description: Removes the log in/out block from Gutenberg editors.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\FSE;

class FSE_User_Logins {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		array_push( $blocks, 'core/loginout' );
		return $blocks;
	}
}