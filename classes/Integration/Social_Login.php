<?php

namespace FlowDigital\WC_Checkout_Flow\Integration;

use FlowDigital\WC_Checkout_Flow\Common\Hooker_Trait;
use FlowDigital\WC_Checkout_Flow\functions as h;

class Social_Login {
	use Hooker_Trait;

	public function add_hooks () {
		$this->add_action( 'after_wc_checkout_flow_form', 'print_social_login_buttons' );
	}

	public function print_social_login_buttons () {
		$social_login_title = \__( 'Ou use uma das suas Redes Sociais', 'wc-checkout-flow' );
		$social_login_title = \apply_filters( h\prefix( 'social_login_title' ), $social_login_title );
		$social_login_title = \esc_html( $social_login_title );
		if ( \function_exists( 'YITH_WC_Social_Login_Frontend' ) ) {
			echo "<h3>$social_login_title</h3>";
			\YITH_WC_Social_Login_Frontend()->social_buttons('social-icons');
		}
	}
}
