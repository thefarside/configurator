<?php

namespace Configurator\Modules;

class Full_Name_User_Columns {

	public static function initialize() : void {
		add_filter( 'manage_users_columns', array( static::class, 'revise_users_column' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_users_sortable_columns', array( static::class, 'revise_users_columns_sortable' ), PHP_INT_MAX, 1 );
		add_action( 'manage_users_custom_column', array( static::class, 'revise_users_columns_content' ), PHP_INT_MAX, 3 );
		add_filter( 'users_list_table_query_args', array( static::class, 'revise_users_columns_query' ), PHP_INT_MAX, 1 );
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

	public static function revise_users_columns_content( string $output, string $column_name, int $user_id ) : string {
		$user = get_userdata( $user_id );
		if ( 'first_name' === $column_name ) {
			return "<span>{$user->first_name}</span>";
		}
		if ( 'last_name' === $column_name ) {
			return "<span>{$user->last_name}</span>";
		}
		return $output;
	}

	public static function revise_users_columns_query( array $args ) : array {
		if ( isset( $args['orderby'] ) && ( 'first_name' === $args['orderby'] || 'last_name' === $args['orderby'] ) ) {
			$args['meta_key'] = $args['orderby'];
		}
		return $args;
	}
}