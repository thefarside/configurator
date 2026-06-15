<?php
/**
 * Module Name: MS Full Name User Columns
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-full-name-user-columns.php
 * Version: 0.0.1
 * Description: Extends Configurator\Modules\Full_Name_User_Columns to include multisite fields and GUI elements.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\MS;

class MS_Full_Name_User_Columns {

	public static function initialize() : void {
		add_filter( 'wpmu_users_columns', array( static::class, 'revise_users_column' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_site-users-network_columns', array( static::class, 'revise_users_column' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_users-network_sortable_columns', array( static::class, 'revise_users_columns_sortable' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_site-users-network_sortable_columns', array( static::class, 'revise_users_columns_sortable' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function revise_users_column( array $columns ) : array {
		unset( $columns['name'] );
		$columns_start = array_slice( $columns, 0, 2 );
		$columns_end = array_slice( $columns, 2 );
		$first_name_column = array( 'first_name' => 'First Name' );
		$last_name_column = array( 'last_name' => 'Last Name' );
		return $columns_start + $first_name_column + $last_name_column + $columns_end;
	}

	public static function revise_users_columns_sortable( array $sortable_columns ) : array {
		$sortable_columns_start = array_slice( $sortable_columns, 0, 2 );
		$sortable_columns_end = array_slice( $sortable_columns, 2 );
		$first_name_sortable_column = array(
			'first_name' => array(
				'first_name',
				'desc',
				'First Name',
				'Table ordered by First Name.',
				'asc',
			)
		);
		$last_name_sortable_column = array(
			'last_name' => array(
				'last_name',
				'desc',
				'Last Name',
				'Table ordered by Last Name.',
				'asc',
			)
		);
		return $sortable_columns_start + $first_name_sortable_column + $last_name_sortable_column + $sortable_columns_end;
	}
}