<?php
/**
 * Module Name: Autosave
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-autosave.php
 * Version: 0.0.1
 * Description: Disables autosave for the non-FSE editor.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Autosave {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'deregister' ), PHP_INT_MAX );
		return;
	}

	public static function deregister() : void {
		wp_deregister_script( 'autosave' );
		return;
	}
}