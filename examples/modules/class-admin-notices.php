<?php

namespace Configurator\Modules;

class Admin_Notices {

	public static function initialize() : void  {
		add_action( 'admin_menu', array( static::class, 'remove_notices' ), PHP_INT_MAX );
		return;
	}

	public static function remove_notices() : void  {
		remove_all_actions( 'admin_notices' );
		return;
	}
}