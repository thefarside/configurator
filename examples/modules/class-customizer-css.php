<?php
/**
 * Module Name: Customizer CSS
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-customizer-css.php
 * Version: 0.0.1
 * Description: Removes the "Custom CSS" and "Colors" sections from the non-FSE site editor.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\FSE, \WP_Customize_Manager
 */

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