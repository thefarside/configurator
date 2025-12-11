<?php
/**
 * Module Name: FSE Editor Patterns Remote
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-editor-patterns-remote.php
 * Version: 0.0.1
 * Description: Disables use of remote patterns with Gutenberg editors.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules\FSE;

use Configurator\Helpers\Return_Types;

class FSE_Editor_Patterns_Remote {

	public static function initialize() : void {
		add_filter( 'should_load_remote_block_patterns', array( Return_Types::class, 'return_false' ) );
	}
}