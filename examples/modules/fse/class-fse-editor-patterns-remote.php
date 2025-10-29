<?php

namespace Configurator\Modules\FSE;

use Configurator\Helpers\Return_Types;

class FSE_Editor_Patterns_Remote {

	public static function initialize() : void {
		add_filter( 'should_load_remote_block_patterns', array( Return_Types::class, 'return_false' ) );
	}
}