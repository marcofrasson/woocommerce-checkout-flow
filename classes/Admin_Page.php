<?php

namespace FlowDigital\WC_Checkout_Flow;

use function FlowDigital\WC_Checkout_Flow\functions\config_get;

class Admin_Page {
	public function __construct() {
		// Create the section beneath the advanced tab
		add_filter( 'woocommerce_get_sections_advanced', array( __CLASS__, 'add_section' ) );

		// Add settings to the specific section we created before
		add_filter( 'woocommerce_get_settings_advanced', array( __CLASS__, 'get_settings' ), 10, 2 );

		// Add action links
		add_filter( 'plugin_action_links_' . plugin_basename( config_get( 'MAIN_FILE' ) ), array(
			__CLASS__,
			'plugin_action_links'
		) );
	}

	public function add_section( $sections ) {
		$sections['wc-checkout-flow'] = __( 'WC Checkout Flow', 'wc-checkout-flow' );

		return $sections;
	}

	public function get_settings( $settings, $current_section ) {
		// Check the current section is what we want
		if ( $current_section != 'wc-checkout-flow' ) {
			return $settings;
		}

		$settings = array();

		// Add title
		$settings[] = array(
			'name' => __( 'Configurações do WC Checkout Flow', 'wc-checkout-flow' ),
			'type' => 'title',
			'desc' => __( 'As opções a seguir são usadas para configurar o WC Checkout Flow', 'wc-checkout-flow' ),
			'id'   => 'wc_checkout_flow'
		);

		// Add plugin options
		$settings[] = array(
			'name' => __( 'Mensagem da confirmação de recuperação de senha', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_lost_password',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Mensagem da confirmação de novo cadastro', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_email_not_found',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Mensagem de confirmação de e-mail já cadastrado', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_email_found',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Mensagem recebida por e-mail da confirmação de novo cadastro', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_new_account',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Mensagem de erro ao tentar fazer login', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_login_error',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Mensagem de login efetuado com sucesso', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_login_success',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Mensagem recebida por e-mail da solicitação de redefinição de senha', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_reset_password',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Mensagem de confirmação da redefinição de senha', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_reset_password_success',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Descrição do formulário de autenticação por e-mail', 'wc-checkout-flow' ),
			'type' => 'textarea',
			'id'   => 'wc_checkout_flow_auth_form_description',
			'css'  => 'min-width: 50%; height: 75px;',
		);

		$settings[] = array(
			'name' => __( 'Classe CSS personalizada para o campo e-mail', 'wc-checkout-flow' ),
			'type' => 'text',
			'id'   => 'wc_checkout_flow_input_class',
			'css'  => 'min-width: 50%;',
		);

		$settings[] = array(
			'title'   => __( 'Remover mensagens de confirmação', 'wc-checkout-flow' ),
			'type'    => 'checkbox',
			'id'      => 'wc_checkout_flow_skip_messages',
			'default' => 'no',
		);


		// End section
		$settings[] = array(
			'type' => 'sectionend',
			'id'   => 'wc_checkout_flow'
		);

		return $settings;
	}

	public static function plugin_action_links( $links ) {
		$plugin_links   = array();
		$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=advanced&section=wc-checkout-flow' ) ) . '">' . __( 'Configurações', 'wc-checkout-flow' ) . '</a>';

		return array_merge( $plugin_links, $links );
	}
}
