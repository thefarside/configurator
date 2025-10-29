<?php

namespace Configurator\Modules\FSE;

class FSE_Profile_Name_Display_Name {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		add_filter( 'unregister_site_editor_panels', array( static::class, 'unregister_site_editor_panels' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		return array_merge( $blocks, array(
			'core/post-author',
			'core/post-author-name',
		) );
	}

	public static function unregister_site_editor_panels( array $panels ) : array {
		return array_merge( $panels, array(
			'//label[contains( text(), "Author" )]/ancestor::div[contains( @class, "editor-post-panel__row-control" )]',
			'//button[contains( text(), "Author" )]/ancestor::div[contains( @class, "editor-post-panel__row-control" )]',
			'//span[contains( text(), "Author" )]/ancestor::div[contains( @role, "menuitemcheckbox" )]',
			'//span[contains( text(), "Author" )]/ancestor::div[contains( @role, "menuitem" )]',
		) );
	}
}