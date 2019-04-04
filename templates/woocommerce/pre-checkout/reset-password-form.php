<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wc-checkout-flow-container" style="max-width: 640px; margin: auto;">

	<?php if ( $invalid_hash ) : ?>

        <ul class="woocommerce-error" role="alert">
            <li>
				<?= wc_kses_notice( __( 'Este link expirou.', 'wc-checkout-flow' ) ) ?>
            </li>
        </ul>

	<?php else : ?>

        <noscript>
            <ul class="woocommerce-error" role="alert">
                <li>
					<?= wc_kses_notice( __( 'O formulário abaixo não irá funciona pois ele necessita que o JavaScript do seu navegador esteja ativado.', 'wc-checkout-flow' ) ) ?>
                </li>
            </ul>
        </noscript>

        <h2><?php esc_html_e( 'Escolha sua nova senha', 'wc-checkout-flow' ); ?></h2>

        <section class="wc-checkout-flow-messages"></section>

		<?php do_action( 'before_wc_checkout_flow_reset_password_form' ); ?>

        <form action="post" class="woocommerce-form wc-checkout-flow-reset-password-form">
            <p class="form-row form-row-wide wc-checkout-flow-form-email">
                <label for="password"><?php esc_html_e( 'Senha', 'wc-checkout-flow' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                       id="password" autocomplete="off" value="" required>
            </p>

            <p class="form-row form-row-wide wc-checkout-flow-form-email">
                <label for="password2"><?php esc_html_e( 'Confirmar Senha', 'wc-checkout-flow' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password2"
                       id="password2" autocomplete="off" value="" required>
            </p>

            <p class="form-row wc-checkout-flow-form-submit">
                <button type="submit"
                        class="woocommerce-Button button"><?php esc_html_e( 'Trocar Senha', 'wc-checkout-flow' ); ?></button>
            </p>

            <input type="hidden" name="hash" value="<?= esc_attr( $hash ) ?>">
        </form>

		<?php do_action( 'after_wc_checkout_flow_reset_password_form' ); ?>

	<?php endif; ?>
</div>
