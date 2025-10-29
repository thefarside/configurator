<?php

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