<?php
/**
 * Plugin Name: Configurator
 * Update URI: https://github.com/thefarside/configurator
 * Description: Additional site configuration.
 * Version: 1.0.1
 */

namespace Configurator;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Autoloader {

	public static function initialize( string $mu_plugin ) : void {
		if ( basename( __FILE__ ) === basename( $mu_plugin ) ) {
			spl_autoload_register( array( static::class, 'module_loader' ) );
			Autoloader::recursive_hooker( 'initialize' );
		}
		return;
	}

	public static function module_loader( string $class ) : void {
		if ( ! str_starts_with( $class, __NAMESPACE__ ) ) {
			return;
		}
		$formatted_class = str_replace( '_', '-', strtolower( $class ) );
		$class_parts = explode( '\\', $formatted_class );
		$class_name = end( $class_parts );
		$path_parts = array_diff( $class_parts, array( $class_name ) );
		$absolute_path = __DIR__ . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, $path_parts );
		$file_name = "class-{$class_name}.php";
		$fully_qualified_file_name = $absolute_path . DIRECTORY_SEPARATOR . $file_name;
		if ( file_exists( $fully_qualified_file_name ) ) {
			require_once $fully_qualified_file_name;
		}
		return;
	}

	public static function recursive_hooker( string $method ) : void {
		$current_working_directory = __DIR__ . DIRECTORY_SEPARATOR . __NAMESPACE__;
		$directory = new RecursiveDirectoryIterator( $current_working_directory, RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::UNIX_PATHS );
		$files = new RecursiveIteratorIterator( $directory );
		foreach ( $files as $file ) {
			if ( 'php' !== $file->getExtension() ) {
				continue;
			}
			$relative_file_path = str_replace( $current_working_directory, '', $file->getPath() );
			$formatted_relative_file_path = str_replace( '-', '_', ucwords( $relative_file_path, '-/' ) );
			$namespace = __NAMESPACE__ . str_replace( '/', '\\', $formatted_relative_file_path );
			$file_name = basename( $file->getFilename(), '.php' );
			$formatted_file_name = str_replace( '-', '_', ucwords( $file_name, '-' ) );
			$class_name = str_replace( 'Class_', '', $formatted_file_name );
			$qualified_name = "{$namespace}\\{$class_name}";
			if ( method_exists( $qualified_name, $method ) ) {
				add_action( 'muplugins_loaded', array( $qualified_name, $method ), PHP_INT_MAX );
			}
		}
		return;
	}
}

if ( defined( 'ABSPATH' ) ) {
	add_action( 'mu_plugin_loaded', array( Autoloader::class, 'initialize' ), PHP_INT_MAX, 1 );
} else {
	exit;
}