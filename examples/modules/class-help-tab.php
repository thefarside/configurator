<?php

namespace Configurator\Modules;

class Help_Tab {

	public static function initialize() : void  {
		add_action( 'admin_head', array( static::class, 'remove_tabs' ), PHP_INT_MAX );
		return;
	}

	public static function remove_tabs() : void  {
		get_current_screen()->remove_help_tabs();
		return;
	}
}