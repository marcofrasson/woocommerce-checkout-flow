<?php

namespace FlowDigital\WC_Checkout_Flow\Ajax;

use FlowDigital\WC_Checkout_Flow\Common\Abstract_Ajax_Action;
use FlowDigital\WC_Checkout_Flow\Utils\User;
use FlowDigital\WC_Checkout_Flow\functions as h;

class Recover_Password extends Abstract_Ajax_Action {
	public function get_action_name () {
		return h\prefix( 'ajax_recover_password' );
	}

	public function callback () {
		$email = h\request_value( 'email', 'post' );
		$res = [];
		$code = 200;
		$email_exists = User::email_exists( $email );

		if ( $email_exists ) {
			User::send_email_reset_password( $email );
		}

		$this->send_json_response($res, $code);
	}

	public function is_public () {
		return true;
	}
}
