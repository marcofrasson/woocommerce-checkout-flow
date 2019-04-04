<?php

namespace FlowDigital\WC_Checkout_Flow\Common;

abstract class Abstract_Ajax_Action {
	use Hooker_Trait;

	public function add_hooks () {
		$this->add_action( 'wp_ajax_' . $this->get_action_name(), 'callback' );

		if ( $this->is_public() ) {
			$this->add_action( 'wp_ajax_nopriv_' . $this->get_action_name(), 'callback' );
		}
	}

	abstract public function get_action_name ();

	abstract public function callback ();

	public function is_public () {
		return false;
	}

	protected function send_json_response ( $data, $code = 200 ) {
		if ( $code >= 300 ) {
			\wp_send_json_error( $data, $code );
		} else {
			\wp_send_json_success( $data, $code );
		}
	}
}
