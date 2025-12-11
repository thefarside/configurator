<?php
/**
 * Module Name: Help Tab
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-help-tab.php
 * Version: 0.0.1
 * Description: Removes the "help" tab from admin area pages.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

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