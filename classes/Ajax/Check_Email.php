<?php

namespace FlowDigital\WC_Checkout_Flow\Ajax;

use FlowDigital\WC_Checkout_Flow\Common\Abstract_Ajax_Action;
use FlowDigital\WC_Checkout_Flow\functions as h;
use FlowDigital\WC_Checkout_Flow\Utils\User;

class Check_Email extends Abstract_Ajax_Action {
	public function get_action_name() {
		return h\prefix( 'ajax_check_email' );
	}

	public function callback() {
		$email        = h\request_value( 'email', 'post' );
		$res          = [
			'user_created' => false,
			'message'      => '',
		];
		$code         = 200;
		$email_exists = \email_exists( $email );
		$messages     = $this->get_response_messages();

		if ( $email_exists ) {
			$res['message'] = $messages['found'];
		} else {
			$result = User::register( $email, true );

			if ( \is_wp_error( $result ) ) {
				$code           = 400;
				$res['message'] = __( 'E-mail inválido. Por favor, tente novamente ou entre em contato conosco caso continue dando esse erro.', 'wc-checkout-flow' );
			} else {
				$res['user_created'] = true;
				$res['message']      = $messages['not_found'];
			}
		}

		$this->send_json_response( $res, $code );
	}

	protected function get_response_messages() {
		$messages = [
			'not_found' => get_option( 'wc_checkout_flow_email_not_found' ),
			'found'     => get_option( 'wc_checkout_flow_email_found' ),
		];

		foreach ( $messages as $key => $value ) {
			$messages[ $key ] = \apply_filters( h\prefix( 'message_' ) . $key . '_email', $value );
		}

		return $messages;
	}

	public function is_public() {
		return true;
	}
}
