<?php

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