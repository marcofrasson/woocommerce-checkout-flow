<?php

namespace FlowDigital\WC_Checkout_Flow\functions;

function get_file_extension ( $path ) {
	return \strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
}

function create_path ( $path ) {
	$result = \wp_mkdir_p( $path );
	throw_if( ! $result, \Exception::class, "could not create $path" );
	return $result;
}

function get_asset_url ( $file_path ) {
	return \plugins_url( config_get( 'ASSETS_DIR' ) . '/' . $file_path, config_get('MAIN_FILE') );
}
