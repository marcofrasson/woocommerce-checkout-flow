<?php

namespace FlowDigital\WC_Checkout_Flow;

use FlowDigital\WC_Checkout_Flow\functions as h;

// init the loggers
$logger_handler = h\config_set( '$logger_handler', new Simple_Logger_Handler() );
$logger_handler->add_hooks();

// check plugin dependencies
$deps = h\config_set( '$deps', new Plugin_Dependencies() );
$deps->add_hooks();

// plugin state hooks
$_FILE = h\config_get( 'MAIN_FILE' );

// wc template path
h\config_set( 'WC_TEMPLATE_PATH', h\config_get( 'ROOT_DIR' ) . '/templates/woocommerce/' );

register_activation_hook( $_FILE, __NAMESPACE__ . '\on_plugin_activated' );

function on_plugin_activated() {
	if ( ! get_option( 'wc_checkout_flow_lost_password' ) ) {
		$message = 'Dentro de alguns instantes você receberá um e-mail com o link para redefinir sua senha.';
		update_option( 'wc_checkout_flow_lost_password', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_email_not_found' ) ) {
		$message = 'Um novo cadastro foi feito usando este seu e-mail e enviamos sua senha por email. Você está sendo redirecionado para finalizar sua compra.';
		update_option( 'wc_checkout_flow_email_not_found', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_email_found' ) ) {
		$message = 'Este e-mail já possui um cadastro. Por favor, informe sua senha ou clique no link "Perdeu sua senha?" que enviaremos um email para você redefinir sua senha.';
		update_option( 'wc_checkout_flow_email_found', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_new_account' ) ) {
		$message = '<p>Olá, [username].</p><p>Obrigado por criar um conta em [shop_name]. O seu nome de usuário é <strong>[username]</strong>. Você pode acessar sua conta para ver pedidos, alterar sua senha e muito mais em: <a href="[my_account_page_url]">[my_account_page_url]</a></p><p>Sua senha foi gerada automaticamente: <strong>[password]</strong></p>';
		update_option( 'wc_checkout_flow_new_account', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_login_error' ) ) {
		$message = 'E-mail ou senha inválidos. Por favor, tente novamente, redefina sua senha ou entre em contato conosco caso continue dando esse erro.';
		update_option( 'wc_checkout_flow_login_error', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_login_success' ) ) {
		$message = 'Muito obrigado por entrar com sua conta. Você está sendo redirecionado para finalizar sua compra.';
		update_option( 'wc_checkout_flow_login_success', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_reset_password' ) ) {
		$message = '<p>Olá, [username].</p><p>Alguém solicitou uma nova senha para a sua conta em [shop_name].</p><p>Se você não fez essa solicitação, ignore este e-mail. Se você gostaria de prosseguir, acesse o link abaixo:</p><p><a href="[reset_password_url]">[reset_password_label]</a></p>';
		update_option( 'wc_checkout_flow_reset_password', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_reset_password_success' ) ) {
		$message = 'Sua senha foi redefinida com sucesso. Você está sendo redirecionado para finalizar sua compra.';
		update_option( 'wc_checkout_flow_reset_password_success', $message );
	}

	if ( ! get_option( 'wc_checkout_flow_auth_form_description' ) ) {
		$message = '<h4>Usamos seu e-mail de forma 100% segura para:</h4><ul><li>Identificar seu perfil</li><li>Notificar sobre o andamento de seu pedido</li><li>Gerenciar seu histórico de compras</li><li>Acelerar o preenchimento de suas informações</li></ul>';
		update_option( 'wc_checkout_flow_auth_form_description', $message );
	}
}

/*register_deactivation_hook( $_FILE, __NAMESPACE__ . '\on_plugin_deactivated' );
function on_plugin_deactivated () {

}

register_uninstall_hook( $_FILE, __NAMESPACE__ . '\on_plugin_uninstalled' );
function on_plugin_uninstalled () {

}*/
