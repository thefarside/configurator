<?php

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