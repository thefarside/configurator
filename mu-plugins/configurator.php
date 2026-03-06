<?php
/**
 * Plugin Name: Configurator
 * Update URI: https://github.com/thefarside/configurator
 * Description: Additional site configuration.
 * Version: 2.1
 */

namespace Configurator;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once __DIR__ . DIRECTORY_SEPARATOR . __NAMESPACE__ . DIRECTORY_SEPARATOR . 'class-load.php';
add_action( 'muplugins_loaded', array( __NAMESPACE__ . '\Load', 'initialize' ), PHP_INT_MAX );