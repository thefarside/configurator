<?php
/**
 * Module Name: Load
 * Module URI: https://github.com/thefarside/configurator/tree/main/mu-plugins/configurator/class-load.php
 * Version: 0.0.1
 * Description: Configurator core.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Unload
 */

namespace Configurator;

require_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class-unload.php';

class Load {

	public static array $modules = array();

	public static function initialize() : void {
		spl_autoload_register( array( static::class, 'require_modules' ) );
		static::hook_modules( 'modules_loaded', 'initialize', PHP_INT_MAX );
		do_action( 'modules_loaded' );
		static::parse_modules();
		return;
	}

	private static function create_file_from_class( string $class ) : string {
		$formatted_class = str_replace( '_', '-', strtolower( $class ) );
		$class_parts = explode( '\\', $formatted_class );
		$namespace = array_shift( $class_parts );
		$class_name = array_pop( $class_parts );
		$sub_namespace = implode( DIRECTORY_SEPARATOR, $class_parts );
		$directory = __DIR__;
		$absolute_path = $directory . DIRECTORY_SEPARATOR . $sub_namespace;
		$file_name = "class-{$class_name}.php";
		$file = $absolute_path . DIRECTORY_SEPARATOR . $file_name;
		return $file;
	}

	private static function create_classes_from_files() : array {
		$classes = array();
		$directory = __DIR__;
		$files = list_files( $directory );
		foreach ( $files as $file ) {
			if ( ! str_ends_with( $file, '.php' ) ) {
				continue;
			}
			$module_basename = plugin_basename( $file );
			$module_basename_formatted = str_replace( '-', '_', ucwords( $module_basename, '-/' ) );
			$module_dirname_formatted = dirname( $module_basename_formatted );
			$module_filename_formatted = basename( $module_basename_formatted );
			$namespace = str_replace( '/', '\\', $module_dirname_formatted );
			$class_name = str_replace( 'Class_', '', pathinfo( $module_filename_formatted, PATHINFO_FILENAME ) );
			$qualified_name = "{$namespace}\\{$class_name}";
			$classes[$file] = $qualified_name;
		}
		return $classes;
	}

	private static function require_modules( string $class ) : void {
		if ( ! str_starts_with( $class, __NAMESPACE__ ) ) {
			return;
		}
		$file = static::create_file_from_class( $class );
		if ( ! is_file( $file ) ) {
			return;
		}
		foreach( Unload::$modules as $module => $blog_ids ) {
			if ( in_array( get_current_blog_id(), $blog_ids ) && strtolower( $class ) === strtolower( $module ) ) {
				return;
			}
		}
		require_once $file;
		return;
	}

	private static function hook_modules( string $class, string $method, int $priority ) : void {
		$classes = static::create_classes_from_files();
		foreach ( $classes as $class ) {
			if ( method_exists( $class, $method ) && $class !== __CLASS__ ) {
				add_action( 'modules_loaded', array( $class, $method ), $priority );
			}
		}
		return;
	}

	private static function parse_modules() : void {
		$default_headers = array(
			'Name'            => 'Module Name',
			'PluginURI'       => 'Module URI',
			'Version'         => 'Version',
			'Description'     => 'Description',
			'Author'          => 'Author',
			'AuthorURI'       => 'Author URI',
			'TextDomain'      => 'Text Domain',
			'DomainPath'      => 'Domain Path',
			//'Network'       => 'Network',
			'RequiresWP'      => 'Requires at least',
			'RequiresPHP'     => 'Requires PHP',
			'UpdateURI'       => 'Update URI',
			'RequiresPlugins' => 'Requires Modules',
			'License'		  => 'License',
			'LicenseURI'	  => 'License URI',
		);
		$classes = static::create_classes_from_files();
		$index = 0;
		foreach ( $classes as $file => $class ) {
			$populated_headers = get_file_data( $file, $default_headers );
			static::$modules[$index] = array_combine( array_values( $default_headers ), array_values( $populated_headers ) );
			static::$modules[$index]['Class'] = $class;
			if ( class_exists( $class ) ) {
				static::$modules[$index]['Enabled'] = 'true';
			} else {
				static::$modules[$index]['Enabled'] = 'false';
			}
			$index++;
		}
		return;
	}
}