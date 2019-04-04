<?php

namespace FlowDigital\WC_Checkout_Flow;

use FlowDigital\WC_Checkout_Flow\functions as h;


$assets = h\assets();

// Frontend css
$assets->add( h\get_asset_url( 'css/frontend.css' ), [ 'in_admin' => false ] );

// Frontend javascript
$assets->add(
	h\get_asset_url( 'js/frontend.js' ),
	[
		'in_admin'    => false,
		'script_data' => [
			'ajax_url'      => admin_url( 'admin-ajax.php' ),
			'prefix'        => h\prefix( '' ),
			'debug'         => WP_DEBUG,
			'skip_messages' => get_option( 'wc_checkout_flow_skip_messages', 'no' )
		]
	]
);

// Auth_Form
$auth_form = h\config_set( '$auth_form', new Auth_Form() );
$auth_form->add_hooks();

// Reset_Password_Form
$reset_pass_form = h\config_set( '$reset_pass_form', new Reset_Password_Form() );
$reset_pass_form->add_hooks();

// Password_Validator
$password_validator = h\config_set( '$password_validator', new Password_Validator() );
$password_validator->add_hooks();

// Ajax\Check_Email
$ajax_check_email = h\config_set( '$ajax_check_email', new Ajax\Check_Email() );
$ajax_check_email->add_hooks();

// Ajax\Login
$ajax_login = h\config_set( '$ajax_login', new Ajax\Login() );
$ajax_login->add_hooks();

// Ajax\Recover_Password
$ajax_recover_password = h\config_set( '$ajax_recover_password', new Ajax\Recover_Password() );
$ajax_recover_password->add_hooks();

// Ajax\Reset_Password
$ajax_reset_password = h\config_set( '$ajax_reset_password', new Ajax\Reset_Password() );
$ajax_reset_password->add_hooks();

// Integration\Social_Login
$integ_social_login = h\config_set( '$integ_social_login', new Integration\Social_Login() );
$integ_social_login->add_hooks();
