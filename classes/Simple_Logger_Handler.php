<?php

namespace FlowDigital\WC_Checkout_Flow;

use FlowDigital\WC_Checkout_Flow\Common\Hooker_Trait;
use FlowDigital\WC_Checkout_Flow\functions as h;

class Simple_Logger_Handler {
	use Hooker_Trait;

	public function add_hooks() {
		$this->add_action( h\prefix( 'handle_log' ), 'handle_log', 10, 3 );
	}

	public function handle_log( $message, $type, $timestamp ) {
		if ( ! $this->is_enabled() ) {
			return;
		}

		$type        = \strtoupper( $type );
		$plugin_slug = h\config_get( 'SLUG' );

		\error_log( "$plugin_slug.$type: $message" );
	}

	public function is_enabled() {
		return WP_DEBUG && \defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG;
	}
}
