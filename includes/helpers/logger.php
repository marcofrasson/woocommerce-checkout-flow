<?php

namespace FlowDigital\WC_Checkout_Flow\functions;

function log_debug() {
	_log( \func_get_args(), 'debug' );
}

function log_info() {
	_log( \func_get_args(), 'info' );
}

function log_warn() {
	_log( \func_get_args(), 'warning' );
}

function log_error() {
	_log( \func_get_args(), 'error' );
}

/* Internal Helpers */

// You can create your own log handler
// see: https://github.com/luizbills/wp-plugin-skeleton/blob/master/src/classes/Simple_Logger_Handler.php
function _handle_log( $message, $type, $timestamp ) {
	\do_action( prefix( 'handle_log' ), $message, $type, $timestamp );
}

function enable_logger() {
	\add_filter( prefix( 'logger_enabled' ), '_return_true', 100 );
}

function disable_logger() {
	\add_filter( prefix( 'logger_enabled' ), '_return_false', 100 );
}

function _log( $args, $type ) {
	$is_enabled = \apply_filters( prefix( 'logger_enabled' ), true, $type );

	$args    = \is_array( $args ) ? $args : [ $args ];
	$message = '';
	foreach ( $args as $arg ) {
		if ( null === $arg ) {
			$message .= 'Null';
		} elseif ( \is_bool( $arg ) ) {
			$message .= $arg ? 'True' : 'False';
		} elseif ( ! \is_string( $arg ) ) {
			$message .= print_r( $arg, true );
		} else {
			$message .= $arg;
		}
		$message .= ' ';
	}

	_handle_log( $message, $type, \time() );
}
