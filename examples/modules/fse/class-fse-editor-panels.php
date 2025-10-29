<?php

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