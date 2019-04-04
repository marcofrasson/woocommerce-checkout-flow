<?php

namespace FlowDigital\WC_Checkout_Flow;

use FlowDigital\WC_Checkout_Flow\Common\Hooker_Trait;
use FlowDigital\WC_Checkout_Flow\functions as h;

class Plugin_Dependencies {
	use Hooker_Trait;

	protected $missing_dependencies = [];

	public function add_hooks() {
		$this->add_filter( h\prefix( 'has_dependencies' ), 'has_dependencies' );
		$this->add_filter( h\prefix( 'check_dependencies' ), 'check_dependencies' );
		$this->add_filter( h\prefix( 'missing_dependencies_error_message' ), 'get_error_message' );
	}

	public function has_dependencies( $result ) {
		return true;
	}

	public function check_dependencies( $result ) {
		$deps   = [
			// requires PHP 7.0+
			'php' => $this->compare_php_version( '7.0' ),

			// requires WooCommerce
			'wc'  => function_exists( 'WC' ),
		];
		$result = true;

		foreach ( $deps as $dep => $bool ) {
			if ( ! $bool ) {
				$result = false;
				h\log_error( 'Missing plugin dependency:', $dep );
				$this->missing_dependencies[] = $dep;
			}
		}

		return $result;
	}

	public function get_error_message( $message ) {
		foreach ( $this->missing_dependencies as $dep ) {
			$errors[] = $this->get_error_by_dependency( $dep );
		}

		if ( ! empty( $errors ) ) {
			$margin  = \str_repeat( '&nbsp;', 4 );
			$message .= '<br><em>' . \__( 'Follow this instructions:', 'wc-checkout-flow' ) . '</em><br>';
			$message .= $margin;
			$message .= \implode( "<br>$margin", $errors );
		}

		return $message;
	}

	protected function get_error_by_dependency( $dep ) {
		$message = '';

		switch ( $dep ) {
			case 'php':
				$message = \__( 'Use PHP v7.0+', 'wc-checkout-flow' );
				break;

			case 'wc':
				$message = \__( 'Requires WooCommerce', 'wc-checkout-flow' );
				break;

			default:
				$message = \__( 'Unknow dependency', 'wc-checkout-flow' );
		}

		return $message;
	}

	protected function compare_version( $version1, $version2, $operator = '>=' ) {
		return version_compare( strtolower( $version1 ), strtolower( $version2 ), $operator );
	}

	protected function compare_php_version( $min_version ) {
		return $this->compare_version( PHP_VERSION, $min_version, '>=' );
	}

}
