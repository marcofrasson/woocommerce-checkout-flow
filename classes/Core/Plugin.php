<?php

namespace FlowDigital\WC_Checkout_Flow\Core;

use FlowDigital\WC_Checkout_Flow\Admin_Page;
use FlowDigital\WC_Checkout_Flow\Common\Hooker_Trait;
use FlowDigital\WC_Checkout_Flow\functions as h;

final class Plugin {
	use Hooker_Trait;

	protected $actived = false;
	protected static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function run() {
		return self::get_instance();
	}

	protected function __construct() {
		if ( $this->has_dependencies() ) {
			$this->add_action( 'plugins_loaded', 'start' );
		} else {
			$this->start();
		}
	}

	public function start() {
		if ( $this->actived ) {
			return;
		}

		$this->add_action( 'init', 'load_plugin_textdomain', 0 );

		if ( $this->has_dependencies() && ! $this->check_dependencies() ) {
			$this->add_action( 'admin_notices', 'print_missing_dependencies_error' );

			return;
		}

		$this->actived = true;

		$this->includes();

		$this->add_action( 'init', 'do_init_hook_action' );

		new Admin_Page();
	}

	protected function includes() {
		require_once h\config_get( 'ROOT_DIR' ) . '/includes/index.php';
	}

	public function load_plugin_textdomain() {
		\load_plugin_textdomain(
			'wc-checkout-flow',
			false,
			\dirname( \plugin_basename( h\config_get( 'MAIN_FILE' ) ) ) . '/languages/'
		);
	}

	public function register_init_hook( $callback, $priority = 10 ) {
		\add_action( $this->get_init_hook_action_name(), $callback, $priority );
	}

	public function do_init_hook_action() {
		\do_action( $this->get_init_hook_action_name(), $this );
	}

	protected function get_init_hook_action_name() {
		return h\prefix( 'plugin_init' );
	}

	public function is_active() {
		return $this->actived;
	}

	public function has_dependencies() {
		return \apply_filters( h\prefix( 'has_dependencies' ), false );
	}

	public function check_dependencies() {
		return \apply_filters( h\prefix( 'check_dependencies' ), false );
	}

	public function print_missing_dependencies_error() {
		$message = \__( 'Missing requirements for %1$s.', 'wc-checkout-flow' );
		$message = sprintf( $message, '<b>' . h\config_get( 'NAME' ) . '</b>' );

		h\include_template( 'admin-notice.php', [
			'message' => \apply_filters( h\prefix( 'missing_dependencies_error_message' ), $message ),
			'class'   => 'error'
		] );
	}

	public function __clone() {
		\_doing_it_wrong( __FUNCTION__, 'Cloning is forbidden.', h\config_get( 'VERSION' ) );
	}

	public function __wakeup() {
		\_doing_it_wrong( __FUNCTION__, 'Unserializing instances of this class is forbidden.', h\config_get( 'VERSION' ) );
	}
}
