<?php

namespace FlowDigital\WC_Checkout_Flow\Core;

use Symfony\Component\Yaml\Yaml;
use FlowDigital\WC_Checkout_Flow\Utils\Immutable_Data_Store;
use FlowDigital\WC_Checkout_Flow\functions as h;

class Config {
	protected static $options = null;

	public static function get_options () {
		if ( null === self::$options ) {
			self::$options = new Immutable_Data_Store();
		}
		return self::$options;
	}

	public static function setup ( $MAIN_FILE ) {
		if ( ! null === self::$options ) return;

		$root = \dirname( $MAIN_FILE );
		$plugin_config = Yaml::parseFile( $root . '/plugin.yml' );
		$plugin_slug = h\str_slug( $plugin_config['NAME'] );
		$plugin_prefix = h\str_slug( $plugin_config['NAME'], '_' ) . '_';
		$options = self::get_options();

		$options->set( 'SLUG', $plugin_slug );
		$options->set( 'PREFIX', $plugin_prefix );
		$options->set( 'MAIN_FILE', $MAIN_FILE );
		$options->set( 'ROOT_DIR', $root );

		foreach ( $plugin_config as $key => $value ) {
			$options->set( $key, $value );
		}
	}

	public static function set ( $key, $value ) {
		return self::get_options()->set( $key, $value );
	}

	public static function get ( $key, $default = null ) {
		if ( self::get_options()->has( $key ) ) {
			return self::get_options()->get( $key );
		}
		h\throw_if( null === $default, \Exception::class, "not found \"$key\"" );
		return $default;
	}
}
