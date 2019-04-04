<?php

namespace FlowDigital\WC_Checkout_Flow\Utils;

use FlowDigital\WC_Checkout_Flow\functions as h;

class Immutable_Data_Store extends Data_Store {

	public function set( $key, $value ) {
		h\throw_if( $this->has( $key ), \Exception::class, "key \"$key\" already assigned" );

		return parent::set( $key, $value );
	}

	public function clear( $key ) {
		throw new \Exception( 'Can not delete keys' );
	}
}
