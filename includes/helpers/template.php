<?php

namespace FlowDigital\WC_Checkout_Flow\functions;

/**
 * A helper to include PHP files with custom data
 */
function include_php_template( $template_path, $data = [] ) {
	$template_base_path = config_get( 'ROOT_DIR' ) . '/' . config_get( 'TEMPLATES_DIR' );
	$template_path      = "$template_base_path/$template_path";
	$data               = apply_filters( prefix( 'template_default_data' ), $data );

	extract( $data, \EXTR_OVERWRITE );
	include $template_path;
}

/**
 * An safe and simple template engine (only replacement of variables
 * use {{ var }} to safe/scaped values and {{ !var }} to non-scaped values.
 *
 * see: https://github.com/luizbills/wp-plugin-skeleton/blob/master/src/templates/admin-notice.php
 */
function include_template( $template_path, $data = [] ) {
	render_template( $template_path, $data, true );
}

function render_template( $template_path, $data = [], $echo = false ) {
	$template_base_path = config_get( 'ROOT_DIR' ) . '/' . config_get( 'TEMPLATES_DIR' );
	$template_path      = "$template_base_path/$template_path";
	$template_string    = \file_get_contents( $template_path );
	$data               = apply_filters( prefix( 'template_default_data' ), $data );
	$result             = render_template_string( $template_string, $data );
	if ( $echo ) {
		echo $result;
	}

	return $result;
}

function render_template_string( $string, $data = [] ) {
	$result  = $string;
	$matches = null;
	$regex   = '/{{(.*?)}}/';
	$find    = [];
	$replace = [];

	if ( preg_match_all( $regex, $string, $matches ) ) {
		foreach ( $matches[0] as $index => $variable ) {
			$key    = trim( $matches[1][ $index ] );
			$find[] = $variable;
			$escape = '!' !== $key[0];

			if ( ! $escape ) {
				$key[0] = ' ';
				$key    = trim( $key );
			}

			if ( isset( $data[ $key ] ) ) {
				$replace[] = $escape ? esc_html( $data[ $key ] ) : $data[ $key ];
			} else {
				$replace[] = '';
			}
		}
	}

	if ( count( $find ) > 0 ) {
		$result = str_replace( $find, $replace, $result );
	}

	return $result;
}
