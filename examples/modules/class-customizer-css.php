<?php

namespace Configurator\Modules;

use WP_Customize_Manager;
use Configurator\Helpers\FSE;

class Customizer_CSS {

	public static function initialize() : void {
		add_action( 'admin_init', array( FSE::class, 'customizer_fix' ), PHP_INT_MAX );
		add_action( 'customize_register', array( static::class, 'remove_additional_css' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_additional_css( WP_Customize_Manager $manager ) : void {
		$manager->remove_section( 'custom_css' );
		$manager->remove_section( 'colors' );
		return;
	}
}