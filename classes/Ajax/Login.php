<?php

namespace FlowDigital\WC_Checkout_Flow\Ajax;

use FlowDigital\WC_Checkout_Flow\Common\Abstract_Ajax_Action;
use FlowDigital\WC_Checkout_Flow\functions as h;
use FlowDigital\WC_Checkout_Flow\Utils\User;

class Login extends Abstract_Ajax_Action {
	public function get_action_name() {
		return h\prefix( 'ajax_login' );
	}

	public function callback() {
		$email    = h\request_value( 'email', 'post' );
		$password = h\request_value( 'password', 'post' );
		$res      = [
			'message' => '',
		];
		$code     = 200;

		$result = User::login( $email, $password );

		if ( \is_wp_error( $result ) ) {
			$code           = 400;
			$res['message'] = get_option( 'wc_checkout_flow_login_error' );
		} else {
			$res['message'] = get_option( 'wc_checkout_flow_login_success' );
		}

		$this->send_json_response( $res, $code );
	}

	public function is_public() {
		return true;
	}
}
