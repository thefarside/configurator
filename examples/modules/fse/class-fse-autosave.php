<?php
/**
 * Module Name: FSE Autosave
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-autosave.php
 * Version: 0.0.1
 * Description: Disables autosave for the FSE editor.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\FSE;

class FSE_Autosave {

	public static function initialize() : void {
		add_filter( 'block_editor_settings_all', array( static::class, 'deregister' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function deregister( array $settings ) : array {
		$settings['autosaveInterval'] = 31536000;
		$settings['localAutosaveInterval'] = 31536000;
		return $settings;
	}
}