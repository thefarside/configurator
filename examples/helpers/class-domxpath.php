<?php
/**
 * Module Name: DomXPath
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/helpers/class-domxpath.php
 * Version: 0.0.1
 * Description: Extends DomXPath to include querySelector(), which returns the null-safe first query result.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: \DOMNode, \DOMXPath
 */

namespace Configurator\Helpers;

use DOMNode;

class DOMXPath extends \DOMXPath {

	public function querySelector( string $expression, ?DOMNode $contextNode = null, bool $registerNodeNS = true ) : ?DOMNode {
		$result = $this->query( $expression, $contextNode, $registerNodeNS );
		if ( $result->length ) {
			return $result->item( 0 );
		}
		return null;
	}
}