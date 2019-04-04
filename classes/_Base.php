<?php

namespace FlowDigital\WC_Checkout_Flow;

use FlowDigital\WC_Checkout_Flow\Common\Hooker_Trait;

class Base {
	use Hooker_Trait;

	public function add_hooks() {
		$this->add_action( 'foo', 'bar' );
	}
}
