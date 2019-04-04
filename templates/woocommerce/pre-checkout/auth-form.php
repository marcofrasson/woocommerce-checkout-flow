<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use FlowDigital\WC_Checkout_Flow\functions as h;

$input_class         = get_option( 'wc_checkout_flow_input_class' );
$submit_button_label = esc_html__( 'Continuar', 'wc-checkout-flow' );

?>

<div class="wc-checkout-flow-container" style="max-width: 640px; margin: auto;">
    <noscript>
        <ul class="woocommerce-error" role="alert">
            <li>
				<?= wc_kses_notice( __( 'O formulário abaixo não irá funciona pois ele necessita que o JavaScript do seu navegador esteja ativado.', 'wc-checkout-flow' ) ) ?>
            </li>
        </ul>
    </noscript>

    <h2><?= esc_html__( 'Para finalizar sua compra informe seu e-mail', 'wc-checkout-flow' ) ?></h2>

    <section class="wc-checkout-flow-messages"></section>

	<?php do_action( 'before_wc_checkout_flow_auth_form' ); ?>

    <form action="post" class="woocommerce-form wc-checkout-flow-auth-form">
        <p class="form-row form-row-wide wc-checkout-flow-form-email">
            <label for="email"><?= esc_html__( 'E-mail', 'wc-checkout-flow' ) ?></label>
            <input type="email"
                   class="woocommerce-Input woocommerce-Input--text input-text<?= $input_class ? ' ' . sanitize_html_class( $input_class ) : '' ?>"
                   name="email"
                   id="email"
                   autocomplete="off" value="" required>
        </p>

        <p class="form-row wc-checkout-flow-form-submit">
            <input type="hidden" id="wc_checkout_flow_action" value="check_email">
            <button type="submit" class="woocommerce-Button button"><?= $submit_button_label ?></button>
        </p>
    </form>

    <div class="wc-checkout-flow-auth-form-description">
		<?= get_option( 'wc_checkout_flow_auth_form_description' ) ?>
    </div>

	<?php do_action( 'after_wc_checkout_flow_auth_form' ); ?>

    <template id="template_wc_checkout_flow_password_input">
        <p class="form-row form-row-wide wc-checkout-flow-form-email">
            <label for="password"><?= esc_html__( 'Senha', 'wc-checkout-flow' ) ?></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                   id="password" autocomplete="off" value="" required>
        </p>
        <p class="form-row form-row-wide woocommerce-LostPassword lost_password">
            <a class="lost-password-link" href="#"><?= esc_html__( 'Perdeu sua senha?', 'wc-checkout-flow' ) ?></a>
        </p>
    </template>

    <template id="template_wc_checkout_flow_message_lost_password">
		<?php
		$message = get_option( 'wc_checkout_flow_lost_password' );
		$message = apply_filters( h\prefix( 'message_lost_password' ), $message );
		?>
        <span class="lost-email-message"><?= wc_kses_notice( $message ) ?></span>
    </template>
</div>
